<?php
/**
 * Ticket Notification View
 * * Filters and displays maintenance tickets with an 'Open' status (0).
 * Provides a streamlined interface for administrators to quickly identify
 * and respond to new maintenance requests.
 *
 * @uses Tickets
 * @return void Renders a filtered list of open tickets with a quick-response action.
 */

session_start();

require '../config.php';
include '../function/db-query.php';
include_once "../function/class/Tickets.php";

if (!$_SESSION['user_login_status']) {
	header("location:".BASE_URL."/login.php?status=not_login");
}

$_Ticket = new Tickets;
// get all ticket data
$data_ticket = $_Ticket->TicketGetAll();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Notifikasi</title>

	<!-- styling -->
	<?php include("../layout/styling.php") ?>
</head>
<body>
	<?php include("../layout/body-theme.php") ?>

	<div id="app">
		<!-- sidebar -->
		<?php include("../layout/sidebar.php") ?>

		<div id="main" class="layout-navbar navbar-fixed">
			<!-- navbar -->
			<?php include("../layout/navbar.php") ?>

			<!-- main content -->
			<div id="main-content">
				<section id="basic-vertical-layouts">
					<div class="row match-height">
						<div class="col">
							<div class="card">
								<div class="card-header">
									<h3>Notifikasi Tiket</h3>
								</div>

								<div class="card-content">
									<div class="card-body">
										<table id="notifications_table" class="table table-striped">
											<thead>
												<tr>
													<th>Ticket ID</th>
													<th>Tanggal Pelaporan</th>
													<th>Permasalahan</th>
													<th>Dibuat Oleh</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($data_ticket as $ticket): ?>
													<?php if($ticket['ticket_master_status'] == 0): ?>
													<tr>
														<td><a href="<?= BASE_URL.'/dashboard/ticket/ticket-detail.php?id='.$ticket['ticket_master_id']?>"><?= '#TICKET-'.$ticket['ticket_master_id'] ?></a></td>
														<td><?= $ticket['ticket_master_effdate'] ?></td>
														<td><?= $ticket['ticket_master_topic'] ?></td>
														<td><?= $ticket['ticket_master_createby'] ?></td>
														<td><a href="<?= BASE_URL.'/dashboard/ticket/ticket-detail.php?id='.$ticket['ticket_master_id']."&&action=respond" ?>" class="btn icon btn-success"><i class="bi bi-send"></i> <span class="d-none d-md-inline"> Respon</span></a></td>
													</tr>
													<?php endif ?>
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
			<?php include("../layout/footer.php") ?>
		</div>
	</div>

	<!-- datatables -->
	<script>
		let dataTable = new DataTable("#notifications_table", {
			responsive: {
				details: {
					display: DataTable.Responsive.display.childRowImmediate
				}
			},
			rowReorder: {
				selector: 'td:nth-child(3)'
			},
			searching: false,
			paging: false,
		});
	</script>
	<!-- js -->
	<?php include("../layout/javascript.php") ?>
</body>
</html>