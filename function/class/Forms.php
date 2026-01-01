<?php
/**
 * Forms Logic Controller
 * * Manages the lifecycle of inspection forms, including master record creation,
 * item-to-form mapping, status transitions, and data retrieval.
 */

class Forms{

	/**
     * Initialize a new checking form master record.
     * * @param string $effective_date Date of inspection.
     * @param int    $area_id        Target location ID.
     * @param string $remark         Additional notes.
     * @return void
     */
	function FormCreate($effective_date, $area_id, $remark) {
		$create_by = $_SESSION['user_uname'];
		$create_time = date('Y-m-d H:i:s');
		
		/* status category
		 * 0 = draft
		 * 1 = submitted
		 */
		$status = "0"; // status is default to 0 a.k.a draft

		run_query(
			"INSERT INTO checkingform_master (checkingform_master_effdate, checkingform_master_area_id, checkingform_master_remark, checkingform_master_status, checkingform_master_createby, checkingform_master_createtime) " .
			"VALUES ('$effective_date', '$area_id', '$remark', '$status', '$create_by', '$create_time')"
		);
	}


	/**
     * Retrieve details for a single master form.
     * * @param int $form_master_id Primary key of the form.
     * @return array|null Result set from checkingform_master.
     */
	function FormDetail($form_master_id) {
		return get_single_data(
			"SELECT * FROM checkingform_master WHERE checkingform_master_id = $form_master_id"
		);
	}


	/**
     * Link a specific item to an inspection form.
     * * @param int    $form_master_id Target form ID.
     * @param int    $item_id        Target item ID.
     * @param string $item_status    The condition status of the item.
     * @return void
     */
	function FormAddItem($form_master_id, $item_id, $item_status) {
		$create_by = $_SESSION['user_uname'];
		$create_time = date('Y-m-d H:i:s');

		/* item status category
		 * 0 = 
		 * 1 = 
		 */
		
		run_query(
			"INSERT INTO checkingform_detail (checkingform_detail_master_id, checkingform_detail_item_id, checkingform_detail_item_status, checkingform_detail_createby, checkingform_detail_createtime) VALUES ('$form_master_id', '$item_id', '$item_status', '$create_by', '$create_time')".
			""
		);
	}


	/**
     * Finalize form and change status to 'Submitted'.
     * Sets success session alerts.
     * * @param int $form_master_id Target form ID.
     * @return void
     */
	function FormSave($form_master_id) {
		run_query(
			"UPDATE checkingform_master SET checkingform_master_status = '1' WHERE ".
			"checkingform_master_id = '$form_master_id'"
		);

		// sweetalert
		$_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
		$_SESSION['alert_title'] = "Mantap!";
		$_SESSION['alert_text'] = "Form pengecekan berhasil disimpan!";
		$_SESSION['alert_icon'] = "success"; // success, question, error, warning, info
		$_SESSION['alert_button_text'] = "OK";
	}


	/**
     * Revert form status to 'Draft'.
     * Sets info session alerts.
     * * @param int $form_master_id Target form ID.
     * @return void
     */
	function FormRedraft($form_master_id) {
		run_query(
			"UPDATE checkingform_master SET checkingform_master_status = '0' WHERE ".
			"checkingform_master_id = '$form_master_id'"
		);

		// sweetalert
			$_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
			$_SESSION['alert_title'] = "Info";
			$_SESSION['alert_text'] = "Form kembali menjadi draft. Mohon simpan jika sudah selesai pengecekan";
			$_SESSION['alert_icon'] = "info"; // success, question, error, warning, info
			$_SESSION['alert_button_text'] = "OK";
	}


	/**
     * Fetch all existing master checking forms.
     * * @return array Collection of all forms.
     */
	function FormMasterGetAll() {
		return get_data(
			"SELECT * FROM checkingform_master"
		);
	}


	/**
     * Fetch all items associated with a specific form.
     * * @param int $form_master_id Target form ID.
     * @return array Collection of item details.
     */
	function FormDetailGetAllItem($form_master_id) {
		return get_data(
			"SELECT * FROM checkingform_detail WHERE checkingform_detail_master_id = '$form_master_id'"
		);
	}


	/**
     * Remove a specific item from an inspection form.
     * * @param int $item_id        Target item ID.
     * @param int $form_master_id Target form ID.
     * @return void
     */
	function FormRemoveItem($item_id, $form_master_id) {
		run_query(
			"DELETE FROM checkingform_detail WHERE checkingform_detail_item_id = '$item_id' ".
			"AND checkingform_detail_master_id = '$form_master_id'"
		);
	}
}
?>