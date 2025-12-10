<?php
session_start();

require "../config.php"; // every page need to load config.php
include '../function/db-query.php';

if (!$_SESSION['user_login_status']) {
    header("location:".BASE_URL."/login.php?status=not_login");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- styling -->
    <?php include("../layout/styling.php"); ?>
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
                <!-- you can add main content here -->
                <p>Hello</p>
            </div>

            <!-- footer -->
            <?php include("../layout/footer.php"); ?>
        </div>
    </div>

    <!-- javascript -->
    <?php include("../layout/javascript.php"); ?>
</body>

</html>