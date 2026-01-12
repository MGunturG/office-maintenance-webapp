<?php
session_start();

require '../../config.php';
include '../../function/db-query.php';

$query = "
    SELECT 
        t.ticket_master_id AS Ticket_ID,
        t.ticket_master_topic AS Issue,
        i.item_master_name AS Asset,
        a.area_master_name AS Location,
        c.code_master_label AS Status,
        t.ticket_master_currentholder AS Assignee,
        t.ticket_master_effdate AS Date_Reported
    FROM ticket_master t
    JOIN item_master i ON t.ticket_master_item_id = i.item_master_id
    JOIN area_master a ON i.item_master_area_id = a.area_master_id
    JOIN code_master c ON t.ticket_master_status = c.code_master_code
    WHERE c.code_master_category = 'ticket_status'
    ORDER BY t.ticket_master_effdate DESC";

$data_ticket = get_data($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- edit page title -->
    <title>Report Tiket Maintenance</title>

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
                                            <h3>Report Tiket Maintenance</h3>
                                        </div>

                                        <div class="col d-flex justify-content-end">
                                            <!-- <button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_add_item"><i class="bi bi-plus-lg"></i> <span class="d-none d-md-inline"> Tambah Barang</span></button> -->
                                        </div>
                                    </div>
                                </div>

                                <!-- tabel -->
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row match-height">

                                            <div class="col d-flex justify-content">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                <input type="text" id="min" name="min" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col d-flex justify-content">
                                                <div class="form-group">
                                                    <label>End Date</label>
                                                    <input type="text" id="max" name="max" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col d-flex justify-content">
                                                <div>
                                                    <label>Barang</label>
                                                    <input type="text" id="search-item" class="form-control" placeholder="">
                                                </div> 
                                            </div>

                                            <div class="col d-flex justify-content">
                                                <div>
                                                    <label>Area/Lokasi</label>
                                                    <input type="text" id="search-area" class="form-control" placeholder="">
                                                </div> 
                                            </div>

                                            <div class="col d-flex justify-content">
                                                <div>
                                                    <label>Status</label>
                                                    <input type="text" id="search-status" class="form-control" placeholder="">
                                                </div> 
                                            </div>

                                            <div class="col d-flex justify-content">
                                                <div>
                                                    <label>Assignee</label>
                                                    <input type="text" id="search-assignee" class="form-control" placeholder="">
                                                </div> 
                                            </div>
                                        </div>

                                        <table id="tickets_table" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Ticket ID</th>
                                                    <th>Tanggal Lapor</th>
                                                    <th>Permasalahan</th>
                                                    <th>Barang</th>
                                                    <th>Lokasi</th>
                                                    <th>Status</th>
                                                    <th>Assignee</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($data_ticket as $data): ?>
                                                <tr>
                                                    <td><?= "#".$data['Ticket_ID'] ?></td>
                                                    <td><?= $data['Date_Reported'] ?></td>
                                                    <td><?= $data['Issue'] ?></td>
                                                    <td><?= $data['Asset'] ?></td>
                                                    <td><?= $data['Location'] ?></td>
                                                    <td><?= $data['Status'] ?></td>
                                                    <td><?= $data['Assignee'] ?></td>
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
    <!-- datatables -->
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

        let dataTable = new DataTable("#tickets_table", {
            dom:"lrtip",
            responsive: {
                details: {
                    display: DataTable.Responsive.display.childRowImmediate
                }
            },
            language: {
                lengthMenu: " _MENU_ per halaman"
            },
            columnDefs: [{
                targets: [1],
                type: 'date',
            }],
            order: [
                [1, 'desc']
            ],
            paging: false,
        });

        // Refilter the table
        document.querySelectorAll('#min, #max').forEach((el) => {
            el.addEventListener('change', () => dataTable.draw());
        });

        // Search Item
        document.querySelector('#search-item').addEventListener('keyup', function() {
            dataTable.column(3).search(this.value).draw();
        });

        // Search Item
        document.querySelector('#search-area').addEventListener('keyup', function() {
            dataTable.column(4).search(this.value).draw();
        });

        // Search Status
        document.querySelector('#search-status').addEventListener('keyup', function() {
            dataTable.column(5).search(this.value).draw();
        });

        // Search Assignee
        document.querySelector('#search-assignee').addEventListener('keyup', function() {
            dataTable.column(6).search(this.value).draw();
        });
    </script>

    <?php include("../../layout/javascript.php"); ?>
</body>

</html>