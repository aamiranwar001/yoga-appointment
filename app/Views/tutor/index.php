<!doctype html>
<html lang="en" >
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?= base_url('css/views/register.css') ?>" >
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" >
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" />
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />

    <title>Yoga Appointments | Main Page</title>

    <style>
        #calendar {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 5px;
            top: 64px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?= route_to('home') ?>">Yoga Appointments</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="<?= route_to('home') ?>">Homes</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <div id="calendar" class="vh-100">

    </div>
</div>

<script src="<?= base_url('js/jquery-3.5.1.slim.min.js') ?>" > </script>
<script src="<?= base_url('js/popper.min.js') ?>" ></script>
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
<script src="https://uicdn.toast.com/tui.code-snippet/v1.5.2/tui-code-snippet.min.js"></script>
<script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
<script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
<script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>
<script>
    let $calEl = $('#calendar').tuiCalendar({
        defaultView: 'month',
        taskView: true,
        template: {
            monthDayname: function (dayname) {
                return '<span class="calendar-week-dayname-name">' + dayname.label + '</span>';
            }
        }
    });

    let calendar = $calEl.data('tuiCalendar');
    calendar.createSchedules([
        {
            id: '1',
            calendarId: '1',
            title: 'my schedule',
            category: 'time',
            dueDateClass: '',
            start: '2018-01-18T22:30:00+09:00',
            end: '2018-01-19T02:30:00+09:00'
        },
        {
            id: '2',
            calendarId: '1',
            title: 'second schedule',
            category: 'time',
            dueDateClass: '',
            start: '2018-01-18T17:30:00+09:00',
            end: '2018-01-19T17:31:00+09:00',
            isReadOnly: true    // schedule is read-only
        }
    ]);
</script>
</body>
</html>