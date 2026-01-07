<?php  
/**
 * Maintenance Ticket Detail Handler
 * * Displays ticket specifications and manages interactions including 
 * rich-text commenting (Quill.js) and status lifecycle updates.
 *
 * @uses Tickets, Users, Items, Areas, Logs
 * @param int    $_GET['id'] The unique identifier for the maintenance ticket.
 * @param string $_POST['comment_content'] HTML content from the rich-text editor.
 * @param int    $_POST['ticket_status_progress'] Target status code (1-4).
 * @param string $_POST['ticket_status_comment'] Reason/Remarks for status change.
 * @return void Redirects to refresh the detail page after processing actions.
 */

session_start();

require '../../config.php';
include '../../function/db-query.php';
include_once '../../function/class/Tickets.php';
include_once '../../function/class/Users.php';
include_once '../../function/class/Items.php';
include_once '../../function/class/Areas.php';
include_once '../../function/class/Logs.php';

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

$_Log = new Logs;
$_Item = new Items;
$_User = new Users;
$_Area = new Areas;
$_Ticket = new Tickets;

$data_user = $_User->UserGetAll();
$data_ticket = $_Ticket->TicketDetail($_GET['id']);
$data_item = $_Item->ItemDetail($data_ticket['ticket_master_item_id']);
$data_comment = $_Ticket->TicketGetComment($_GET['id']);
// $next_comment_id = $data_comment[0]['ticket_detail_id'];
$data_log = $_Log->LogFetch("Ticket", $_GET['id']);


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
		$_Ticket->TicketUpdateStatus($_GET['id'], $_POST['ticket_status_progress']); // set ticket status to close
		$_Item->ItemUpdateStatus($data_item['item_master_id'], "1"); // update item status to active again
		$_Ticket->TicketAddComment($_GET['id'], "Tiket <b>Closed</b> dengan remaks: ".$_POST['ticket_status_comment'], $_SESSION['user_uname']);
		$_Log->LogCreate('Ticket', $_GET['id'], "Ticket closed", $_SESSION['user_uname']);

		header("location:ticket-detail.php?id=".$_GET['id']);
	} else {
		$_Ticket->TicketUpdateStatus($_GET['id'], $_POST['ticket_status_progress']);
		$_Ticket->TicketAddComment($_GET['id'], ucfirst($_SESSION['user_uname'])." mengubah status tiket menjadi <b>$status</b> dengan remarks: ".$_POST['ticket_status_comment'], $_SESSION['user_uname']);
		$_Log->LogCreate("Ticket", $_GET['id'], "Ticket status changed to $status", $_SESSION['user_uname']);

		header("location:ticket-detail.php?id=".$_GET['id']);
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tiket Maintenance : #TICKET<?= $_GET['id'] ?></title>

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
									<?php if ($data_ticket['ticket_master_status'] == 0): ?>
										<td><span class="badge bg-success">Open</span></td>
									<?php elseif ($data_ticket['ticket_master_status'] ==  1): ?>
										<td><span class="badge bg-info">Dalam Pengerjaan</span></td>
									<?php elseif ($data_ticket['ticket_master_status'] == 2): ?>
										<td><span class="badge bg-warning">Tertunda</span></td>
									<?php elseif ($data_ticket['ticket_master_status'] == 3): ?>
										<td><span class="badge bg-primary">Selesai Pengerjaan</span></td>
									<?php elseif ($data_ticket['ticket_master_status'] == 4): ?>
										<td><span class="badge bg-primary">Closed</span></td>
									<?php endif ?>
								</div>

								<div class="card-body">
									<div class="form-body">
										<div class="row">
											<div class="col">
												<div class="form-group">
													<label>PIC (Person-in-Charge)</label>
													<input type="text" class="form-control" value="<?= $data_ticket['ticket_master_currentholder'] ?>" readonly>
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

												<button type="button" class="btn btn-primary me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_logs_ticket"><i class="bi bi-list-columns-reverse"></i> <span class="d-none d-md-inline"> Lihat Log</span></button>
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
													<button type="submit" name="comment_Submit" class="btn btn-primary me-1 mb-1"><i class="bi bi-chat"></i> Kirim Komentar</button>

													<button id="add_picture_button" type="button" class="btn btn-warning me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_upload_picture"><i class="bi bi-image"></i> <span class="d-none d-md-inline"> Upload Foto</span></button>

													<button id="update_ticket_button" type="button" class="btn btn-success me-1 mb-1" data-bs-toggle="modal" data-bs-target="#modal_update_ticket_progress"><i class="bi bi-tag"></i> <span class="d-none d-md-inline"> Update Status Tiket</span></button>

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
	                <div class="modal-dialog" role="document">
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
													<option value="1">Dalam Pengerjaan</option>
													<option value="2">Tunda Sementara</option>
													<option value="3">Pengerjaan Selesai</option>
													<option value="4">Tutup Tiket</option>
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

	        <!-- modal upload picture -->
	        <div class="modal fade text-left" id="modal_upload_picture" tabindex="-1" role="dialog">
		        <div class="modal-dialog" role="document">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <h5 class="modal-title">Upload Gambar</h5>
		                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
		                        aria-label="Close">
		                        <i data-feather="x"></i>
		                    </button>
		                </div>

		                <form method="POST" action="<?= BASE_URL ?>/function/upload-function.php" enctype="multipart/form-data">
							<input type="hidden" name="id" value="-1">
							<input type="hidden" name="action" value="insert_comment_picture">
							<input type="hidden" name="ticket_id" value="<?= $_GET['id'] ?>">
							
		                    <div class="modal-body">
		                    	<div class="form-body">
		                    		<div class="row">
		                    			<div class="col">
											<div class="form-group">
												<label>Pilih File</label>
												<input type="file" class="form-control" name="fileToUpload" onchange="showPreview(event);" required>
											</div>

											<div class="form-group">
												<img id="file-ip-1-preview" class="card-img-top img-fluid">
											</div>
										</div>
									</div>
		                    	</div>
		                    </div>
		                    <div class="modal-footer">
		                    	<button type="submit" name="upload_Submit" class="btn btn-primary me-1 mb-1">Upload</button>
		                        <button type="button" class="btn me-1 mb-1" data-bs-dismiss="modal">
		                            Batal
		                        </button>
		                    </div>
		               </form>
		               
		            </div>
		        </div>
		    </div>

		    <!-- modal view item's log -->
			<div class="modal fade text-left" id="modal_logs_ticket" tabindex="-1" role="dialog">
		        <div class="modal-dialog" role="document">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <h5 class="modal-title">Log Aktivitas Tiket</h5>
		                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
		                        aria-label="Close">
		                        <i data-feather="x"></i>
		                    </button>
		                </div>

		                <?php
		                	
		                ?>
		                <table id="logs_table" class="table table-striped">
		                	<thead>
		                		<tr>
		                			<th>Activity</th>
		                			<th>By User</th>
		                			<th>Date</th>
		                		</tr>
		                	</thead>
		                		<?php foreach ($data_log as $log): ?>
		                		<tr>
		                			<td><?= $log['activity_log_action'] ?></td>
		                			<td><?= $log['activity_log_user'] ?></td>
		                			<td><?= $log['activity_log_timestamp'] ?></td>
		                		</tr>
		                		<?php endforeach ?>
		                	<tbody>
		                	</tbody>
		                </table>
		               <div class="modal-footer">
			                <button type="button" class="btn me-1 mb-1" data-bs-dismiss="modal">
			                    Tutup
			                </button>
		                </div>
		            </div>
		        </div>
		    </div>

            <!-- footer -->
            <?php include("../../layout/footer.php"); ?>
        </div>
    </div>

    <?php
	if (isset($_GET['action']) && $_GET['action']=="respond") {
		echo "<script>
		        document.addEventListener('DOMContentLoaded', function() {
		            var button = document.getElementById('update_ticket_button');
		            if (button) {
		                button.click();
		            } else {
		                // console.error('Button not found');
		            }
		        });
		    </script>";
	}
	?>

	<script>
		let dataTable = new DataTable("#logs_table", {
			responsive: {
				details: {
					display: DataTable.Responsive.display.childRowImmediate
				}
			},
			searching: false,
			ordering: false,
			language: {
				lengthMenu: " _MENU_ log per halaman"
			}
		});
	</script>

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
                    // ['link', 'image']
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

    <script>
	function showPreview(event){
	  if(event.target.files.length > 0){
	    var src = URL.createObjectURL(event.target.files[0]);
	    var preview = document.getElementById("file-ip-1-preview");
	    preview.src = src;
	    preview.style.display = "block";
	  }
	}
    </script>

    <!-- javascript -->
    <?php include("../../layout/javascript.php"); ?>
</body>
</html>