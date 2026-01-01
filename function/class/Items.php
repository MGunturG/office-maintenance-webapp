<?php
/**
 * Items Logic Controller
 * * Handles inventory management including item registration, 
 * metadata updates, location tracking, and status categorization.
 */

class Items {

	/**
     * Register a new item in a specific area.
     * Prevents duplicates by checking Name + Area ID combination.
     *
     * @param int    $area_id       Target location ID.
     * @param string $item_name     Name of the asset.
     * @param string $item_category Category code from code_master.
     * @param string $item_status   Initial status code.
     * @return bool True if created successfully, false if duplicate exists.
     */
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


	/**
     * Retrieve full details for a specific item.
     *
     * @param int $item_id Primary key.
     * @return array|null Item record.
     */
	function ItemDetail($item_id) {
		return get_single_data(
			"SELECT * FROM item_master WHERE item_master_id = '$item_id'"
		);
	}


	/**
     * Update primary attributes of an item and set a success alert.
     *
     * @param int    $item_id       Target item ID.
     * @param string $item_name     Updated name.
     * @param int    $area_id       Updated area ID.
     * @param string $item_category Updated category code.
     * @param string $item_status   Updated status code.
     * @return void
     */
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


	/**
     * Specific status update (e.g., moving to Maintenance or Active).
     *
     * @param int    $item_id     Target item ID.
     * @param string $item_status New status code.
     * @return void
     */
	function ItemUpdateStatus($item_id, $item_status) {
		run_query(
			"UPDATE item_master SET item_master_status = '$item_status' WHERE item_master_id = '$item_id'"
		);
	}


	/**
     * Update the file path for the item's display picture.
     *
     * @param int    $item_id      Target item ID.
     * @param string $picture_path Server path to the image file.
     * @return void
     */
	function ItemChangePicture($item_id, $picture_path) {
		run_query(
			"UPDATE item_master SET item_master_picture_path = '$picture_path' WHERE item_master_id = '$item_id'"
		);
	}


	/**
     * Fetch all items in the system.
     * @return array Collection of items.
     */
	function ItemGetAll() {
		return get_data(
			"SELECT * FROM item_master"
		);
	}


	/**
     * Fetch all items assigned to a specific location.
     *
     * @param int $area_id Target area ID.
     * @return array Collection of items in the area.
     */
	function ItemGetAllByAreaId($area_id) {
		return get_data(
			"SELECT * FROM item_master WHERE item_master_area_id = '$area_id'"
		);
	}


	/**
     * Fetch all items assigned to a specific location.
     *
     * @param int $area_id Target area ID.
     * @return array Collection of items in the area.
     */
	function ItemGetById($item_id) {
		return get_single_data(
			"SELECT * FROM item_master WHERE item_master_id = '$item_id'"
		);
	}


	/**
     * Retrieve categories defined in the code_master table.
     * @return array List of categories.
     */
	function ItemGetAllCategory() {
		return get_data(
			"SELECT * FROM code_master WHERE code_master_category = 'item_category'"
		);
	}


	/**
     * Retrieve status labels defined in the code_master table.
     * @return array List of statuses.
     */
	function ItemGetAllStatus() {
		return get_data(
			"SELECT * FROM code_master WHERE code_master_category = 'item_status'"
		);
	}
}
?>