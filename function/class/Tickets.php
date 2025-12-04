<?php

class Tickets {
	function TicketCreate($topic, $description, $item_id, $effective_date) {
		$create_by = $_SESSION['user_uname'];
		$create_time = date('Y-m-d H:i:s');

		/* status category
		 * 0 = open
		 * 1 = closed
		 */

		$status = 0; // 0 mean open, check code_master on database

		run_query(
			"INSERT INTO ticket_master (".
				"ticket_master_topic, ".
				"ticket_master_description, ".
				"ticket_master_item_id, ".
				"ticket_master_effdate, ".
				"ticket_master_status, ".
				"ticket_master_currentholder, ".
				"ticket_master_createby, ".
				"ticket_master_createtime ".
			") VALUES ('$topic', '$description', '$item_id', '$effective_date', '$status', '$create_by', '$create_by', '$create_time')"
		);

		// sweetalert
		$_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
		$_SESSION['alert_title'] = "Mantap!";
		$_SESSION['alert_text'] = "Tiket berhasil dibuat";
		$_SESSION['alert_icon'] = "success"; // success, question, error, warning, info
		$_SESSION['alert_button_text'] = "OK";
	}


	function TicketGetAll() {
		return get_data(
			"SELECT * FROM ticket_master"
		);
	}
}

 ?>