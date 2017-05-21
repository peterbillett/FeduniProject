<?php
   	include("config.php");

   	echo "<select name='tagID'>";
	foreach($db->query('SELECT * FROM tag') as $row) {
	    echo '<option   value="'.$row['tagID'].'">'.$row['name'].'</option>';
	}
	echo "</select>";
?>