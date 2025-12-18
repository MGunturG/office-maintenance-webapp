<?php
session_start();

require '../config.php';
require 'db-query.php';
include_once 'class/Items.php';
include_once 'class/Tickets.php';

if (!$_SESSION['user_login_status']) {
  header("location:".BASE_URL."/login.php?status=not_login");
}

$_Item = new Items;
$_Ticket = new Tickets;

// reference code
// https://www.w3schools.com/php/php_file_upload.asp

$target_dir = "../assets/uploads/images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$large_file = 0;
$bad_format = 0;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$upload_action_type = $_POST['action'];
$sql_id_query = $_POST['id']; // or item id
$ticket_id = $_POST['ticket_id'];

// Check if image file is a actual image or fake image
if(isset($_POST["upload_Submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    // echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
// if exists, delete. upload new one

// update 17-dec-2025
// if file exists, throw error
if (file_exists($target_file)) {
  // unlink($target_file); ==> to delete file
  $uploadOk = 0;
  $duplicate_file = 1;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) { // in bytes, limit to 5000KB or 5MB
  // echo "Sorry, your file is too large.";
  $uploadOk = 0;
  $large_file = 1;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
  // echo "Sorry, only JPG, JPEG & PNG files are allowed.";
  $uploadOk = 0;
  $bad_format = 1;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {

  if ($large_file == 1) {
    // alert session file too large
    $_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
    $_SESSION['alert_title'] = "Oops...";
    $_SESSION['alert_text'] = "Ukuran file terlalu besar";
    $_SESSION['alert_icon'] = "error"; // success, question, error, warning, info
    $_SESSION['alert_button_text'] = "OK";
  } elseif ($duplicate_file == 1) {
    // alert session bad file format
    $_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
    $_SESSION['alert_title'] = "Oops...";
    $_SESSION['alert_text'] = "File sudah ada, mohon input file dengan nama yang unik";
    $_SESSION['alert_icon'] = "error"; // success, question, error, warning, info
    $_SESSION['alert_button_text'] = "OK";
  } elseif ($bad_format == 1) {
    // alert session bad file format
    $_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
    $_SESSION['alert_title'] = "Oops...";
    $_SESSION['alert_text'] = "Format file tidak didukung";
    $_SESSION['alert_icon'] = "error"; // success, question, error, warning, info
    $_SESSION['alert_button_text'] = "OK";
  } else {
    $_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
    $_SESSION['alert_title'] = "Oops...";
    $_SESSION['alert_text'] = "Unknown Error : 0x0001";
    $_SESSION['alert_icon'] = "error"; // success, question, error, warning, info
    $_SESSION['alert_button_text'] = "OK";
  }

  // check upload action type
  if ($upload_action_type == "insert_item_picture") {
    header("location:".BASE_URL."/dashboard/item/item-detail.php?id=".$sql_id_query);
  } elseif ($upload_action_type == "insert_comment_picture") {
    header("location:".BASE_URL."/dashboard/ticket/ticket-detail.php?id=".$ticket_id);
  }


// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    // check upload action type
    if ($upload_action_type == "insert_item_picture") {
      $_Item->ItemChangePicture($sql_id_query, BASE_URL."/assets/uploads/images/".basename( $_FILES["fileToUpload"]["name"]));
      
      $_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
      $_SESSION['alert_title'] = "Mantap!";
      $_SESSION['alert_text'] = "Gambar berhasil diperbarui";
      $_SESSION['alert_icon'] = "success"; // success, question, error, warning, info
      $_SESSION['alert_button_text'] = "OK";

      header("location:".BASE_URL."/dashboard/item/item-detail.php?id=".$sql_id_query);

    } elseif ($upload_action_type == "insert_comment_picture") {
      $image_path = BASE_URL."/assets/uploads/images/".basename( $_FILES["fileToUpload"]["name"]);


      $_Ticket->TicketAddComment(
        $ticket_id,
        '<img src="' . $image_path . '" class="card-img-top img-fluid">',
        $_SESSION['user_uname'] 
      );

      header("location:".BASE_URL."/dashboard/ticket/ticket-detail.php?id=".$ticket_id);
    }

  } else {
    $_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
    $_SESSION['alert_title'] = "Oops...";
    $_SESSION['alert_text'] = "Unknown Error : 0x0001";
    $_SESSION['alert_icon'] = "error"; // success, question, error, warning, info
    $_SESSION['alert_button_text'] = "OK";

    // check upload action type
    if ($upload_action_type == "insert_item_picture") {
      header("location:".BASE_URL."/dashboard/item/item-detail.php?id=".$sql_id_query);
    } elseif ($upload_action_type == "insert_comment_picture") {
      header("location:".BASE_URL."/dashboard/ticket/ticket-detail.php?id=".$ticket_id);
    }
  }
}
?>