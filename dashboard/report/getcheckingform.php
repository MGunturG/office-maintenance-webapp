<?php
header('Content-Type: application/json');

session_start();
require '../../config.php';
include '../../function/db-query.php';

$query = "
    SELECT
        cm.checkingform_master_id AS checkingform_id,
        cm.checkingform_master_effdate AS date,
        am.area_master_floor AS floor,
        am.area_master_name AS area,
        cm.checkingform_master_remark AS remark,
        cm.checkingform_master_createby AS user,
        co.code_master_label AS status,
        GROUP_CONCAT(im.item_master_name SEPARATOR ', ') AS items_checked
    FROM
        checkingform_master cm
    JOIN
        area_master am ON cm.checkingform_master_area_id = am.area_master_id
    LEFT JOIN
        code_master co ON cm.checkingform_master_status = co.code_master_code 
        AND co.code_master_category = 'form_status'
    LEFT JOIN
        checkingform_detail cd ON cm.checkingform_master_id = cd.checkingform_detail_master_id
    LEFT JOIN
        item_master im ON cd.checkingform_detail_item_id = im.item_master_id
    GROUP BY
        cm.checkingform_master_id
    ORDER BY
        cm.checkingform_master_id ASC;
";

$data_form = get_data($query);
echo json_encode(["data" => $data_form]);
?>