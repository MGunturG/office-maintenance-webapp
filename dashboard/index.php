<?php
session_start();

require "../config.php"; // every page need to load config.php
include '../function/db-query.php';

if (!$_SESSION['user_login_status']) {
    header("location:".BASE_URL."/login.php?status=not_login");
}

$ticket_open = get_data(
    "SELECT ticket_master_status FROM ticket_master WHERE ticket_master_status = '0'"
);

$ticket_progress = get_data(
    "SELECT ticket_master_status FROM ticket_master WHERE ticket_master_status = '1'"
);

$ticket_hold = get_data(
    "SELECT ticket_master_status FROM ticket_master WHERE ticket_master_status = '2'"
);

$ticket_resolved = get_data(
    "SELECT ticket_master_status FROM ticket_master WHERE ticket_master_status = '3'"
);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- styling -->
    <?php include("../layout/styling.php"); ?>
    <!-- <link rel="stylesheet" crossorigin href="../assets/compiled/css/iconly.css"> -->
</head>

<body>
    <?php include("../layout/body-theme.php"); ?>

    <div id="app">
        <!-- sidebar -->
        <?php include("../layout/sidebar.php"); ?>

        <div id="main" class='layout-navbar navbar-fixed'>
            <!-- navbar -->
            <?php include("../layout/navbar.php"); ?>

            <!-- main content -->
            <div id="main-content">
                <div class="page-heading">
                    <h3>Dashboard</h3>
                </div> 
                <div class="page-content"> 
                    <section class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="bi-envelope-open"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Open Tickets</h6>
                                                    <h6 class="font-extrabold mb-0"><?= count($ticket_open) ?></h6>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card"> 
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon blue mb-2">
                                                        <i class="bi-hourglass-split"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">In-Progress</h6>
                                                    <h6 class="font-extrabold mb-0"><?= count($ticket_progress) ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon red mb-2">
                                                        <i class="bi-clock-history"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">On Hold</h6>
                                                    <h6 class="font-extrabold mb-0"><?= count($ticket_hold) ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon green mb-2">
                                                        <i class="bi-patch-check-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Resolved</h6>
                                                    <h6 class="font-extrabold mb-0"><?= count($ticket_resolved) ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </section>
                </div>
            </div>

            <!-- footer -->
            <?php include("../layout/footer.php"); ?>
        </div>
    </div>

    <!-- javascript -->

    <!-- Need: Apexcharts -->
    <script src="../assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/static/js/pages/dashboard.js"></script>

    <?php include("../layout/javascript.php"); ?>
</body>

</html>