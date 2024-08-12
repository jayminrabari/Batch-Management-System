 
<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-lg-2 gap-1">

             
            <button class="button-toggle-menu">
                <i class="ri-menu-2-fill"></i>
            </button>

             
            <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>

        <ul class="topbar-menu d-flex align-items-center gap-3">



             
            <li class="d-lg-d-sm-inline-block">
                <div class="nav-link" id="light-dark-mode" data-bs-toggle="tooltip" data-bs-placement="left"
                    title="Theme Mode">
                    <i class="ri-moon-line fs-22"></i>
                </div>
            </li>

             
            <li class="d-lg-d-md-inline-block">
                <a class="nav-link" href="#" data-toggle="fullscreen" data-bs-toggle="tooltip" data-bs-placement="left"
                    title="Full Screen">
                    <i class="ri-fullscreen-line fs-22"></i>
                </a>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="assets/images/ironbatman.jpeg" alt="user-image" width="32" class="rounded-circle">
                    </span>
                    <span class="d-lg-flex flex-column gap-1 d-none">
                        <h5 class="my-0">
                            <?php echo $_SESSION['name']; ?>
                        </h5>
                        <h6 class="my-0 fw-normal">
                            <?php echo $_SESSION['role']; ?>
                        </h6>
                    </span>

                </a>
            </li>
        </ul>
    </div>
</div>
 