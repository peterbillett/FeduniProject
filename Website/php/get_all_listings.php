<?php
   	include("config.php");

   	echo'<div class="row"><div class="col-sm-6">';
	foreach($db->query('SELECT * FROM item') as $row) {

	    echo '<div class="table-responsive"><table class="table table-striped table-hover" value="'.$row['itemID'].'"><tr><td>'.$row['name'].'<td></tr><tr><td>'.$row['description'].'<br>Read more...</tr></td></table></div><p>';
	}
	echo'</div></div>';
?>