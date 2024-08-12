<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate user input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $name, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['name'] = $name;  // Store user's name in session
            $_SESSION['role'] = $role;

            // Redirect based on user role
            switch ($role) {
                case 'admin':
                    header("Location: Admin_Dashboard.php");
                    break;
                case 'instructor':
                    header("Location: Instructor_Dashboard.php");
                    break;
                case 'coordinator':
                    header("Location: coordinator_dashboard.php");
                    break;
                default:
                    header("Location: signup.php");
                    break;
            }
            exit();
        } else {
            echo "<script>alert('Invalid Password.');</script>";
        }
    } else {
        echo "<script>alert('No user found with this email.');</script>";

    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            margin: 0;
        }
        .signin-box {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .signin-box h2 {
            margin-bottom: 20px;
        }
        .signin-box .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="signin-box">
        <h2 class="text-center">Signin</h2>
        <form method="POST" action="signin.php">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Signin</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="signup.php">Signup</a></p>
    </div>
</body>
</html>
