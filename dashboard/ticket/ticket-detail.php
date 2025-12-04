<?php  
session_start();

require '../../config.php';
include '../../function/db-query.php';

if (!$_SESSION['user_login_status']) {
	header("location:".BASE_URL."/login.php?status=not_login");
}

if (!$_GET['id']) {
	header("location:ticket-page.php");
}

if (isset($_POST['comment_Submit'])) {
	echo ($_POST['comment_content']);
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tiket Pelaporan #</title>

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
													<label>User</label>
													<select class="form-control">
														<option value=""></option>
														<option value=""></option>
													</select>
												</div>

												<div class="form-group">
													<label>Status</label>
													<select class="form-control">
														<option value="0">Open</option>
														<option value="1">Closed</option>
													</select>
												</div>

												<div class="form-group">
													<label>Nama Barang</label>
													<input type="text" class="form-control" value="xxx"readonly="readonly">
												</div>

												<div class="form-group">
													<label>Permasalahan</label>
													<input type="text" class="form-control" value="xxx"readonly="readonly">
												</div>

												<div class="form-group">
													<label>Deskripsi</label>
													<textarea class="form-control" readonly="readonly"></textarea>
												</div>

												<div class="form-group">
													<label>Tanggal Efektif</label>
													<input type="text" class="form-control" value="xxx"readonly="readonly">
												</div>

												<button type="submit" name="create_item_Submit" class="btn btn-primary me-1 mb-1">Simpan</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12 col-lg-9">
							<div class="card">
								<div class="card-header">
									<h4>Tambah Komentar</h4>
								</div>

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

													<button type="submit" name="comment_Submit" class="btn btn-primary me-1 mb-1">Simpan</button>
												</form>
											</div>
										</div>
									</div>
								</div>

								<!-- loop comment di sini -->
								<div class="card-body">
									<div class="form-body">
										<div class="row">
											<div class="col">
												<!-- isi comment di sini -->
												<div class="divider divider-left">
						                            <div class="divider-text">USER commented on xx/xx/xxxx</div>
						                        </div>
						                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						                        <hr>
											</div>
										</div>
									</div>
								</div>

								<div class="card-body">
									<div class="form-body">
										<div class="row">
											<div class="col">
												<!-- isi comment di sini -->
												<div class="divider divider-left">
						                            <div class="divider-text">USER commented on xx/xx/xxxx</div>
						                        </div>
						                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						                        <hr>
											</div>
										</div>
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