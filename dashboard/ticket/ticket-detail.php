<?php  
session_start();

require '../../config.php';
include '../../function/db-query.php';
include_once '../../function/class/Tickets.php';
include_once '../../function/class/Users.php';
include_once '../../function/class/Items.php';
include_once '../../function/class/Areas.php';

if (!$_SESSION['user_login_status']) {
	header("location:".BASE_URL."/login.php?status=not_login");
}

// redirect if no id given
if (!$_GET['id']) {
	header("location:ticket-page.php");
}

function name_monograph(string $name) {
	$name = strtoupper($name);
	if (strlen($name) <= 3) {
		return ($name[0].$name[1]);
	} else {
		$name = explode(" ", $name);
		if (count($name) < 2) {
			return ($name[0][0].$name[0][1]);
		} else {
			$temp='';
			for ($i=0; $i < count($name) ; $i++) {
				$temp = $temp.$name[$i][0];
			}
			return $temp;
		}
	}
}

$_Item = new Items;
$_User = new Users;
$_Area = new Areas;
$_Ticket = new Tickets;

$data_user = $_User->UserGetAll();
$data_ticket = $_Ticket->TicketDetail($_GET['id']);
$data_item = $_Item->ItemDetail($data_ticket['ticket_master_item_id']);
$data_comment = $_Ticket->TicketGetComment($_GET['id']);


$location = $_Area->AreaDetail($data_item['item_master_area_id']);
$location = $location['area_master_name'] . " - " . "Lantai " . $location['area_master_floor'];


// comment submit
if (isset($_POST['comment_Submit'])) {
	$_Ticket->TicketAddComment($_GET['id'], $_POST['comment_content'], $_SESSION['user_uname']);
	header("location:ticket-detail.php?id=".$_GET['id']);
}

// update ticket status
if (isset($_POST['update_ticket_progress_Submit'])) {
	$status = get_single_data("SELECT code_master_label FROM code_master WHERE code_master_category = 'ticket_status' AND code_master_code = {$_POST['ticket_status_progress']}");
	$status = $status['code_master_label'];
	if ($_POST['ticket_status_progress'] == "4") { // 4 means ticket will be closed
		$_Ticket->TicketUpdateStatus($_GET['id'], $_POST['ticket_status_progress']);
		$_Ticket->TicketAddComment($_GET['id'], "Tiket <b>Closed</b> dengan remaks: ".$_POST['ticket_status_comment'], $_SESSION['user_uname']);
		header("location:ticket-detail.php?id=".$_GET['id']);
	} else {
		$_Ticket->TicketUpdateStatus($_GET['id'], $_POST['ticket_status_progress']);
		$_Ticket->TicketAddComment($_GET['id'], ucfirst($_SESSION['user_uname'])." mengubah status tiket menjadi <b>$status</b> dengan remarks: ".$_POST['ticket_status_comment'], $_SESSION['user_uname']);
		header("location:ticket-detail.php?id=".$_GET['id']);
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tiket Pelaporan #TICKET<?= $_GET['id'] ?></title>

	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/extensions/quill/quill.snow.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/extensions/quill/quill.bubble.css">

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
						<div class="col-12 col-lg-3">
							<div class="card">
								<div class="card-header">
									<h4>Detail #TIKET<?= $_GET['id'] ?></h4>
								</div>

								<div class="card-body">
									<div class="form-body">
										<div class="row">
											<div class="col">
												<div class="form-group">
													<label>PIC (Person-in-Charge)</label>
													<select class="form-control" disabled>
														<option value="">--- Pilih PIC ---</option>
														<?php foreach ($data_user as $user): ?>
															<option value="<?= $user['user_master_uname'] ?>" 
																<?php echo ($data_ticket['ticket_master_currentholder'] == $user['user_master_uname']) ? "selected":""; ?>
																><?= $user['user_master_uname'] ?></option>
														<?php endforeach ?>
													</select>
												</div>

												<div class="form-group">
													<label>Status</label>
													<select class="form-control" disabled>
														<option value="">--- Status Tiket ---</option>
														<option value="0" <?php echo ($data_ticket['ticket_master_status'] == '0') ? "selected":""; ?>>Open</option>
														<option value="1" <?php echo ($data_ticket['ticket_master_status'] == '1') ? "selected":""; ?>>In Progress</option>
														<option value="2" <?php echo ($data_ticket['ticket_master_status'] == '2') ? "selected":""; ?>>On Hold</option>
														<option value="3" <?php echo ($data_ticket['ticket_master_status'] == '3') ? "selected":""; ?>>Resolved</option>
														<option value="4" <?php echo ($data_ticket['ticket_master_status'] == '4') ? "selected":""; ?>>Closed</option>
													</select>
												</div>

												<div class="form-group">
													<label>Nama Barang</label>
													<input type="text" class="form-control" value="<?= $data_item['item_master_name']." [".$location."]" ?>"readonly="readonly">
												</div>

												<div class="form-group">
													<label>Permasalahan</label>
													<input type="text" class="form-control" value="<?= $data_ticket['ticket_master_topic'] ?>"readonly="readonly">
												</div>

												<div class="form-group">
													<label>Deskripsi</label>
													<textarea class="form-control" readonly="readonly" rows="5"><?= $data_ticket['ticket_master_description'] ?></textarea>
												</div>

												<div class="form-group">
													<label>Tanggal Efektif</label>
													<input type="text" class="form-control" value="<?= $data_ticket['ticket_master_effdate'] ?>"readonly="readonly">
												</div>
												<?php if ($data_ticket['ticket_master_status'] != '4'): ?>
												<button type="button" class="btn btn-success me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_update_ticket_progress">Update Status Tiket</button>
												<?php endif ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 col-lg-9">
							<div class="card">
								<div class="card-header">
									<h4>Komentar</h4>
								</div>

								<?php if ($data_ticket['ticket_master_status'] != '4'): ?>
								<div class="card-body">
									<div class="form-body">
										<div class="row">
											<div class="col">
												<form method="POST" id="comment_form">
													<input type="hidden" name="comment_content" id="comment_content">
													<div class="form-group">
														<div id="comment_editor">
										                </div>
													</div>
													<button type="submit" name="comment_Submit" class="btn btn-primary me-1 mb-1">Tambah Komentar</button>
												</form>
											</div>
										</div>
									</div>
								</div>
								<?php endif ?>

								<!-- loop comment di sini -->
								<?php foreach ($data_comment as $comment): ?>
									
								<div class="card-body">
									<div class="form-body">
										<div class="row">
											<div class="col">
												<!-- isi comment di sini -->
												<div class="divider divider-left">
						                            <div class="divider-text">
						                            	<div class="avatar bg-warning me-3">
							                            	<span class="avatar-content"><?= name_monograph($comment['ticket_detail_commentby']) ?></span>
							                            </div>
						                            	<?php echo "<b>".ucfirst($comment['ticket_detail_commentby'])."</b> ".$comment['ticket_detail_commenttime'] ?>
						                            </div>
						                        </div>
						                        <?= $comment['ticket_detail_comment'] ?>
						                        <hr>
											</div>
										</div>
									</div>
								</div>
								<?php endforeach ?>

							</div>
						</div>
					</div>
				</section>
            </div>

            <!-- modal update ticket status -->
			<form method="POST">
				<div class="modal fade text-left" id="modal_update_ticket_progress" tabindex="-1" role="dialog">
	                <div class="modal-dialog modal-dialog-scrollable" role="document">
	                    <div class="modal-content">
	                        <div class="modal-header">
	                            <h5 class="modal-title">Update Status #TIKET<?= $_GET['id'] ?></h5>
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
												<label>Progress Tiket</label>
												<select class="form-control" name="ticket_status_progress" required>
													<option value="">--- Pilih Status Progress ---</option>
													<option value="1">In Progress</option>
													<option value="2">On Hold</option>
													<option value="3">Resolved</option>
													<option value="4">Closed</option>
												</select>
											</div>

											<div class="form-group">
												<label>Remarks</label>
												<textarea name="ticket_status_comment" class="form-control" rows="5" required></textarea>
											</div>

										</div>
									</div>
	                        	</div>
	                        </div>
	                        <div class="modal-footer">
	                        	<button type="submit" name="update_ticket_progress_Submit" class="btn btn-success me-1 mb-1">Update</button>
	                            <button type="button" class="btn" data-bs-dismiss="modal">
	                                Tutup
	                            </button>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </form>


            <!-- footer -->
            <?php include("../../layout/footer.php"); ?>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/extensions/quill/quill.min.js"></script>
    <script>
        var quill = new Quill('#comment_editor', {
            theme: 'snow', // Or 'bubble'
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['link', 'image']
                ]
            }
        });

        var comment_form = document.getElementById('comment_form'); // select form
        comment_form.onsubmit = function() { // while form submitted
        	var content = document.querySelector('input[name=comment_content'); // select input tag id
        	content.value = quill.root.innerHTML; // then pass value from innerhtml of quill (which is #comment_editor)
        										  // to the input tag
        };
    </script>

    <!-- javascript -->
    <?php include("../../layout/javascript.php"); ?>
</body>
</html>