<?php
session_start();

require '../../config.php';
include '../../function/db-query.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- edit page title -->
    <title>Report Pengecekan</title>

    <!-- styling -->
    <!-- edit this code below depending on current file path towards needed file -->
    <?php include("../../layout/styling.php"); ?>
</head>

<body>
    <!-- edit this code below depending on current file path towards needed file -->
    <?php include("../../layout/body-theme.php"); ?>

    <div id="app">
        <!-- sidebar -->
        <!-- edit this code below depending on current file path towards needed file -->
        <?php include("../../layout/sidebar.php"); ?>

        <div id="main" class='layout-navbar navbar-fixed'>
            <!-- navbar -->
            <!-- edit this code below depending on current file path towards needed file -->
            <?php include("../../layout/navbar.php"); ?>

            <!-- main content -->
            <div id="main-content">
                <!-- you can add main content here -->
                <p>Hello</p>
            </div>

            <!-- footer -->
            <!-- edit this code below depending on current file path towards needed file -->
            <?php include("../../layout/footer.php"); ?>
        </div>
    </div>

    <!-- javascript -->
    <!-- edit this code below depending on current file path towards needed file -->
    <?php include("../../layout/javascript.php"); ?>
</body>

</html>