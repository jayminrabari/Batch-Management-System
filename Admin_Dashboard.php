<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$counts = [];

$result = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'admin'");
$row = $result->fetch_assoc();
$counts['admins'] = $row['count'];

$result = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'instructor'");
$row = $result->fetch_assoc();
$counts['instructors'] = $row['count'];

$result = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'coordinator'");
$row = $result->fetch_assoc();
$counts['coordinators'] = $row['count'];

$result = $conn->query("SELECT COUNT(*) AS count FROM batches");
$row = $result->fetch_assoc();
$counts['batches'] = $row['count'];

$result = $conn->query("SELECT COUNT(*) AS count FROM classes");
$row = $result->fetch_assoc();
$counts['classes'] = $row['count'];

$result = $conn->query("SELECT COUNT(*) AS count FROM resources");
$row = $result->fetch_assoc();
$counts['resources'] = $row['count'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Admin Dashboard | Batch Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Jaymin Rabari" name="description" />
    <meta content="Jaymin Rabari" name="author" />
    <link rel="shortcut icon" href="assets/images/logos/main logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css">
    <script src="assets/js/config.js"></script>
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <style>
    .apex-charts {
        width: 120px;
        height: 120px;
    }

    .card-icon {
        font-size: 2rem;
        color: #6c757d;
    }
    </style>
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
                                <div class="page-title-right">
                                    <form class="d-flex">
                                        <div class="input-group">
                                            <input type="text" class="form-control shadow border-0" id="dash-daterange">
                                            <span class="input-group-text bg-primary border-primary text-white">
                                                <i class="ri-calendar-todo-fill fs-13"></i>
                                            </span>
                                        </div>
                                        <a href="javascript: void(0);" class="btn btn-primary ms-2">
                                            <i class="ri-refresh-line"></i>
                                        </a>
                                    </form>
                                </div>
                                <h4 class="page-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-xxl-5 row-cols-lg-3 row-cols-md-2">

                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <i class="fas fa-user-cog card-icon"></i>
                                            <h5 class="text-muted fw-normal mt-0">Total Admins</h5>
                                            <h3 class="my-3"><?php echo number_format($counts['admins']); ?></h3>
                                        </div>
                                        <div id="admins-chart" class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <i class="fas fa-chalkboard-teacher card-icon"></i>
                                            <h5 class="text-muted fw-normal mt-0">Total Instructors</h5>
                                            <h3 class="my-3"><?php echo number_format($counts['instructors']); ?></h3>
                                        </div>
                                        <div id="instructors-chart" class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <i class="fas fa-user-tie card-icon"></i>
                                            <h5 class="text-muted fw-normal mt-0">Total Coordinators</h5>
                                            <h3 class="my-3"><?php echo number_format($counts['coordinators']); ?></h3>
                                        </div>
                                        <div id="coordinators-chart" class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <i class="fas fa-th card-icon"></i>
                                            <h5 class="text-muted fw-normal mt-0">Total Batches</h5>
                                            <h3 class="my-3"><?php echo number_format($counts['batches']); ?></h3>
                                        </div>
                                        <div id="batches-chart" class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <i class="fas fa-book card-icon"></i>
                                            <h5 class="text-muted fw-normal mt-0">Total Classes</h5>
                                            <h3 class="my-3"><?php echo number_format($counts['classes']); ?></h3>
                                        </div>
                                        <div id="classes-chart" class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <i class="fas fa-cogs card-icon"></i>
                                            <h5 class="text-muted fw-normal mt-0">Total Resources</h5>
                                            <h3 class="my-3"><?php echo number_format($counts['resources']); ?></h3>
                                        </div>
                                        <div id="resources-chart" class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


            </div>

        </div>


    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartData = {
            'admins': <?php echo $counts['admins']; ?>,
            'instructors': <?php echo $counts['instructors']; ?>,
            'coordinators': <?php echo $counts['coordinators']; ?>,
            'batches': <?php echo $counts['batches']; ?>,
            'classes': <?php echo $counts['classes']; ?>,
            'resources': <?php echo $counts['resources']; ?>
        };

        const charts = {
            'admins-chart': {
                series: [chartData['admins']],
                color: '#00E396'
            },
            'instructors-chart': {
                series: [chartData['instructors']],
                color: '#FF4560'
            },
            'coordinators-chart': {
                series: [chartData['coordinators']],
                color: '#008FFB'
            },
            'batches-chart': {
                series: [chartData['batches']],
                color: '#00E396'
            },
            'classes-chart': {
                series: [chartData['classes']],
                color: '#FF4560'
            },
            'resources-chart': {
                series: [chartData['resources']],
                color: '#008FFB'
            }
        };

        Object.keys(charts).forEach(chartId => {
            new ApexCharts(document.querySelector(`#${chartId}`), {
                chart: {
                    type: 'radialBar',
                    width: 120,
                    height: 120
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 10,
                            size: '70%'
                        },
                        track: {
                            background: '#e3e9ee',
                        },
                        dataLabels: {
                            show: true,
                            name: {
                                show: false
                            },
                            value: {
                                fontSize: '16px',
                                color: '#000',
                                offsetY: 0,
                            }
                        }
                    }
                },
                fill: {
                    colors: [charts[chartId].color]
                },
                series: charts[chartId].series
            }).render();
        });
    });
    </script>
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="assets/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/js/pages/demo.dashboard.js"></script>
    <script src="assets/js/app.min.js"></script>

</body>

</html>