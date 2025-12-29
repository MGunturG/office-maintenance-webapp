<?php
require 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- edit page title -->
    <title>Login</title>

    <!-- styling -->
    <?php include("layout/styling.php"); ?>
    <link rel="stylesheet" crossorigin href="assets/compiled/css/auth.css">
</head>
<body>
	<?php include("layout/body-theme.php"); ?>

	<div id="auth">
		<div class="row h-100">
	        <div class="col-lg-5 col-12">
	            <div id="auth-left">
	                <div class="auth-logo">
	                    <a href="index.php"><img src="<?= BASE_URL.'/assets/icons/logo.png' ?>" alt="Logo"></a>
	                </div>
	                <h1 class="auth-title">Log in</h1>
	                <!-- <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p> -->
	                <?php if (isset($_GET['status'])): ?>
		                <?php if ($_GET['status'] == "not_login"): ?>
							<div class="alert alert-light-warning color-warning"><i class="bi bi-exclamation-triangle"></i>
	                            Kamu belum login, coba login dulu ya.</div>
						<?php elseif ($_GET['status'] == "fail"): ?>
							<div class="alert alert-light-danger color-danger"><i class="bi bi-exclamation-circle"></i>
	                            Username atau password kamu salah, coba lagi ya.</div>
						<?php endif ?>
					<?php endif ?>
					
	                <form method="POST" action="function/login-function.php" autocomplete="off">
	                    <div class="form-group position-relative has-icon-left mb-4">
	                        <input type="text" name="username" class="form-control form-control-xl" placeholder="Username">
	                        <div class="form-control-icon">
	                            <i class="bi bi-person"></i>
	                        </div>
	                    </div>
	                    <div class="form-group position-relative has-icon-left mb-4">
	                        <input type="password" name="password" class="form-control form-control-xl" placeholder="Password">
	                        <div class="form-control-icon">
	                            <i class="bi bi-shield-lock"></i>
	                        </div>
	                    </div>
	                    <!-- <div class="form-check form-check-lg d-flex align-items-end"> -->
	                        <!-- <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault"> -->
	                        <!-- <label class="form-check-label text-gray-600" for="flexCheckDefault"> -->
	                            <!-- Keep me logged in -->
	                        <!-- </label> -->
	                    <!-- </div> -->
	                    <button type="submit" value="login" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
	                </form>
	                <div class="text-center mt-5 text-lg fs-4">
	                    <!-- <p class="text-gray-600">Don't have an account? <a href="auth-register.html" class="font-bold">Signup</a>.</p> -->
	                    <!-- <p><a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.</p> -->
	                </div>
	            </div>
	        </div>
	        <div class="col-lg-7 d-none d-lg-block">
	            <div id="auth-right">
	            </div>
	        </div>
	    </div>
	</div>
</body>
</html>