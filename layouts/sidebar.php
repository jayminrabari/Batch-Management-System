<?php
$user_role = $_SESSION['role'];
?>

<div class="leftside-menu" style="position: fixed; height: 100vh;">

    <a class="logo logo-light">
        <span class="logo-sm">
            <img src="assets/images/logo-smpk.png" alt="small logo">
        </span>
    </a>

    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <html data-sidenav-user="true" data-sidenav-size="condensed">
        <div class="leftbar-user">
            <img src="assets/images/ironbatman.jpeg" alt="user-image" height="42" class="img-fluid avatar-xl rounded">
            <span class="leftbar-user-name mt-2"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
            <span class="badge bg-success-subtle text-success"><?php echo htmlspecialchars($_SESSION['role']); ?></span>
            </a>
        </div>

        <ul class="side-nav">
            <?php if ($user_role == 'admin'): ?>
            <li class="side-nav-item">
                <a href="Admin_Dashboard.php" class="side-nav-link">
                    <i class="bi bi-house-door"></i>
                    <span> Admin Dashboard </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="Manage_User.php" class="side-nav-link">
                    <i class="bi bi-person-lines-fill"></i>
                    <span> Manage Users </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="Manage_Batches.php" class="side-nav-link">
                    <i class="bi bi-file-earmark-text"></i>
                    <span> Manage Batches </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="Manage_Classes.php" class="side-nav-link">
                    <i class="bi bi-stack"></i>
                    <span> Manage Classes </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="Manage_Resource.php" class="side-nav-link">
                    <i class="bi bi-card-list"></i>
                    <span> Manage Resources </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="Schedule_Class.php" class="side-nav-link">
                    <i class="bi bi-calendar-plus"></i>
                    <span> Schedule Classes </span>
                </a>
            </li>

            <?php elseif ($user_role == 'instructor'): ?>
            <li class="side-nav-item">
                <a href="Instructor_Dashboard.php" class="side-nav-link">
                    <i class="bi bi-house-door"></i>
                    <span> Instructor Dashboard </span>
                </a>
            </li>

            <li class="side-nav-title">Optional Add-On</li>
            <li class="side-nav-item">
                <a href="en.php" class="side-nav-link">
                    <i class="bi bi-pencil-square"></i>
                    <span> Enroll Students </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="add_stud.php" class="side-nav-link">
                    <i class="bi bi-person-plus"></i>
                    <span> Add Students </span>
                </a>
            </li>

            <?php elseif ($user_role == 'coordinator'): ?>
            <li class="side-nav-item">
                <a href="coordinator_dashboard.php" class="side-nav-link">
                    <i class="bi bi-house-door"></i>
                    <span> Instructor Dashboard </span>
                </a>
            </li>

            <li class="side-nav-title">Optional Add-On</li>
            <li class="side-nav-item">
                <a href="en.php" class="side-nav-link">
                    <i class="bi bi-pencil-square"></i>
                    <span> Enroll Students </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="add_stud.php" class="side-nav-link">
                    <i class="bi bi-person-plus"></i>
                    <span> Add Students </span>
                </a>
            </li>

            <?php else: ?>
            <li class="side-nav-item">
                <p>Unknown role or no access.</p>
            </li>
            <?php endif; ?>

            <li class="side-nav-item">
                <a href="logout.php" class="side-nav-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span> Logout </span>
                </a>
            </li>
        </ul>

        <div class="clearfix"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $('.side-nav-link').click(function(e) {
        e.preventDefault();
        var href = $(this).attr('href');

        $('.content').addClass('content-hide');

        setTimeout(function() {
            window.location.href = href;
        }, 300);
    });
});
</script>