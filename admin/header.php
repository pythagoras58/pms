<?php
    session_start();
    include('connection/connection.php');

    $indexnumber = $_SESSION['indexnumber'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Dashboard || Admin Panel</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="js/all.min.js"></script>
    <script src="js/feather.min.js"></script>
</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
        <a class="navbar-brand d-none d-sm-block" href="index.html">Admin Panel</a><button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#"><i data-feather="menu"></i></button>
        <ul class="navbar-nav align-items-center ml-auto">




            <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="./assets/img/pentecost-university-logo-alt.png" /></a>
                <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="./assets/img/graduated.png" alt="Photo" />
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name">
                                <?php echo $indexnumber; ?>
                            </div>
                            <div class="dropdown-user-details-email">
                                Welcome
                            </div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="profile.html">
                        <div class="dropdown-item-icon">
                            <i data-feather="settings"></i>
                        </div>
                        Profile
                    </a>
                    <a class="dropdown-item" href="../index.php">
                        <div class="dropdown-item-icon">
                            <i data-feather="log-out"></i>
                        </div>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>


    <!--Side Nav-->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sidenav shadow-right sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">                        <a class="nav-link collapsed pt-4" href="index.php">
                            <div class="nav-link-icon"><i data-feather="activity"></i></div>
                            Dashboard
                        </a>
                        
                        <a class="nav-link" href="staff.php">
                            <div class="nav-link-icon"><i data-feather="user"></i></div>
                            Staff
                        </a>

                        <a class="nav-link" href="security.php">
                            <div class="nav-link-icon"><i data-feather="user"></i></div>
                            Security
                        </a>

                        <a class="nav-link" href="faculty.php">
                            <div class="nav-link-icon"><i data-feather="chevrons-up"></i></div>
                            Faculty
                        </a>

                        <a class="nav-link" href="department.php">
                            <div class="nav-link-icon"><i data-feather="book-open"></i></div>
                            Department
                        </a>

                        <a class="nav-link" href="student.php">
                            <div class="nav-link-icon"><i data-feather="users"></i></div>
                            Students
                        </a>

                        <a class="nav-link" href="admin.php">
                            <div class="nav-link-icon"><i data-feather="key"></i></div>
                            Administrator
                        </a>

                        <a class="nav-link" href="parking_lot.php">
                            <div class="nav-link-icon"><i data-feather="package"></i></div>
                            Parking Slots
                        </a>

                        <a class="nav-link" href="booking.php">
                            <div class="nav-link-icon"><i data-feather="mail"></i></div>
                            Booked Parking Space
                        </a>

                        <a class="nav-link" href="transactionLog.php">
                            <div class="nav-link-icon"><i data-feather="mail"></i></div>
                            Transactions
                        </a>

                        <a class="nav-link" href="profile.php">
                            <div class="nav-link-icon"><i data-feather="user"></i></div>
                            Profile
                        </a>
                    </div>
                </div>

                <div class="sidenav-footer">
                    <div class="sidenav-footer-content">
                        <div class="sidenav-footer-subtitle">Logged in as:</div>
                        <div class="sidenav-footer-title">Administrator</div>
                    </div>
                </div>

            </nav>
        </div>