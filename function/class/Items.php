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


	function ItemGetAll() {
		return get_data(
			"SELECT * FROM item_master"
		);
	}


	function ItemGetAllByAreaId($area_id) {
		return get_data(
			"SELECT * FROM item_master WHERE item_master_area_id = '$area_id'"
		);
	}
}
?>