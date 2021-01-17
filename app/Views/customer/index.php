<?php
    $role = session('userData')['role'];
    $userId = session('userData')['id'];
?>
<!doctype html>
<html lang="en" >
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" >
    <link rel="stylesheet" href="<?= base_url('css/views/appointment.css') ?>" >
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" />
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />

    <title>Yoga Appointments | Main Page</title>
</head>
<body>

<div class="toast" id="toast-alert" data-delay="5000" style="z-index: 999; position: absolute; top: 10px; right: 10px;">
    <div class="toast-header">
        <strong class="mr-auto"><i class="fa fa-grav"></i>Alert</strong>
        <small>Just Now</small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?= route_to('home') ?>">Yoga Appointments</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="<?= route_to('home') ?>">Home</a>
            </li>
            <?php if (session('userData')['role'] == 'admin') { ?>
                <li class="nav-item active"><a class="nav-link" href="<?= route_to('registration') ?>">Register User</a></li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= route_to('newAppointment') ?>">Book Appointment</a>
            </li>
            <li class="nav-item">
			    <a class="nav-link" href="<?= route_to('logout') ?>">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <div id="lnb">
        <div class="lnb-new-schedule">
            <button id="btn-new-schedule" onclick="document.location='<?= route_to('newAppointment') ?>'" type="button" class="btn btn-default btn-block lnb-new-schedule-btn" data-toggle="modal">
                New schedule</button>
        </div>
        <div id="lnb-calendars" class="lnb-calendars">
            <div>
                <div class="lnb-calendars-item">
                    <label>
                        <input class="tui-full-calendar-checkbox-square" type="checkbox" value="all" checked>
                        <span></span>
                        <strong>View all</strong>
                    </label>
                </div>
            </div>
            <div id="calendarList" class="lnb-calendars-d1">
            </div>
        </div>
        <div class="lnb-footer">
            © NHN Corp.
        </div>
    </div>
    <div id="right">
        <div id="menu">
            <span class="dropdown">
                <button id="dropdownMenu-calendarType" class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                    <i id="calendarTypeIcon" class="calendar-icon ic_view_month" style="margin-right: 4px;"></i>
                    <span id="calendarTypeName">Dropdown</span>&nbsp;
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-calendarType">
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-daily">
                            <i class="calendar-icon ic_view_day"></i>Daily
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weekly">
                            <i class="calendar-icon ic_view_week"></i>Weekly
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-monthly">
                            <i class="calendar-icon ic_view_month"></i>Month
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks2">
                            <i class="calendar-icon ic_view_week"></i>2 weeks
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks3">
                            <i class="calendar-icon ic_view_week"></i>3 weeks
                        </a>
                    </li>
                </ul>
            </span>
            <span id="menu-navi">
                <button type="button" class="btn btn-default btn-sm move-today" data-action="move-today">Today</button>
                <button type="button" class="btn btn-default btn-sm move-day" data-action="move-prev">
                    <i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm move-day" data-action="move-next">
                    <i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i>
                </button>
            </span>
            <span id="renderRange" class="render-range"></span>
        </div>
        <div id="calendar"></div>
    </div>


   

<!-- Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size: 16px;">
      <div id="scheduleId" hidden></div>
        <ul>
            <li>
                <b>Time: </b> <span id="dateTime"> </span>
            </li>
            
            <li>
                <div id="statusDiv"><b>Status: </b> <span id="status"> </span></div>
            </li>
            <li>
                <b>Descripton: </b> <span id="description"> </span>
            </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" id="rejectBtn" class="btn btn-danger" onclick="reject()">Reject</button>
        <button type="button" id="approveBtn" class="btn btn-success" onclick="approve()">Approve</button>
      </div>
    </div>
  </div>
</div>
</div>

<script>
    let operatorKey = "<?= $role == 'tutor' ? 'tutor_id' : ($role == 'admin'? 'admin' : 'student_id') ?>"
    let operatorId = "<?= $userId ?>"
    const appointmentsUrl = "<?= base_url('appointments/interval') ?>"
    const updateStatusUrl = "<?= base_url('appointment/status') ?>"
</script>

<script src="<?= base_url('js/jquery-3.5.2.min.js') ?>" > </script>
<script src="<?= base_url('js/popper.min.js') ?>" ></script>
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://uicdn.toast.com/tui.code-snippet/v1.5.2/tui-code-snippet.min.js"></script>
<script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
<script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
<script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>

<script src="<?= base_url('js/store.js') ?>"></script>
<script src="<?= base_url('js/views/appointment.js') ?>"></script>

</body>
</html>