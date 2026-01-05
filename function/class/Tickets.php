<?php
/**
 * Maintenance Ticket Controller
 * * Manages the full lifecycle of maintenance tickets, including creation, 
 * status updates, and the associated comment/interaction thread.
 */

class Tickets {

	/**
     * Create a new maintenance ticket and initialize an 'Open' status.
     * @param string $topic          Brief title of the issue.
     * @param string $description    Detailed problem report.
     * @param int    $item_id        ID of the asset needing repair.
     * @param string $effective_date The reporting date.
     * @param string $pic           Assigned Person-in-Charge username.
     * @return void
     */
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


	/**
     * Fetch master details for a single ticket.
     * @param int $ticket_id Primary key of the ticket.
     * @return array|null Record from ticket_master.
     */
	function TicketDetail($ticket_id) {
		return get_single_data(
			"SELECT * FROM ticket_master WHERE ticket_master_id = '$ticket_id'"
		);
	}


	/**
     * Transition a ticket to a new status (Open, Progress, Closed, etc.).
     * @param int    $ticket_id   Primary key of the ticket.
     * @param string $status_code Code corresponding to code_master table.
     * @return bool Execution result.
     */
	function TicketUpdateStatus($ticket_id, $status_code) {
		return run_query(
			"UPDATE ticket_master SET ticket_master_status = '$status_code' WHERE ticket_master_id = '$ticket_id'"
		);
	}


	/**
     * Add a rich-text or plain-text comment to a ticket thread.
     * @param int    $ticket_id       Target ticket ID.
     * @param string $comment_content The message or HTML content.
     * @param string $comment_by      Username of the commenter.
     * @return void
     */
	function TicketAddComment($ticket_id, $comment_content, $comment_by) {
		run_query(
			"INSERT INTO ticket_detail (ticket_detail_master_id, ticket_detail_comment, ticket_detail_commentby) ".
			"VALUES ('$ticket_id', '$comment_content', '$comment_by')"
		);
	}


	/**
     * Retrieve the comment history for a specific ticket.
     * @param int $ticket_id Target ticket ID.
     * @return array Collection of comments ordered by most recent first.
     */
	function TicketGetComment($ticket_id) {
		return get_data(
			"SELECT ticket_detail_id, ticket_detail_comment, ticket_detail_commentby, ticket_detail_commenttime FROM ticket_detail WHERE ticket_detail_master_id = '$ticket_id' ORDER BY ticket_detail_commenttime DESC"
		);
	}


	/**
     * Fetch all maintenance tickets in the system.
     * @return array Collection of all ticket_master records.
     */
	function TicketGetAll() {
		return get_data(
			"SELECT * FROM ticket_master"
		);
	}
}

 ?>