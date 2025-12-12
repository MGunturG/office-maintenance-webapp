TODO

1. dashboard tampilin tiket yang : open, in progress, on hold, resolved, dan closed ada berapa
2. add function untuk upload gambar di tiket dan detail barang

buat upload gambar, tetep pake si file upload-function.php

jadi formnya itu:
<form method="post" action="...upload-function" enctype="multipart/form-data">
	<input type="hidden" name="id" value="some_value">
	<input type="hidden" name="action" value="insert_item_picture">
	...
</form>

nanti di upload-function.php nya itu, ada selector actionnya itu apa
misal:
<?php
	...
	...
	if ($_POST['action'] == "insert_item_picture") {
		... kode di siniii
	}

	atau pake switch case:
	...
	...
	$type = $_POST['action'];
	switch ($type) {
		case 'insert_item_picture':
			...
			kode di siniiii
			...
			break;

		case 'insert_another_case':
			...
			kode di sinii
			...
			break;

		default:
			die("message here")
	}
?>