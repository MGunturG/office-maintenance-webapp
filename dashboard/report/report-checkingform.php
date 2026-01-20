<?php
session_start();

require '../../config.php';
include '../../function/db-query.php';
include_once '../../function/class/Forms.php';
include_once '../../function/class/Items.php';
include_once '../../function/class/Areas.php';

$_Form = new Forms;
$_Item = new Items;
$_Area = new Areas;

$data_floor = $_Area->AreaGetFloor();

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
                                                                        
                                                                    </select>
                                                                </div> 
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Lantai</label>
                                                                    <select name="search-floor" id="search-floor" class="choices form-select multiple-remove" multiple="multiple">
                                                                        <option value="">--- Pilih Lantai ---</option>
                                                                        
                                                                    </select>
                                                                </div> 

                                                                <div class="form-group">
                                                                    <label>Area</label>
                                                                    <select name="search-area" id="search-area" class="choices form-select multiple-remove" multiple="multiple">
                                                                        <option value="">--- Pilih Area ---</option>
                                                                        
                                                                    </select>
                                                                </div> 

                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                    <select name="search-status" id="search-status" class="choices form-select multiple-remove" multiple="multiple">
                                                                        <option value="">--- Pilih Status ---</option>
                                                                        
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
            let date = new Date(data[1]);
         
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
    </script>

    <?php include("../../layout/javascript.php"); ?>
</body>

</html>