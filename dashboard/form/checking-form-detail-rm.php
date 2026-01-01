<?php  
/**
 * Item Removal Handler
 * * Processes the deletion of a specific item from a checking form.
 * Validates session, executes deletion via the Forms class, 
 * sets success notifications, and manages redirection.
 *
 * @param string $_GET['item_id'] Primary key of the item to delete.
 * @param string $_GET['form_id'] ID of the parent master form.
 * @return void Redirects to checking-form-detail.php.
 */

// rm mean remove
session_start();

require '../../config.php';
include '../../function/db-query.php';
include_once '../../function/class/Forms.php';

if (!$_SESSION['user_login_status']) {
	header("location:".BASE_URL."/login.php?status=not_login");
}

$_Form = new Forms;

if (isset($_GET['item_id']) && isset($_GET['form_id'])) {
	$item_id = $_GET['item_id'];
	$form_master_id = $_GET['form_id'];
	$_Form->FormRemoveItem($item_id, $form_master_id);

	// toastalert
	$_SESSION['toastalert_value'] = "show"; // put any value, if null, alert not showing
	$_SESSION['toastalert_title'] = "Barang berhasil dihapus dari form pengecekan!";
	$_SESSION['toastalert_icon'] = "success"; // success, question, error, warning, info

	// echo "<script>document.location.href = 'checking-form-detail.php?id=$form_master_id';</script>"; exit;
	header("location:checking-form-detail.php?id=".$form_master_id);
} else {
	header("location:checking-form-detail.php?id=".$form_master_id);
}
?>