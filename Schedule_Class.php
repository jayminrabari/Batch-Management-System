<?php require ("./comp/session.php");
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

$users_query = "SELECT id, name, role FROM users WHERE role IN ('instructor', 'coordinator')";
$classes_query = "SELECT id, class_name FROM classes";
$resources_query = "SELECT id, resource_name FROM resources WHERE availability = 1";

$users_result = $conn->query($users_query);
$classes_result = $conn->query($classes_query);
$resources_result = $conn->query($resources_query);

if (!$users_result || !$classes_result || !$resources_result) {
    die("Query failed: " . $conn->error);
}

$users = $users_result->fetch_all(MYSQLI_ASSOC);
$classes = $classes_result->fetch_all(MYSQLI_ASSOC);
$resources = $resources_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8" />
    <title>Schedule Class | Batch Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Jaymin Rabari" name="description" />
    <meta content="Jaymin Rabari" name="author" />

    <link rel="shortcut icon" href="assets/images/j small fav.png">
    <script src="assets/js/config.js"></script>
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.15/index.min.css">
</head>

<body>

    <div class="wrapper">

        <?php require './layouts/topbar.php'; ?>
        <?php require './layouts/sidebar.php'; ?>

        <div class="content-page">
            <div class="content">

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Schedule Class</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div id="calendar"></div>
                            </div>
                        </div>

                        <div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog"
                            aria-labelledby="scheduleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="scheduleModalLabel">Schedule Class</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="scheduleForm">

                                            <div class="form-group">
                                                <label for="class_id">Class</label>
                                                <select id="class_id" name="class_id" class="form-control">
                                                    <?php foreach ($classes as $class): ?>
                                                    <option value="<?= htmlspecialchars($class['id']) ?>">
                                                        <?= htmlspecialchars($class['class_name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="instructor_id">Instructor</label>
                                                <select id="instructor_id" name="instructor_id" class="form-control">
                                                    <?php foreach ($users as $user): ?>
                                                    <?php if ($user['role'] === 'instructor'): ?>
                                                    <option value="<?= htmlspecialchars($user['id']) ?>">
                                                        <?= htmlspecialchars($user['name']) ?></option>
                                                    <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="resource_id">Resource</label>
                                                <select id="resource_id" name="resource_id" class="form-control">
                                                    <?php foreach ($resources as $resource): ?>
                                                    <option value="<?= htmlspecialchars($resource['id']) ?>">
                                                        <?= htmlspecialchars($resource['resource_name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="coordinator_id">Coordinator</label>
                                                <select id="coordinator_id" name="coordinator_id" class="form-control">
                                                    <?php foreach ($users as $user): ?>
                                                    <?php if ($user['role'] === 'coordinator'): ?>
                                                    <option value="<?= htmlspecialchars($user['id']) ?>">
                                                        <?= htmlspecialchars($user['name']) ?></option>
                                                    <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="start_time">Start Time</label>
                                                <input type="datetime-local" id="start_time" name="start_time"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="end_time">End Time</label>
                                                <input type="datetime-local" id="end_time" name="end_time"
                                                    class="form-control">
                                            </div>

                                            <input type="hidden" id="event_id" name="event_id" value="">

                                            <button type="submit" class="btn btn-primary">Save Schedule</button>

                                            <button type="button" id="updateButton" class="btn btn-warning"
                                                style="display:none;">Update
                                                Schedule</button>

                                            <button type="button" id="deleteButton" class="btn btn-danger"
                                                style="display:none;">Delete
                                                Schedule</button>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.15/index.global.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            select: function(info) {
                $('#scheduleForm')[0].reset();
                $('#event_id').val('');

                $.ajax({
                    url: 'fetch_available_options.php',
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        start_time: info.startStr,
                        end_time: info.endStr
                    },
                    success: function(data) {
                        $('#instructor_id option').each(function() {
                            if (data.unavailable_instructors.includes($(this)
                                    .val())) {
                                $(this).hide();
                            } else {
                                $(this).show();
                            }
                        });

                        $('#coordinator_id option').each(function() {
                            if (data.unavailable_coordinators.includes($(this)
                                    .val())) {
                                $(this).hide();
                            } else {
                                $(this).show();
                            }
                        });

                        $('#resource_id option').each(function() {
                            if (data.unavailable_resources.includes($(this)
                                    .val())) {
                                $(this).hide();
                            } else {
                                $(this).show();
                            }
                        });

                        $('#start_time').val(info.startStr);
                        $('#end_time').val(info.endStr);
                        $('#scheduleModal').modal('show');
                        $('#updateButton').hide();
                        $('#deleteButton').hide();
                    },
                    error: function() {
                        alert('Failed to fetch available options');
                    }
                });
            },

            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: 'fetch_events.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var events = data.map(function(event) {
                            return {
                                id: event.id,
                                title: event.class_name,
                                start: event.start_time,
                                end: event.end_time,
                                extendedProps: {
                                    class_id: event.class_id,
                                    instructor_id: event.instructor_id,
                                    resource_id: event.resource_id,
                                    coordinator_id: event.coordinator_id
                                }
                            };
                        });
                        successCallback(events);
                    },
                    error: function() {
                        failureCallback('Failed to fetch events');
                    }
                });
            },
            eventClick: function(info) {
                $('#class_id').val(info.event.extendedProps.class_id).change();
                $('#instructor_id').val(info.event.extendedProps.instructor_id).change();
                $('#resource_id').val(info.event.extendedProps.resource_id).change();
                $('#coordinator_id').val(info.event.extendedProps.coordinator_id).change();
                $('#start_time').val(info.event.start.toISOString().slice(0, 16));
                $('#end_time').val(info.event.end.toISOString().slice(0, 16));
                $('#event_id').val(info.event.id);
                $('#scheduleModal').modal('show');
                $('#updateButton').show();
                $('#deleteButton').show();
            }

        });

        calendar.render();

        $('#scheduleForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            var url = $('#event_id').val() ? 'update_schedule.php' :
                'save_schedule.php';

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: formData
                })
                .then(response => response.text()) 
                .then(result => {
                    alert(result); 
                    $('#scheduleModal').modal('hide');
                    calendar.refetchEvents(); 
                })
                .catch(error => {
                    console.error('Error submitting form:', error);
                });
        });

        $('#updateButton').on('click', function() {
            $('#scheduleForm').submit(); 
        });

        $('#deleteButton').on('click', function() {
            var eventId = $('#event_id').val();

            if (confirm('Are you sure you want to delete this schedule?')) {
                fetch('delete_schedule.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'event_id=' + encodeURIComponent(eventId)
                    })
                    .then(response => response.text()) 
                    .then(result => {
                        alert(result); 
                        $('#scheduleModal').modal('hide');
                        calendar.refetchEvents(); 
                    })
                    .catch(error => {
                        console.error('Error deleting event:', error);
                    });
            }
        });
    });
    </script>
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

</body>

</html>