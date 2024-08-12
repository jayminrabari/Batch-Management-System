<?php
require ("./comp/session.php");
include('config.php');

// Set the default timezone to IST
date_default_timezone_set('Asia/Kolkata');

// Check if the user is logged in and has the role of instructor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header("Location: signin.php");
    exit();
}

$instructor_id = $_SESSION['user_id'];

// Get the current date and time in IST
$now = new DateTime();
$today = $now->format('Y-m-d');

// Fetch all classes assigned to the instructor
$query = "SELECT ca.id, c.class_name, ca.start_time, ca.end_time 
          FROM class_assignments ca
          JOIN classes c ON ca.class_id = c.id
          WHERE ca.instructor_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $instructor_id);
$stmt->execute();
$result = $stmt->get_result();
$classes = $result->fetch_all(MYSQLI_ASSOC);

// Separate classes into active, upcoming, and old
$activeClasses = [];
$upcomingClasses = [];
$oldClasses = [];

foreach ($classes as $class) {
    $classStartTime = new DateTime($class['start_time']);
    $classEndTime = new DateTime($class['end_time']);
    
    if ($classEndTime < $now) {
        $oldClasses[] = $class;
    } elseif ($classStartTime <= $now && $classEndTime >= $now) {
        $activeClasses[] = $class;
    } elseif ($classStartTime > $now) {
        $upcomingClasses[] = $class;
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8" />
    <title>Batch Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Jaymin Rabari" name="description" />
    <meta content="Jaymin Rabari" name="author" />

    <link rel="shortcut icon" href="assets/images/j small fav.png">
    <script src="assets/js/config.js"></script>
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
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
                                <h4 class="page-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Active Classes Section -->
                    <div class="row">
                        <div class="col-12">
                            <h4>Active Classes</h4>
                        </div>
                        <?php foreach ($activeClasses as $class): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($class['class_name']); ?></h5>
                                    <p class="card-text">
                                        <strong>Date:</strong>
                                        <?php echo htmlspecialchars(date('F j, Y', strtotime($class['start_time']))); ?><br>
                                        <strong>Start Time:</strong>
                                        <?php echo htmlspecialchars(date('g:i A', strtotime($class['start_time']))); ?><br>
                                        <strong>End Date:</strong>
                                        <?php echo htmlspecialchars(date('F j, Y', strtotime($class['end_time']))); ?><br>
                                        <strong>End Time:</strong>
                                        <?php echo htmlspecialchars(date('g:i A', strtotime($class['end_time']))); ?>
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <a href="take_attendance.php?class_id=<?php echo urlencode($class['id']); ?>"
                                            class="btn btn-primary">Take Attendance</a>
                                        <a href="generate_report.php?class_id=<?php echo urlencode($class['id']); ?>"
                                            class="btn btn-secondary">Generate Report</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Upcoming Classes Section -->
                    <div class="row">
                        <div class="col-12">
                            <h4>Upcoming Classes</h4>
                        </div>
                        <?php foreach ($upcomingClasses as $class): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($class['class_name']); ?></h5>
                                    <p class="card-text">
                                        <strong>Date:</strong>
                                        <?php echo htmlspecialchars(date('F j, Y', strtotime($class['start_time']))); ?><br>
                                        <strong>Start Time:</strong>
                                        <?php echo htmlspecialchars(date('g:i A', strtotime($class['start_time']))); ?><br>
                                        <strong>End Date:</strong>
                                        <?php echo htmlspecialchars(date('F j, Y', strtotime($class['end_time']))); ?><br>
                                        <strong>End Time:</strong>
                                        <?php echo htmlspecialchars(date('g:i A', strtotime($class['end_time']))); ?>
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <!-- No buttons for upcoming classes -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Old Classes Section -->
                    <div class="row">
                        <div class="col-12">
                            <h4>Old Classes</h4>
                        </div>
                        <?php foreach ($oldClasses as $class): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($class['class_name']); ?></h5>
                                    <p class="card-text">
                                        <strong>Date:</strong>
                                        <?php echo htmlspecialchars(date('F j, Y', strtotime($class['start_time']))); ?><br>
                                        <strong>Start Time:</strong>
                                        <?php echo htmlspecialchars(date('g:i A', strtotime($class['start_time']))); ?><br>
                                        <strong>End Date:</strong>
                                        <?php echo htmlspecialchars(date('F j, Y', strtotime($class['end_time']))); ?><br>
                                        <strong>End Time:</strong>
                                        <?php echo htmlspecialchars(date('g:i A', strtotime($class['end_time']))); ?>
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <a href="generate_report.php?class_id=<?php echo urlencode($class['id']); ?>"
                                            class="btn btn-secondary">Generate Report</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

</body>

</html>
