<?php
session_start();

require '../../config.php';
include '../../function/db-query.php';
include_once "../../function/class/Tickets.php";
include_once "../../function/class/Items.php";
include_once "../../function/class/Areas.php";
include_once "../../function/class/Users.php";
include_once "../../function/class/Logs.php";

if (!$_SESSION['user_login_status']) {
	header("location:".BASE_URL."/login.php?status=not_login");
}

$_Log = new Logs;
$_User = new Users;
$_Item = new Items;
$_Area = new Areas;
$_Ticket = new Tickets;

// get all item data
$data_item = $_Item->ItemGetAll();

// get all area data
$data_area = $_Area->AreaGetAll();

// get all ticket data
$data_ticket = $_Ticket->TicketGetAll();

// get all users data
$data_user = $_User->UserGetAll();

$current_date = date('Y-m-d');

// ticket submit
if (isset($_POST['create_ticket_Submit'])) {
	// set selected item status to maintenance
	$_Item->ItemUpdateStatus($_POST['ticket_itemid'], 3);

	$_Ticket->TicketCreate(
		$_POST['ticket_topic'],
		$_POST['ticket_description'],
		$_POST['ticket_itemid'],
		$_POST['ticket_effdate'],
		$_POST['ticket_pic']
	);

	// get last insert table id on last query 
	// to database, the last query was creating
	// ticket. sooooo, if running update item status
	// after creating new ticket, the last id will be
	// from table item status, not the ticket table
	$ticket_id_that_just_created = mysqli_insert_id($db_connection); 

	$_Log->LogCreate("Ticket", $ticket_id_that_just_created, "Created new ticket and assign ticket to ".$_POST['ticket_pic'], $_SESSION['user_uname']);

	header("location:ticket-detail.php?id=".$ticket_id_that_just_created);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tiket Maintenance	</title>

	<!-- styling -->
    <?php include("../../layout/styling.php"); ?>
</head>
<body>
	<?php include("../../layout/body-theme.php"); ?>

	<div id="app">
		<!-- sidebar -->
		<?php include("../../layout/sidebar.php"); ?>
		<div id="main" class="layout-navbar navbar-fixed">
			<!-- navbar -->
			<?php include("../../layout/navbar.php"); ?>
			<div id="main-content">
				<section id="basic-vertical-layouts">
					<div class="row match-height">
						<div class="col">
							<div class="card">
								<div class="card-header">
									<div class="row match-height">
										<div class="col d-flex justify-content">
											<h4>Data Tiket Maintenance</h4>
										</div>

										<div class="col d-flex justify-content-end">
											<button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_add_area">Buat Tiket Baru</button>
										</div>
									</div>
								</div>

								<!-- tabel -->
								<div class="card-content">
									<div class="card-body">
										<table id="tickets_table" class="table table-striped">
											<thead>
												<tr>
													<!-- <th>No</th> -->
													<th>Ticket ID</th>
													<th>Tanggal Pelaporan</th>
													<th>Permasalahan</th>
													<th>Dibuat Oleh</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($data_ticket as $ticket): ?>
												<tr>
													<td><a href="ticket-detail.php?id=<?= $ticket['ticket_master_id'] ?>"><?= 'TICKET'.$ticket['ticket_master_id'] ?></a></td>
													<td><?= $ticket['ticket_master_effdate'] ?></td>
													<td><?= $ticket['ticket_master_topic'] ?></td>
													<td><?= $ticket['ticket_master_createby'] ?></td>
													<?php if ($ticket['ticket_master_status'] == 0): ?>
														<td><span class="badge bg-success">Open</span></td>
													<?php elseif ($ticket['ticket_master_status'] == 1): ?>
														<td><span class="badge bg-info">In Progress</span></td>
													<?php elseif ($ticket['ticket_master_status'] == 2): ?>
														<td><span class="badge bg-warning">On Hold</span></td>
													<?php elseif ($ticket['ticket_master_status'] == 3): ?>
														<td><span class="badge bg-primary">Resolved</span></td>
													<?php elseif ($ticket['ticket_master_status'] == 4): ?>
														<td><span class="badge bg-primary">Closed</span></td>
													<?php endif ?>
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

			<!-- modal create new ticket -->
			<form method="POST">
				<div class="modal fade text-left" id="modal_add_area" tabindex="-1" role="dialog">
	                <div class="modal-dialog" role="document">
	                    <div class="modal-content">
	                        <div class="modal-header">
	                            <h5 class="modal-title">Buat Tiket Maintenance</h5>
	                            <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
	                                aria-label="Close">
	                                <i data-feather="x"></i>
	                            </button>
	                        </div>
	                        <div class="modal-body">
	                        	<div class="form-body">
	                        		<div class="row">
	                        			<div class="col">
											<div class="form-group">
												<label>Barang Bermasalah</label>
												<select name="ticket_itemid" class="choices form-select" required>
													<option value="">--- Pilih Barang ---</option>
													<?php foreach ($data_item as $item): ?>
														<?php
														$location = $_Area->AreaDetail($item['item_master_area_id']);
														$location = $location['area_master_name'] . " - " . "Lantai " . $location['area_master_floor'];
														?>
														<option value="<?= $item['item_master_id'] ?>"><?= $item['item_master_name']." [". $location . "]"?></option>
													<?php endforeach ?>
												</select>
											</div>

											<div class="form-group">
												<label>Permasalahan</label>
												<input type="text" class="form-control"
												name="ticket_topic" placeholder="" required>
											</div>

											<div class="form-group">
												<label>Detail Masalah</label>
												<textarea class="form-control" name="ticket_description" 
												placeholder="Alasan detail mengapa perlu dibuatkan tiket maintenance untuk barang tersebut" required></textarea>
											</div>

											<div class="form-group">
												<label>Penanggung Jawab</label>
												<select name="ticket_pic" class="choices form-select" required>
													<option value="">--- Pilih PIC ---</option>
													<?php foreach ($data_user as $user): ?>
														<option value="<?= $user['user_master_uname'] ?>"><?= $user['user_master_uname'] ?></option>
													<?php endforeach ?>
												</select>
											</div>

											<div class="form-group">
												<label>Tanggal Pelaporan</label>
												<input type="date" class="form-control"
												name="ticket_effdate" value="<?= $current_date ?>" placeholder="" required>
											</div>
										</div>
									</div>
	                        	</div>
	                        </div>
	                        <div class="modal-footer">
	                        	<button type="submit" name="create_ticket_Submit" class="btn btn-primary me-1 mb-1">Submit</button>
	                            <button type="button" class="btn" data-bs-dismiss="modal">
	                                Tutup
	                            </button>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </form>

			<!-- footer -->
			<!-- <?php include("../../layout/footer.php") ?> -->
		</div>
	</div>

	<<!-- script>
		let dataTable = new simpleDatatables.DataTable(
			  document.getElementById("tickets_table") ,{
			  	searchable: false,
			  	paging: false,
			  }
			);
	</script> -->

	<!-- datatables -->
	<script>
		let dataTable = new DataTable("#tickets_table", {
			responsive: {
				details: {
					display: DataTable.Responsive.display.childRowImmediate
				}
			},
			rowReorder: {
				selector: 'td:nth-child(3)'
			},
			order: [
				[4, 'desc'],
				[1, 'desc'],
			],

			language: {
				lengthMenu: " _MENU_ per halaman"
			}
		});
	</script>

	<!-- js -->
	<?php include("../../layout/javascript.php") ?>
</body>
</html>