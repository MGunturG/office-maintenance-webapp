<?php

class Tickets {
	function TicketCreate($topic, $description, $item_id, $effective_date, $pic) {
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
			") VALUES ('$topic', '$description', '$item_id', '$effective_date', '$status', '$pic', '$create_by', '$create_time')"
		);

		// sweetalert
		$_SESSION['alert_value'] = "show"; // put any value, if null, alert not showing
		$_SESSION['alert_title'] = "Mantap!";
		$_SESSION['alert_text'] = "Tiket berhasil dibuat";
		$_SESSION['alert_icon'] = "success"; // success, question, error, warning, info
		$_SESSION['alert_button_text'] = "OK";
	}


	function TicketDetail($ticket_id) {
		return get_single_data(
			"SELECT * FROM ticket_master WHERE ticket_master_id = '$ticket_id'"
		);
	}


	function TicketAddComment($ticket_id, $comment_content, $comment_by) {
		run_query(
			"INSERT INTO ticket_detail (ticket_detail_master_id, ticket_detail_comment, ticket_detail_commentby) ".
			"VALUES ('$ticket_id', '$comment_content', '$comment_by')"
		);
	}


	function TicketGetComment($ticket_id) {
		return get_data(
			"SELECT ticket_detail_comment, ticket_detail_commentby, ticket_detail_commenttime FROM ticket_detail WHERE ticket_detail_master_id = '$ticket_id' ORDER BY ticket_detail_commenttime DESC"
		);
	}


	function TicketGetAll() {
		return get_data(
			"SELECT * FROM ticket_master"
		);
	}
}

 ?>