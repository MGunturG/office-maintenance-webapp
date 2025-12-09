<?php

class Items {
	function ItemCreate($area_id, $item_name, $item_category, $item_status) {
		$create_by = $_SESSION['user_uname'];
		$create_time = date('Y-m-d H:i:s');

		// check duplicate
		$current_data = get_single_data(
			"SELECT * FROM item_master WHERE item_master_area_id = '$area_id' AND item_master_name = '$item_name'"
		);

		// add new data to database
		if ($current_data == null) {
			run_query(
				"INSERT INTO item_master (item_master_area_id, item_master_name, item_master_category, item_master_status, item_master_createby, item_master_createtime) " .
				"VALUES ('$area_id', '$item_name', '$item_category', '$item_status', '$create_by', '$create_time')"
			);

			// sweetalert
			$_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
			$_SESSION['alert_title'] = "Mantap!";
			$_SESSION['alert_text'] = "Berhasil Menambahkan Barang";
			$_SESSION['alert_icon'] = "success"; // success, question, error, warning, info
			$_SESSION['alert_button_text'] = "OK";

			return true;
		} else {
			return false;
		}
	}


	function ItemDetail($item_id) {
		return get_single_data(
			"SELECT * FROM item_master WHERE item_master_id = '$item_id'"
		);
	}


	function ItemUpdateData($item_id, $item_name, $area_id, $item_category, $item_status) {
		run_query(
			"UPDATE item_master SET ".
			"item_master_name = '$item_name', ".
			"item_master_area_id = '$area_id', ".
			"item_master_category = '$item_category', ".
			"item_master_status = '$item_status' ".
			"WHERE item_master_id = '$item_id'"
		);

		// sweetalert
		$_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
		$_SESSION['alert_title'] = "Mantap!";
		$_SESSION['alert_text'] = "Data Barang Berhasil Diperbarui";
		$_SESSION['alert_icon'] = "success"; // success, question, error, warning, info
		$_SESSION['alert_button_text'] = "OK";
	}


	function ItemUpdateStatus($item_id, $item_status) {
		run_query(
			"UPDATE item_master SET item_master_status = '$item_status' WHERE item_master_id = '$item_id'"
		);
	}


	function ItemGetAll() {
		return get_data(
			"SELECT * FROM item_master"
		);
	}


	function ItemGetAllByAreaId($area_id, $item_status = 1) {
		/* default for variable for $item_status is 1
		 * meaning, this function by default will 
		 * query all item that has status 1 (active)
		 * unless, $item_status overide by another value
		 *
		 * 0 = inactive
		 * 1 = active
		 * 2 = dispose
		 * 3 = maintenance 
		 */
		return get_data(
			"SELECT * FROM item_master WHERE item_master_area_id = '$area_id' AND item_master_status = '$item_status'"
		);
	}


	function ItemGetById($item_id) {
		return get_single_data(
			"SELECT * FROM item_master WHERE item_master_id = '$item_id'"
		);
	}


	function ItemGetAllCategory() {
		return get_data(
			"SELECT * FROM code_master WHERE code_master_category = 'item_category'"
		);
	}

	function ItemGetAllStatus() {
		return get_data(
			"SELECT * FROM code_master WHERE code_master_category = 'item_status'"
		);
	}
}
?>