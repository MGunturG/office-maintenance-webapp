<?php

/**
 * Executes a SQL query and returns all resulting rows as an associative array.
 *
 * @param string $sql The SQL query string to execute.
 * @return array An array containing all fetched rows.
 */
function get_data($sql) {
	global $db_connection;

	$query_result = mysqli_query($db_connection, $sql);
	$rows_of_data = [];

	while ($data = mysqli_fetch_assoc($query_result)) {
		$rows_of_data[] = $data;
	}

	return $rows_of_data;
}

/**
 * Executes a SQL query against the database.
 *
 * @param string $sql The SQL query string to execute.
 * @return mysqli_result|bool The result object or true/false on success/failure.
 */
function run_query($sql) {
	global $db_connection;
	return mysqli_query($db_connection, $sql);
}

/**
 * Executes a SQL query and returns the first row of data.
 *
 * @param string $sql The SQL query string to execute.
 * @return array<string, mixed>|null The associative array representing the row, or null if no results.
 */
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