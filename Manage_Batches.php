<?php require ("./comp/session.php");?>
<?php
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

// Handle form submission for creating a batch
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = $_POST['course_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $capacity = $_POST['capacity'];

    $sql = "INSERT INTO batches (course_name, start_date, end_date, capacity) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $course_name, $start_date, $end_date, $capacity);

    if ($stmt->execute()) {
        echo "<script>alert('Batch created successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
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



     
    <link href="assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

     
    <link href="assets/vendor/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />

     
    <link href="assets/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet"
        type="text/css" />

     
    <link href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />

     
    <link href="assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />

     
    <link href="assets/vendor/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />

     
    <link rel="shortcut icon" href="assets/images/logos/main logo.png">

     
    <link rel="stylesheet" href="assets/vendor/daterangepicker/daterangepicker.css">

     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

     
    <link rel="stylesheet" href="assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css">

     
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
                                <h4 class="page-title">Manage Batches</h4>
                            </div>
                        </div>
                    </div>
                     


                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3 text-right">
                            <button class="btn btn-primary mb-3 w-100" data-toggle="modal"
                                data-target="#createBatchModal">Create New Batch</button>
                        </div>

                        <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Capacity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                $sql = "SELECT * FROM batches";
                $batches = $conn->query($sql);

                while ($batch = $batches->fetch_assoc()):
                ?>
                                <tr>
                                    <td><?php echo $batch['course_name']; ?></td>
                                    <td><?php echo $batch['start_date']; ?></td>
                                    <td><?php echo $batch['end_date']; ?></td>
                                    <td><?php echo $batch['capacity']; ?></td>
                                    <td>
                                        <a href="edit_batch.php?id=<?php echo $batch['id']; ?>"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete_batch.php?id=<?php echo $batch['id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this batch?');">Delete</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>

                         
                        <div class="modal fade" id="createBatchModal" tabindex="-1" role="dialog"
                            aria-labelledby="createBatchModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createBatchModalLabel">Create New Batch</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="">
                                            <div class="form-group">
                                                <label for="course_name">Course Name</label>
                                                <input type="text" class="form-control" id="course_name"
                                                    name="course_name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="start_date">Start Date</label>
                                                <input type="date" class="form-control" id="start_date"
                                                    name="start_date" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="end_date">End Date</label>
                                                <input type="date" class="form-control" id="end_date" name="end_date"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="capacity">Capacity</label>
                                                <input type="number" class="form-control" id="capacity" name="capacity"
                                                    required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Create Batch</button>
                                        </form>
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
    $(document).ready(function() {
        $('#batchesTable').DataTable({
            "order": [
                [1, "asc"]
            ]
        });
    });
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

     
    <script src="assets/js/vendor.min.js"></script>

    <script src="assets/js/app.min.js"></script>
     
    <script src="assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js"></script>
    <script src="assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>

     
    <script src="assets/js/pages/demo.datatable-init.js"></script>
</body>

</html>