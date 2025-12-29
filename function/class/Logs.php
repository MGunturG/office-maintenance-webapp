<?php

class Logs {
	function LogCreate($entity_type, $entity_id, $action, $by_user) {
		run_query(
			"INSERT INTO activity_log (activity_log_entity_type, activity_log_entity_id, activity_log_action, activity_log_user) VALUES ('$entity_type', '$entity_id', '$action', '$by_user')"
		);
	}

	function LogFetch(string $entity_type, $entity_id) {
		get_data(
			"SELECT * FROM activity_log WHERE activity_log_entity_type = '$entity_type' AND activity_log_entity_id = '$entity_id' ORDER BY ".
			"activity_log_timestamp DESC"
		);
	}
	
}
?>