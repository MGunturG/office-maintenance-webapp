<?php
session_start();

// alert will always be showed
$_SESSION['alert_value'] = "show";
$_SESSION['alert_button_text'] = "OK";

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

// upload function configuration
$target_directory = "../assets/uploads/images/";
$upload_filename = $target_directory . basename($_FILES['fileToUpload']["name"]);
$upload_filetype = strtolower(pathinfo($upload_filename, PATHINFO_EXTENSION));

// upload flags
$can_upload = true;
$large_file = false;
$bad_file = false;
$duplicate_file = false;

// check upload type
// 1. upload for comment; or
// 2. upload for change item's picture
$upload_type = $_POST['action'];
$item_id = $_POST['id'];
$ticket_id = $_POST['ticket_id'];

// check if image uploaded is an actual image
if (isset($_POST['upload_Submit'])) {
	$check_image = getimagesize($_FILES['fileToUpload']['tmp_name']);

	// if the uploaded file is an actual image
	// keep $can_upload as true, but check
	// the file size and filetype/extension
	if ($check_image == true) {

		// check file duplicate
		if (file_exists($upload_filename)) {
			$duplicate_file = true;
			$can_upload = false;
		}

		// check image file size
		// if over 5mb, dont upload
		if ($_FILES['fileToUpload']['size'] > 5000000) {
			$large_file = true;
			$can_upload = false;
		}

		// check image file extension
		// only accept jpg, jpeg, and png
		$allowed_filetype = ['jpg', 'jpeg', 'png'];
		if (!in_array($upload_filetype, $allowed_filetype)) {
			$bad_file = true;
			$can_upload = false;
		} 

	} else {
		$can_upload = false;
		$_SESSION['alert_text'] = "Format file tidak didukung!";
	}
}


if ($can_upload == true) {
	
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $upload_filename)) {
		// create alert message
		$_SESSION['alert_title'] = "Mantap!";
		$_SESSION['alert_text'] = "Gambar terupload!";
		$_SESSION['alert_icon'] = "success";

		// if uploading to change item's picture
		if ($upload_type == "insert_item_picture") {
			$_Item->ItemChangePicture($item_id, BASE_URL."/assets/uploads/images/".basename( $_FILES["fileToUpload"]["name"]));
			header("location:".BASE_URL."/dashboard/item/item-detail.php?id=".$item_id);

		// if uploading for ticket comment
		} elseif ($upload_type == "insert_comment_picture") {
			$image_path = BASE_URL."/assets/uploads/images/".basename( $_FILES["fileToUpload"]["name"]);
			$_Ticket->TicketAddComment(
		        $ticket_id,
		        '<img src="' . $image_path . '" class="card-img-top img-fluid" style="max-width: 50%; height: auto">',
		        $_SESSION['user_uname'] 
			);
			header("location:".BASE_URL."/dashboard/ticket/ticket-detail.php?id=".$ticket_id);
		}

	// here if move_uploaded_file returned false
	// or error moving the file
	} else {
		// error message can't move file
		$_SESSION['alert_title'] = "Oops...";
		$_SESSION['alert_text'] = "Host Error: Can't move uploaded file. Permission issue or destination doesn't exists!";
		$_SESSION['alert_icon'] = "error";
	}

} else { // error uploading file
	// create alert error message
	$_SESSION['alert_title'] = "Oops...";
	$_SESSION['alert_icon'] = "error";

	if ($duplicate_file) {
		$_SESSION['alert_text'] = "File duplikat, upload dengan gambar yang lain ya";
	}

	if ($large_file) {
		$_SESSION['alert_text'] = "Ukuran file terlalu besar! Max 5MB.";
	}

	if ($bad_file) {
		$_SESSION['alert_text'] = "Format file tidak didukung!";
	}

	// redirect based on upload action type
	if ($upload_type == "insert_item_picture") {
		header("location:".BASE_URL."/dashboard/item/item-detail.php?id=".$item_id);
	} elseif ($upload_type == "insert_comment_picture") {
		header("location:".BASE_URL."/dashboard/ticket/ticket-detail.php?id=".$ticket_id);
	}
}

?>