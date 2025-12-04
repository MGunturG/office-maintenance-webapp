<?php

class Forms{
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


	function FormDetail($form_master_id) {
		return get_single_data(
			"SELECT * FROM checkingform_master WHERE checkingform_master_id = $form_master_id"
		);
	}


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


	function FormMasterGetAll() {
		return get_data(
			"SELECT * FROM checkingform_master"
		);
	}


	function FormDetailGetAllItem($form_master_id) {
		return get_data(
			"SELECT * FROM checkingform_detail WHERE checkingform_detail_master_id = '$form_master_id'"
		);
	}


	function FormRemoveItem($item_id, $form_master_id) {
		run_query(
			"DELETE FROM checkingform_detail WHERE checkingform_detail_item_id = '$item_id' ".
			"AND checkingform_detail_master_id = '$form_master_id'"
		);
	}
}
?>