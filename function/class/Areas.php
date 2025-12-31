<?php
/**
 * Areas Class
 * * Manages physical location data within the system, including 
 * creating new areas, fetching specific details, and listing all areas.
 */

class Areas {

	/**
     * Creates a new area record after checking for duplicates.
     *
     * @param string $area_name        The name of the area.
     * @param string $area_description A brief description of the location.
     * @param int    $area_floor       The floor number where the area is located.
     * * @return bool Returns true if the area was created, false if it already exists.
     */
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
			$_SESSION['alert_text'] = "Area baru dibuat! Kamu bisa lanjut masukan data barang di area ini ya";
			$_SESSION['alert_icon'] = "success"; // success, question, error, warning, info
			$_SESSION['alert_button_text'] = "OK";

			return true;
		} else {
			return false;
		}
	}


	/**
     * Retrieves specific details for a single area.
     *
     * @param int|string $area_id The unique identifier of the area.
     * @return array|null Returns an associative array of area data or null if not found.
     */
	function AreaDetail($area_id) {
		return get_single_data(
			"SELECT * FROM area_master WHERE area_master_id = '$area_id'"
		);
	}


	/**
     * Retrieves all area records ordered by floor level.
     *
     * @return array Returns a list of all areas in the database.
     */
	function AreaGetAll() {
		return get_data(
			"SELECT * FROM area_master ORDER BY area_master_floor ASC"
		);
	}
}
?>