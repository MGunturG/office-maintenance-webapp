<?php

class Areas {
	function AreaCreate($area_name, $area_description, $area_floor) {
		$create_by = $_SESSION['user_uname'];
		$create_time = date('Y-m-d H:i:s');

		// check duplicate
		$current_data = get_single_data(
			"SELECT * FROM area_master WHERE area_master_name = '$area_name' AND area_master_floor = '$area_floor'"
		);

		// add new data to database
		if ($current_data == null) {
			run_query(
				"INSERT INTO area_master (area_master_name, area_master_description, area_master_floor, area_master_createby, area_master_createtime) ".
				"VALUES ('$area_name', '$area_description', '$area_floor', '$create_by', '$create_time')"
			);

			// sweetalert
			$_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
			$_SESSION['alert_title'] = "Mantap!";
			$_SESSION['alert_text'] = "Area Baru Berhasil Dibuat";
			$_SESSION['alert_icon'] = "success"; // success, question, error, warning, info
			$_SESSION['alert_button_text'] = "OK";

			return true;
		} else {
			return false;
		}
	}


	function AreaDetail($area_id) {
		return get_single_data(
			"SELECT * FROM area_master WHERE area_master_id = '$area_id'"
		);
	}


	function AreaGetAll() {
		return get_data(
			"SELECT * FROM area_master ORDER BY area_master_floor ASC"
		);
	}
}
?>