<script src="<?php echo BASE_URL; ?>/assets/static/js/components/dark.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/compiled/js/app.js"></script>

<!-- Jquery -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<!-- datatables -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>

<!-- simple datatables -->
<!-- <script src="<?php echo BASE_URL; ?>/assets/static/js/pages/simple-datatables.js"></script> -->

<!-- for select2 -->
<!-- <script src="<?php echo BASE_URL; ?>/assets/compiled/js/select2.min.js"></script> -->

<!-- for choice -->
<script src="<?php echo BASE_URL; ?>/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/static/js/pages/form-element-select.js"></script> 

<!-- sweetalert -->
<script src="<?php echo BASE_URL; ?>/assets/extensions/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/static/js/pages/sweetalert2.js"></script>

<!-- Sweetalert pakai session -->
<?php if (!is_null($sweetalert_value)): ?>
	<script>
		Swal2.fire({
			title : '<?= $sweetalert_title ?>',
			text : '<?= $sweetalert_text ?>',
			icon : '<?= $sweetalert_icon ?>',
			confirmButtonText : '<?= $sweetalert_button_text ?>',
		});
	</script>
<?php endif ?>

<!-- toast alert pakai session -->
<?php if (!is_null($toastalert_value)): ?>
	<script>
		Toast.fire({
			title : '<?= $toastalert_title ?>',
			icon : '<?= $toastalert_icon ?>',
		});
	</script>
<?php endif ?>