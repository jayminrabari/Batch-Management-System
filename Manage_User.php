<?php 
require("./comp/session.php");
include('config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $check_sql = "SELECT * FROM users WHERE name = ? OR email = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "A user with this name or email already exists!";
    } else {
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $password, $role);

        if ($stmt->execute() === TRUE) {
            echo "<script>alert('User created successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    }
}

if (!empty($error_message)) {
    echo "<script>alert('$error_message');</script>";
}

$users = $conn->query("SELECT * FROM users");
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
                                <h4 class="page-title">Manage Users</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3 text-right">
                            <button class="btn btn-primary mb-3 w-100" data-toggle="modal"
                                data-target="#createBatchModal">Create New Users</button>
                        </div>

                        <?php
$loggedInUserId = $_SESSION['user_id'];
?>
                        <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($user = $users->fetch_assoc()): ?>
                                <?php if ($user['id'] != $loggedInUserId): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo ucfirst(htmlspecialchars($user['role'])); ?></td>
                                    <td>
                                        <a href="edit_user.php?id=<?php echo $user['id']; ?>"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete_user.php?id=<?php echo $user['id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <?php endwhile; ?>
                            </tbody>
                        </table>

                        <div class="modal fade" id="createBatchModal" tabindex="-1" role="dialog"
                            aria-labelledby="createBatchModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createBatchModalLabel">Create New User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="Manage_User.php">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="role">Role</label>
                                                <select class="form-control" id="role" name="role" required>
                                                    <option value="admin">Admin</option>
                                                    <option value="instructor">Instructor</option>
                                                    <option value="coordinator">Coordinator</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Create User</button>
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