<?php
session_start();

require '../../config.php';
include '../../function/db-query.php';
include_once '../../function/class/Forms.php';
include_once '../../function/class/Items.php';
include_once '../../function/class/Areas.php';
include_once "../../function/class/Users.php";

$_Form = new Forms;
$_Item = new Items;
$_Area = new Areas;
$_User = new Users;

$data_floor = $_Area->AreaGetFloor();
$data_item = $_Item->ItemGetAllName();
$data_area = $_Area->AreaGetAll();
$data_user = $_User->UserGetAll();

$data_category = get_data("SELECT code_master_label FROM code_master WHERE code_master_category = 'item_category'");

$query = "
SELECT
    cm.checkingform_master_effdate     AS effdate,
    cd.checkingform_detail_master_id   AS checkingform_id,
    im.item_master_name                AS item_name,
    cat.code_master_label              AS item_cat,
    co.code_master_label               AS item_status,
    am.area_master_name                AS area_name,
    am.area_master_floor               AS floor,
    cm.checkingform_master_createby    AS check_by

FROM checkingform_detail AS cd

JOIN checkingform_master AS cm
  ON cd.checkingform_detail_master_id = cm.checkingform_master_id

LEFT JOIN item_master AS im
  ON cd.checkingform_detail_item_id = im.item_master_id

LEFT JOIN area_master AS am
  ON cm.checkingform_master_area_id = am.area_master_id

LEFT JOIN code_master as co
  ON cd.checkingform_detail_item_status = co.code_master_code
  AND co.code_master_category = 'form_item_status'

LEFT JOIN code_master as cat
  ON im.item_master_category = cat.code_master_code
  AND cat.code_master_category = 'item_category'

GROUP BY
    cd.checkingform_detail_id;
";

$data_checkingform = get_data($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Pengecekan</title>

    <!-- styling -->
    <?php include("../../layout/styling.php"); ?>
</head>

<body>
    <?php include("../../layout/body-theme.php"); ?>

    <div id="app">
        <!-- sidebar -->
        <?php include("../../layout/sidebar.php"); ?>

        <div id="main" class='layout-navbar navbar-fixed'>
            <!-- navbar -->
            <?php include("../../layout/navbar.php"); ?>

            <!-- main content -->
            <div id="main-content">
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row match-height">
                                        <div class="col d-flex justify-content">
                                            <h3>Report Pengecekan</h3>
                                        </div>

                                        <div class="col d-flex justify-content-end">
                                            <!-- <button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_add_item"><i class="bi bi-plus-lg"></i> <span class="d-none d-md-inline"> Tambah Barang</span></button> -->
                                        </div>
                                    </div>
                                </div>

                                <!-- tabel -->
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="accordion" id="accordionFiltering">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                    Data Filtering Menu
                                                    </button>
                                                </h2>
                                                <!-- TODOOOOOO -->
                                                <!-- Fetch data dari db buat list di option buat filtering -->
                                                <!-- hari selasa kelarin yaaaa -->
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionFiltering">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Start Date</label>
                                                                    <input type="text" id="min" name="min" class="form-control">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>End Date</label>
                                                                    <input type="text" id="max" name="max" class="form-control">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Pembuat</label>
                                                                    <select name="search-user" id="search-user" class="choices form-select multiple-remove" multiple="multiple">
                                                                        <option value="">--- Pilih User ---</option>
                                                                        <?php foreach ($data_user as $user): ?>
                                                                            <option value="<?= $user['user_master_uname'] ?>"><?= $user['user_master_uname'] ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                    <select name="search-status" id="search-status" class="choices form-select multiple-remove" multiple="multiple">
                                                                        <option value="">--- Pilih Status ---</option>
                                                                        <option value="OK">OK</option>
                                                                        <option value="Rusak">Rusak</option>
                                                                    </select>
                                                                </div>  
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Kategori Barang</label>
                                                                    <select name="search-category" id="search-category" class="choices form-select multiple-remove" multiple="multiple">
                                                                        <option value="">--- Pilih Kategori Barang ---</option>
                                                                        <?php foreach ($data_category as $category): ?>
                                                                            <option value="<?= $category['code_master_label'] ?>"><?= $category['code_master_label'] ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Barang</label>
                                                                    <select name="search-item" id="search-item" class="choices form-select multiple-remove" multiple="multiple">
                                                                        <option value="">--- Pilih Barang ---</option>
                                                                        <?php foreach ($data_item as $item): ?>
                                                                            <option value="<?= $item['item_master_name'] ?>"><?= $item['item_master_name'] ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div> 

                                                                <div class="form-group">
                                                                    <label>Lantai</label>
                                                                    <select name="search-floor" id="search-floor" class="choices form-select multiple-remove" multiple="multiple">
                                                                        <option value="">--- Pilih Lantai ---</option>
                                                                        <?php foreach($data_floor as $floor): ?>
                                                                            <option value="Lantai <?= $floor['area_master_floor'] ?>">Lantai <?= $floor['area_master_floor'] ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div> 

                                                                <div class="form-group">
                                                                    <label>Area</label>
                                                                    <select name="search-area" id="search-area" class="choices form-select multiple-remove" multiple="multiple">
                                                                        <option value="">--- Pilih Area ---</option>
                                                                        <?php foreach ($data_area as $area): ?>
                                                                            <option value="<?= $area['area_master_name'] ?>"><?= $area['area_master_name'] ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                      
                                                        

                                        <table id="forms_table" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal Cek</th>
                                                    <th>Barang</th>
                                                    <th>Kategori</th>
                                                    <th>Status</th>
                                                    <th>Area</th>
                                                    <th>Lantai</th>
                                                    <th>Dicek Oleh</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($data_checkingform as $data): ?>
                                                <tr>
                                                    <td><?= $data['effdate'] ?></td>
                                                    <td><?= $data['item_name'] ?></td>
                                                    <td><?= $data['item_cat'] ?></td>
                                                    <td><?= $data['item_status'] ?></td>
                                                    <td><?= $data['area_name'] ?></td>
                                                    <td><?= "Lantai ".$data['floor'] ?></td>
                                                    <td><?= $data['check_by'] ?></td>
                                                </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- footer -->
            <?php include("../../layout/footer.php"); ?>
        </div>
    </div>

    <!-- javascript -->
    <script>
        let minDate, maxDate;
         
        // Custom filtering function which will search data in column four between two values
        DataTable.ext.search.push(function (settings, data, dataIndex) {
            let min = minDate.val();
            let max = maxDate.val();
            let date = new Date(data[0]);
         
            if (
                (min === null && max === null) ||
                (min === null && date <= max) ||
                (min <= date && max === null) ||
                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        });
         
        // Create date inputs
        minDate = new DateTime('#min', {
            format: 'Do MMMM YYYY'
        });
        maxDate = new DateTime('#max', {
            format: 'Do MMMM YYYY'
        });

        let dataTable = new DataTable("#forms_table", {
            layout: {
                topEnd: {
                    buttons: ['copy', 'excel', 'pdf', 'print']
                },
                topStart: 'pageLength',
            },
            responsive: {
                details: {
                    display: DataTable.Responsive.display.childRowImmediate
                }
            },
            language: {
                lengthMenu: " _MENU_ per page"
            },
            columnDefs: [{
                targets: [0],
                type: 'date',
            }],
            order: [
                [0, 'desc']
            ],
            // paging: false,
        });

        // Refilter the table
        document.querySelectorAll('#min, #max').forEach((el) => {
            el.addEventListener('change', () => dataTable.draw());
        });

        // Search Item
        document.querySelector('#search-item').addEventListener('change', function() {
            let selectedValues = Array.from(this.selectedOptions).map(option => option.value.trim());
            let searchString = selectedValues.join('|');
            // console.log("Searching for:", searchString);
            dataTable.column(1).search(searchString, true, false).draw();
        });

        // Search Category
        document.querySelector('#search-category').addEventListener('change', function() {
            let selectedValues = Array.from(this.selectedOptions).map(option => option.value.trim());
            let searchString = selectedValues.join('|');
            // console.log("Searching for:", searchString);
            dataTable.column(2).search(searchString, true, false).draw();
        });

        // Search Status
        document.querySelector('#search-status').addEventListener('change', function() {
            let selectedValues = Array.from(this.selectedOptions).map(option => option.value.trim());
            let searchString = selectedValues.join('|');
            // console.log("Searching for:", searchString);
            dataTable.column(3).search(searchString, true, false).draw();
        });

        // Search Area
        document.querySelector('#search-area').addEventListener('change', function() {
            let selectedValues = Array.from(this.selectedOptions).map(option => option.value.trim());
            let searchString = selectedValues.join('|');
            // console.log("Searching for:", searchString);
            dataTable.column(4).search(searchString, true, false).draw();
        });

        // Search Floor
        document.querySelector('#search-floor').addEventListener('change', function() {
            let selectedValues = Array.from(this.selectedOptions).map(option => option.value.trim());
            let searchString = selectedValues.join('|');
            // console.log("Searching for:", searchString);
            dataTable.column(5).search(searchString, true, false).draw();
        });

        // Search User
        document.querySelector('#search-user').addEventListener('change', function() {
            let selectedValues = Array.from(this.selectedOptions).map(option => option.value.trim());
            let searchString = selectedValues.join('|');
            // console.log("Searching for:", searchString);
            dataTable.column(6).search(searchString, true, false).draw();
        });
    </script>

    <?php include("../../layout/javascript.php"); ?>
</body>

</html>