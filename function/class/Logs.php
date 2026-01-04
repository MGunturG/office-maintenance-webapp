<?php
/**
 * Audit Log Controller
 * * Provides an immutable record of system activities, allowing for 
 * historical tracking of entity changes and user accountability.
 */

class Logs {

	/**
     * Create a new activity log entry.
     * * @param string $entity_type The module/table name (e.g., 'Item', 'Ticket').
     * @param int    $entity_id   The primary key of the affected record.
     * @param string $action      Description of the change or event.
     * @param string $by_user     Username of the person performing the action.
     * @return void
     */
	function LogCreate($entity_type, $entity_id, $action, $by_user) {
		run_query(
			"INSERT INTO activity_log (activity_log_entity_type, activity_log_entity_id, activity_log_action, activity_log_user) VALUES ('$entity_type', '$entity_id', '$action', '$by_user')"
		);
	}


	/**
     * Retrieve chronological history for a specific entity.
     * Results are ordered by the most recent timestamp first.
     * * @param string $entity_type The module/table name to filter by.
     * @param int    $entity_id   The specific ID to track.
     * @return array Collection of activity logs.
     */
	function LogFetch($entity_type, $entity_id) {
		return get_data(
			"SELECT * FROM activity_log WHERE activity_log_entity_type = '$entity_type' AND activity_log_entity_id = '$entity_id' ORDER BY ".
			"activity_log_timestamp DESC"
		);
	}
	
}
?>