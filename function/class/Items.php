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
        // $current_data = get_single_data(
        //  "SELECT * FROM item_master WHERE item_master_area_id = '$area_id' AND item_master_name = '$item_name'"
        // );
        $query_current_data = "SELECT * FROM item_master WHERE item_master_area_id = :area_id AND item_master_name = :item_name";
        $param_current_data = [
            "area_id" => $area_id,
            "item_name" => $item_name
        ];
        $current_data = get_single_data($query_current_data, $param_current_data);

        // add new data to database
        if ($current_data == null) {
            // run_query(
            //  "INSERT INTO item_master (item_master_area_id, item_master_name, item_master_category, item_master_status, item_master_createby, item_master_createtime) " .
            //  "VALUES ('$area_id', '$item_name', '$item_category', '$item_status', '$create_by', '$create_time')"
            // );
            $query_insert_data = "INSERT INTO item_master (item_master_area_id, item_master_name, item_master_category, item_master_status, item_master_createby, item_master_createtime) VALUES (:area_id, :item_name, :item_category, :item_status, :create_by, :create_time)";
            $param_insert_data = [
                "area_id" => $area_id,
                "item_name" => $item_name,
                "item_category" => $item_category,
                "item_status" => $item_status,
                "create_by" => $create_by,
                "create_time" => $create_time
            ];
            run_query($query_insert_data, $param_insert_data);

            // sweetalert
            $_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
            $_SESSION['alert_title'] = "Mantap!";
            $_SESSION['alert_text'] = "Berhasil menambahkan barang";
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
        // return get_single_data(
        //  "SELECT * FROM item_master WHERE item_master_id = '$item_id'"
        // );
        $query = "SELECT * FROM item_master WHERE item_master_id = :item_id";
        $param = ["item_id" => $item_id];
        return get_single_data($query, $param);
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
        // run_query(
        //  "UPDATE item_master SET ".
        //  "item_master_name = '$item_name', ".
        //  "item_master_area_id = '$area_id', ".
        //  "item_master_category = '$item_category', ".
        //  "item_master_status = '$item_status' ".
        //  "WHERE item_master_id = '$item_id'"
        // );
        $query = "UPDATE item_master SET item_master_name = :item_name, item_master_area_id = :area_id, item_master_category = :item_category, item_master_status = :item_status WHERE item_master_id = :item_id";
        $param = [
            "item_name" => $item_name,
            "area_id" => $area_id,
            "item_category" => $item_category,
            "item_status" => $item_status,
            "item_id" => $item_id
        ];
        run_query($query, $param);

        // sweetalert
        $_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
        $_SESSION['alert_title'] = "Mantap!";
        $_SESSION['alert_text'] = "Data barang berhasil diperbarui";
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
        // run_query(
        //  "UPDATE item_master SET item_master_status = '$item_status' WHERE item_master_id = '$item_id'"
        // );
        $query = "UPDATE item_master SET item_master_status = :item_status WHERE item_master_id = :item_id";
        $param = [
            "item_status" => $item_status,
            "item_id" => $item_id
        ];
        run_query($query, $param);
    }


    /**
     * Update the file path for the item's display picture.
     *
     * @param int    $item_id      Target item ID.
     * @param string $picture_path Server path to the image file.
     * @return void
     */
    function ItemChangePicture($item_id, $picture_path) {
        // run_query(
        //  "UPDATE item_master SET item_master_picture_path = '$picture_path' WHERE item_master_id = '$item_id'"
        // );
        $query = "UPDATE item_master SET item_master_picture_path = :picture_path WHERE item_master_id = :item_id";
        $param = [
            "picture_path" => $picture_path,
            "item_id" => $item_id
        ];
        run_query($query, $param);
    }


    /**
     * Fetch all items in the system.
     * @return array Collection of items.
     */
    function ItemGetAll() {
        // return get_data(
        //  "SELECT * FROM item_master"
        // );
        $query = "
            SELECT * FROM item_master
        ";
        $param = [];
        return get_data($query, $param);
    }


    /**
     * Fetch all items assigned to a specific location.
     *
     * @param int $area_id Target area ID.
     * @return array Collection of items in the area.
     */
    function ItemGetAllByAreaId($area_id) {
        // return get_data(
        //  "SELECT * FROM item_master WHERE item_master_area_id = '$area_id'"
        // );
        $query = "SELECT * FROM item_master WHERE item_master_area_id = :area_id";
        $param = ["area_id" => $area_id];
        return get_data($query, $param);
    }


    /**
     * Fetch an item assigned to a specific id.
     *
     * @param int $item_id Target item ID.
     * @return array Collection of ian tem.
     */
    function ItemGetById($item_id) {
        // return get_single_data(
        //  "SELECT * FROM item_master WHERE item_master_id = '$item_id'"
        // );
        $query = "SELECT * FROM item_master WHERE item_master_id = :item_id";
        $param = ["item_id" => $item_id];
        return get_single_data($query, $param);
    }


    /**
     * Retrieve categories defined in the code_master table.
     * @return array List of categories.
     */
    function ItemGetAllCategory() {
        // return get_data(
        //  "SELECT * FROM code_master WHERE code_master_category = 'item_category'"
        // );
        $query = "SELECT * FROM code_master WHERE code_master_category = 'item_category'";
        $param = [];
        return get_data($query, $param);
    }


    /**
     * Retrieve status labels defined in the code_master table.
     * @return array List of statuses.
     */
    function ItemGetAllStatus() {
        // return get_data(
        //  "SELECT * FROM code_master WHERE code_master_category = 'item_status'"
        // );
        $query = "SELECT * FROM code_master WHERE code_master_category = 'item_status'";
        $param = [];
        return get_data($query, $param);
    }


    /**
     * Retrieve category labels defined in the code_master table.
     * @return string Label of item's category.
     */
    function ItemGetCategoryLabel($category_code) {
        // $data_category = get_single_data(
        //  "SELECT code_master_label FROM code_master WHERE code_master_category = 'item_category' ".
        //  "AND code_master_code = '$category_code'"
        // );
        // return $data_category['code_master_label'];
        $query = "SELECT code_master_label FROM code_master WHERE code_master_category = 'item_category' AND code_master_code = :category_code";
        $param = ["category_code" => $category_code];
        $data_category = get_single_data($query, $param);
        return $data_category['code_master_label'];
    }


    function ItemGetAllName() {
        // return get_data(
        //  "SELECT DISTINCT item_master_name FROM item_master ORDER BY item_master_name ASC"
        // );
        $query = "SELECT DISTINCT item_master_name FROM item_master ORDER BY item_master_name ASC";
        $param = [];
        return get_data($query, $param);
    }
}
?>