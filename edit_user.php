<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

$user_id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "User not found.";
    exit();
}

$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name = '$name', email = '$email', role = '$role' WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        echo "User updated successfully!";
        header("Location: Manage_User.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    <link href="assets/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
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
                                <h4 class="page-title">Edit Batch</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <h2 class="mt-5">Edit User</h2>
                        <form method="POST" action="edit_user.php?id=<?php echo $user_id; ?>">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php echo $user['name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo $user['email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin
                                    </option>
                                    <option value="instructor"
                                        <?php if ($user['role'] == 'instructor') echo 'selected'; ?>>Instructor</option>
                                    <option value="coordinator"
                                        <?php if ($user['role'] == 'coordinator') echo 'selected'; ?>>Coordinator
                                    </option>
                                </select>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <a href="Manage_User.php" class="btn btn-secondary">Cancel</a>
                        </form>
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