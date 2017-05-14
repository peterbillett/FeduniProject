<?php
   	include("config.php");

   	echo'<div class="row"><div class="col-sm-6">';
	foreach($db->query('SELECT * FROM item') as $row) {
	    echo '<div class="table-responsive" >';
	    echo '<table class="table table-striped table-hover"">';
	    echo '<tr><td>'.$row['name'].'<td></tr>';
	    echo '<tr><td>'.$row['itemID'].'<td></tr>';
	    echo '<tr><td>'.$row['description'].'<br>';
	    echo '<a href="itemPage.html?'.$row['itemID'].'">Read more...</a></tr></td>';
	    echo '</table></div><p>';
	}
	echo'</div></div>';
?>