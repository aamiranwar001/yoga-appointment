'use strict';

/* eslint-disable */
/* eslint-env jquery */
/* global moment, tui, chance */
/* global findCalendar, CalendarList, ScheduleList, generateSchedule */

(function(window, Calendar) {
    let cal, resizeThrottled;
    let useCreationPopup = false;
    let useDetailPopup = false;
    let datePicker, selectedCalendar;
    let CalendarList = [];
    let ScheduleList = [];

    let slotHours = [-1, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];


    var templates = {
        popupDetailDate: function(isAllDay, start, end) {
          var endFormat = 'hh:mm a';
    
          return (moment(start._date).format('DD-MMM-YYYY hh:mm a') + ' - ' + moment(end._date).format(endFormat));
        },
        popupDetailBody: function(schedule) {
          return 'Description : ' + schedule.body;
        },
        popupDetailState: function(schedule) {
          return 'State : ' + schedule.state || 'Busy';
        }
      };

    cal = new Calendar('#calendar', {
        defaultView: 'month',
        useCreationPopup: useCreationPopup,
        useDetailPopup: useDetailPopup,
        template: templates
    });

    // event handlers
    cal.on('clickSchedule', function (event) {
        let schedule = event.schedule;
        var endFormat = 'hh:mm a';
        var dateTime= (moment(schedule.start._date).format('DD-MMM-YYYY hh:mm a') + ' - ' + moment(schedule.end._date).format(endFormat));

        $('#scheduleModal #scheduleId').val(schedule.id);
        $('#scheduleModal #title').text(schedule.title);
        $('#scheduleModal #dateTime').text(dateTime);
        $('#scheduleModal #description').text(schedule.body);
        $('#scheduleModal #status').text(schedule.state);

        if(schedule.state == "pending") $('#scheduleModal #status').addClass('orange');
        else if(schedule.state == "cancelled") $('#scheduleModal #status').addClass('red');
        else $('#scheduleModal #status').addClass('green');
        

        // hide accept/reject buttons for student
        if(operatorKey === 'student_id'){
            $('#approveBtn').hide();
            $('#rejectBtn').hide();
        }
        $('#scheduleModal').modal('show');
    });

    function findCalendar(id) {
        var found;
    
        CalendarList.forEach(function(calendar) {
            if (calendar.id === id) {
                found = calendar;
            }
        });
    
        return found || CalendarList[0];
    }

    /**
     * A listener for click the menu
     * @param {Event} e - click event
     */
    function onClickMenu(e) {
        var target = $(e.target).closest('a[role="menuitem"]')[0];
        var action = getDataAction(target);
        var options = cal.getOptions();
        var viewName = '';

        switch (action) {
            case 'toggle-daily':
                viewName = 'day';
                break;
            case 'toggle-weekly':
                viewName = 'week';
                break;
            case 'toggle-monthly':
                options.month.visibleWeeksCount = 0;
                viewName = 'month';
                break;
            case 'toggle-weeks2':
                options.month.visibleWeeksCount = 2;
                viewName = 'month';
                break;
            case 'toggle-weeks3':
                options.month.visibleWeeksCount = 3;
                viewName = 'month';
                break;
            case 'toggle-narrow-weekend':
                options.month.narrowWeekend = !options.month.narrowWeekend;
                options.week.narrowWeekend = !options.week.narrowWeekend;
                viewName = cal.getViewName();

                target.querySelector('input').checked = options.month.narrowWeekend;
                break;
            case 'toggle-start-day-1':
                options.month.startDayOfWeek = options.month.startDayOfWeek ? 0 : 1;
                options.week.startDayOfWeek = options.week.startDayOfWeek ? 0 : 1;
                viewName = cal.getViewName();

                target.querySelector('input').checked = options.month.startDayOfWeek;
                break;
            case 'toggle-workweek':
                options.month.workweek = !options.month.workweek;
                options.week.workweek = !options.week.workweek;
                viewName = cal.getViewName();

                target.querySelector('input').checked = !options.month.workweek;
                break;
            default:
                break;
        }

        cal.setOptions(options, true);
        cal.changeView(viewName, true);

        setDropdownCalendarType();
        setRenderRangeText();
        setSchedules();
    }

    function onClickNavi(e) {
        var action = getDataAction(e.target);

        switch (action) {
            case 'move-prev':
                cal.prev();
                break;
            case 'move-next':
                cal.next();
                break;
            case 'move-today':
                cal.today();
                break;
            default:
                return;
        }

        setRenderRangeText();
        setSchedules();
    }

    //TODO: Remove after implementation
    function onNewSchedule() {
        var title = $('#new-schedule-title').val();
        var location = $('#new-schedule-location').val();
        var isAllDay = document.getElementById('new-schedule-allday').checked;
        var start = datePicker.getStartDate();
        var end = datePicker.getEndDate();
        var calendar = selectedCalendar ? selectedCalendar : CalendarList[0];

        if (!title) {
            return;
        }

        cal.createSchedules([{
            id: String(1),
            calendarId: calendar.id,
            title: title,
            isAllDay: isAllDay,
            start: start,
            end: end,
            category: isAllDay ? 'allday' : 'time',
            dueDateClass: '',
            color: calendar.color,
            bgColor: calendar.bgColor,
            dragBgColor: calendar.bgColor,
            borderColor: calendar.borderColor,
            raw: {
                location: location
            },
            state: 'Free'
        }]);

        $('#modal-new-schedule').modal('hide');
    }

    function onChangeNewScheduleCalendar(e) {
        var target = $(e.target).closest('a[role="menuitem"]')[0];
        var calendarId = getDataAction(target);
        changeNewScheduleCalendar(calendarId);
    }

    function changeNewScheduleCalendar(calendarId) {
        var calendarNameElement = document.getElementById('calendarName');
        var calendar = findCalendar(calendarId);
        var html = [];

        html.push('<span class="calendar-bar" style="background-color: ' + calendar.bgColor + '; border-color:' + calendar.borderColor + ';"></span>');
        html.push('<span class="calendar-name">' + calendar.name + '</span>');

        calendarNameElement.innerHTML = html.join('');

        selectedCalendar = calendar;
    }

    function onChangeCalendars(e) {
        var calendarId = e.target.value;
        var checked = e.target.checked;
        var viewAll = document.querySelector('.lnb-calendars-item input');
        var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));
        var allCheckedCalendars = true;

        if (calendarId === 'all') {
            allCheckedCalendars = checked;

            calendarElements.forEach(function(input) {
                var span = input.parentNode;
                input.checked = checked;
                span.style.backgroundColor = checked ? span.style.borderColor : 'transparent';
            });

            CalendarList.forEach(function(calendar) {
                calendar.checked = checked;
            });
        } else {
            findCalendar(calendarId).checked = checked;

            allCheckedCalendars = calendarElements.every(function(input) {
                return input.checked;
            });

            if (allCheckedCalendars) {
                viewAll.checked = true;
            } else {
                viewAll.checked = false;
            }
        }

        refreshScheduleVisibility();
    }

    function refreshScheduleVisibility() {
        var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarList input'));

        CalendarList.forEach(function(calendar) {
            cal.toggleSchedules(calendar.id, !calendar.checked, false);
        });

        cal.render(true);

        calendarElements.forEach(function(input) {
            var span = input.nextElementSibling;
            span.style.backgroundColor = input.checked ? span.style.borderColor : 'transparent';
        });
    }

    function setDropdownCalendarType() {
        var calendarTypeName = document.getElementById('calendarTypeName');
        var calendarTypeIcon = document.getElementById('calendarTypeIcon');
        var options = cal.getOptions();
        var type = cal.getViewName();
        var iconClassName;

        if (type === 'day') {
            type = 'Daily';
            iconClassName = 'calendar-icon ic_view_day';
        } else if (type === 'week') {
            type = 'Weekly';
            iconClassName = 'calendar-icon ic_view_week';
        } else if (options.month.visibleWeeksCount === 2) {
            type = '2 weeks';
            iconClassName = 'calendar-icon ic_view_week';
        } else if (options.month.visibleWeeksCount === 3) {
            type = '3 weeks';
            iconClassName = 'calendar-icon ic_view_week';
        } else {
            type = 'Monthly';
            iconClassName = 'calendar-icon ic_view_month';
        }

        calendarTypeName.innerHTML = type;
        calendarTypeIcon.className = iconClassName;
    }

    function currentCalendarDate(format) {
      var currentDate = moment([cal.getDate().getFullYear(), cal.getDate().getMonth(), cal.getDate().getDate()]);

      return currentDate.format(format);
    }

    function setRenderRangeText() {
        var renderRange = document.getElementById('renderRange');
        var options = cal.getOptions();
        var viewName = cal.getViewName();

        var html = [];
        if (viewName === 'day') {
            html.push(currentCalendarDate('YYYY.MM.DD'));
        } else if (viewName === 'month' &&
            (!options.month.visibleWeeksCount || options.month.visibleWeeksCount > 4)) {
            html.push(currentCalendarDate('YYYY.MM'));
        } else {
            html.push(moment(cal.getDateRangeStart().getTime()).format('YYYY.MM.DD'));
            html.push(' ~ ');
            html.push(moment(cal.getDateRangeEnd().getTime()).format(' MM.DD'));
        }
        renderRange.innerHTML = html.join('');
    }

    function setSchedules() {
        cal.clear();
        generateSchedule(cal.getViewName(), cal.getDateRangeStart(), cal.getDateRangeEnd(), function() {
            cal.createSchedules(ScheduleList);
        });

        refreshScheduleVisibility();
    }

    function setEventListener() {
        $('#menu-navi').on('click', onClickNavi);
        $('.dropdown-menu a[role="menuitem"]').on('click', onClickMenu);
        $('#lnb-calendars').on('change', onChangeCalendars);

        $('#btn-save-schedule').on('click', onNewSchedule);

        $('#dropdownMenu-calendars-list').on('click', onChangeNewScheduleCalendar);

        window.addEventListener('resize', resizeThrottled);
    }

    function getDataAction(target) {
        return target.dataset ? target.dataset.action : target.getAttribute('data-action');
    }
    
    function CalendarInfo() {
        this.id = null;
        this.name = null;
        this.checked = true;
        this.color = null;
        this.bgColor = null;
        this.borderColor = null;
        this.dragBgColor = null;
    }
    
    function addCalendar(calendar) {
        CalendarList.push(calendar);
    }

    resizeThrottled = tui.util.throttle(function() {
        cal.render();
    }, 50);

    function addDefaultCalendar(){
        var calendar;
        var id = 0;

        calendar = new CalendarInfo();
        id += 1;
        calendar.id = String(id);
        calendar.name = 'Appointments';
        calendar.color = '#ffffff';
        calendar.bgColor = '#9e5fff';
        calendar.dragBgColor = '#9e5fff';
        calendar.borderColor = '#9e5fff';
        addCalendar(calendar);
    }

    function setCalendar (){
        var calendarList = document.getElementById('calendarList');
        var html = [];
        CalendarList.forEach(function(calendar) {
            html.push('<div class="lnb-calendars-item"><label>' +
                '<input type="checkbox" class="tui-full-calendar-checkbox-round" value="' + calendar.id + '" checked>' +
                '<span style="border-color: ' + calendar.borderColor + '; background-color: ' + calendar.borderColor + ';"></span>' +
                '<span>' + calendar.name + '</span>' +
                '</label></div>'
            );
        });
        calendarList.innerHTML = html.join('\n');
    }

    function generateSchedule(viewName, renderStart, renderEnd, successCallback){
        if(cal) {
            var renderStartDate = cal._renderRange.start._date.toLocaleDateString();
            var renderEndDate   = cal._renderRange.end._date.toLocaleDateString();

            ScheduleList= [];
            $.ajax({
                url: appointmentsUrl,
                type: 'GET',
                data: { start_date: renderStartDate, end_date: renderEndDate, operator_key: operatorKey, operator_id: operatorId},
                success: function (data) {
                    const appointments = JSON.parse(data);

                    appointments.forEach(function(appointment){
                        generateScheduleObj(CalendarList[0], appointment);
                    });

                    successCallback();

                    refreshScheduleVisibility();
                },
                error: function (ex) {
                    console.log('Error: ' + ex);
                }
            });
        }
    }

    function ScheduleInfo() {
        this.id = null;
        this.calendarId = null;
    
        this.title = null;
        this.body = null;
        this.isAllday = false;
        this.start = null;
        this.end = null;
        this.category = '';
        this.dueDateClass = '';
    
        this.color = null;
        this.bgColor = null;
        this.dragBgColor = null;
        this.borderColor = null;
        this.customStyle = '';
    
        this.isFocused = false;
        this.isPending = false;
        this.isVisible = true;
        this.isReadOnly = false;
        this.goingDuration = 0;
        this.comingDuration = 0;
        this.recurrenceRule = '';
        this.state = '';
    
        this.raw = {
            memo: '',
            hasToOrCc: false,
            hasRecurrenceRule: false,
            location: null,
            class: 'public', // or 'private'
            creator: {
                name: '',
                avatar: '',
                company: '',
                email: '',
                phone: ''
            }
        };
    }

    function generateTime(schedule, appointment) {

        let startHour = slotHours[appointment.time_slot];
        let endHour = startHour + 1;

        let startDate = moment.unix(appointment.date).set('hour', startHour).set('minute', 0).set('second', 0);
        let endDate = moment.unix(appointment.date).set('hour', endHour).set('minute', 0).set('second', 0);

        schedule.category = 'time';
        schedule.start = startDate.toDate();
        schedule.end = endDate.toDate();
    }

    function generateScheduleObj(calendar, appointment) {
        let schedule = new ScheduleInfo();

        schedule.id = appointment.id;
        schedule.calendarId = calendar.id;
    
        schedule.title = appointment.title;
        schedule.body = appointment.description;
        schedule.isReadOnly = true;

        generateTime(schedule, appointment);

        schedule.isPrivate = true;
        //schedule.recurrenceRule = 'No Rule';
        schedule.state = appointment.status == 'done' ? 'Approved' : appointment.status;
        schedule.color = calendar.color;
        schedule.bgColor = calendar.bgColor;
        schedule.dragBgColor = calendar.dragBgColor;
        schedule.borderColor = calendar.borderColor;

        ScheduleList.push(schedule);
    }

    window.cal = cal;

    setDropdownCalendarType();
    setRenderRangeText();
    setSchedules();
    setEventListener();
    addDefaultCalendar();
    setCalendar();
})(window, tui.Calendar);


function reject(){
    var appointmentId = $('#scheduleModal #scheduleId').val();
    updateStatus(appointmentId, status.cancelled);
}
function approve(){
    var appointmentId = $('#scheduleModal #scheduleId').val();
    updateStatus(appointmentId, status.done);
}

function updateStatus(appointmentId, status) {
    $.ajax({
        url: updateStatusUrl,
        type: 'POST',
        data: { appointment_id: appointmentId, status: status },
        success: function (data) {
            $('.toast .toast-body').text(data.message);
            $('.toast').toast('show');
        },
        error: function (ex) {
            console.log('Error: ' + ex);
        }
    });
}