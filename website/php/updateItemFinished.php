<?php
	//Update items that have gone past their endtime to the finished status
	$stmt = $db->exec("UPDATE item SET finished = 2 WHERE endtime < now() AND finished < 2");
?>