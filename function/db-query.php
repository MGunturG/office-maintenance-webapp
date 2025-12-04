<?php
function get_data($sql) {
	global $db_connection;

	$query_result = mysqli_query($db_connection, $sql);
	$rows_of_data = [];

	while ($data = mysqli_fetch_assoc($query_result)) {
		$rows_of_data[] = $data;
	}

	return $rows_of_data;
}

function run_query($sql) {
	global $db_connection;
	return mysqli_query($db_connection, $sql);
}

function get_single_data($sql) {
	global $db_connection;
	return(
		mysqli_fetch_assoc(
			mysqli_query(
				$db_connection, $sql
			)
		)
	);
}
?>