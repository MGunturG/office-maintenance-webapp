<?php
// this one hopefully to replace the vuln
// query that currently use

// function to replace
// 1. get_data
// 2. get_single_data
// 3. run_query

// Estab db connection
// db details
define('DB_SERVER', 'localhost');
define('DB_UNAME', 'root');
define('DB_PASSW', '');
define('DB_NAME', 'app');

try {
	$db_connection = new PDO(
		"mysql:host=".DB_SERVER.";dbname=".DB_NAME,
		username: DB_UNAME,
		password: DB_PASSW,
	);
	$db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	die("Connection failed: ".$e->getMessage());
}

function get_data($sql_query, $params = []) {
	global $db_connection;
	$statement = $db_connection->prepare($sql_query);
	$statement->execute($params);
	$results = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function get_single_data($sql_query, $params = []) {
	global $db_connection;
	$statement = $db_connection->prepare($sql_query);
	$statement->execute($params);
	$result = $statement->fetch(PDO::FETCH_ASSOC);
	return $result;
}

function operation_query($sql_query, $params = []) {
	global $db_connection;
	$statement = $db_connection->prepare($sql_query);
	$statement->execute($params);
}

// test for single data
$query_single_data = "SELECT user_master_uname FROM user_master WHERE user_master_id = :user_id";
$param_single_data = [
	"user_id" => 1,
];
// $result_single_data = get_single_data($query_single_data, $param_single_data);
// var_dump($result_single_data);
// print($result_single_data['user_master_uname']);


// test for many data
$query_many_data = "SELECT area_master_name FROM area_master WHERE area_master_floor = :area_floor";
$param_many_data = [
	"area_floor" => 1,
];
$result_many_data = get_data($query_many_data, $param_many_data);
// var_dump($result_many_data);
// foreach ($result_many_data as $data) {
// 	print($data['area_master_name'].' -- ');
// }


// test for query without param
$query_many_data_noparam = "SELECT * FROM area_master ORDER BY area_master_floor ASC";
$param_many_data_noparam = [];
$result_many_data_noparam = get_data($query_many_data_noparam, $param_many_data_noparam);
// var_dump($result_many_data_noparam);
// foreach ($result_many_data_noparam as $data) {
// 	print($data['area_master_name']." -- ");
// }


// test for insert, update/delete

?>