<?php
	// Connects to the database
	include("config.php");

	echo "<select name='groupID'>";
		foreach($db -> query ('SELECT name, groupID FROM organisation') as $row)
		{
			echo '<option value="'.$row['groupID'].'">'.$row['name'].'</option>';
		}
	echo '</select>';
?>
