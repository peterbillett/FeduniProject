<?php
   	include("config.php");

   	echo "<select id='tagID'>";
	foreach($db->query('SELECT * FROM tag') as $row) {
	    echo '<option   value="'.$row['tagID'].'">'.$row['name'].'</option>';
	}
	echo "</select>";
?>