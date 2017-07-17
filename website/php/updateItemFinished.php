<?php
	$stmt = $db->exec("UPDATE item SET finished = 2 WHERE endtime < now() AND finished < 2");
?>