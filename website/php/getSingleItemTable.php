<?php
	include("config.php");
	session_start();

	$stmt = $db->prepare("SELECT * FROM item WHERE itemID=?");
	$stmt->execute(array($_GET['id']));
	if($stmt->rowCount() > 0) { 
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		echo '<div class="table-responsive table-padding" >';
   			echo '<button type="button" class="table-button" onclick="getItemDetails('.$row['itemID'].')" data-toggle="modal" data-target="#modal-item">';
	      	echo '<table class="table table-striped table-bordered table-hover">';
	      	
		      	echo '<tbody>';
		      		echo '<tr><td ';
	      			switch ($row['finished']) {
	            		case 0:
	                        echo 'class="available">';
	            			break;
	            		case 1:
	                        echo 'class="wanted">';
	            			break;
	            		default:
	                        echo 'class="finished">';
	            	}
					echo '<h3>'.$row['name'].'</h3>';
		      		echo '</td>';
					echo '<td rowspan="2" class="tableImage">';
				    	echo '<div><img src="php/getImage.php?id='.$row['itemID'].'" class="itemImage" /></div>';
		      		echo '</td></tr>';
		      		echo '<tr><td class="table-listings">';
		      			if (strlen($row['description'])>200){
		      				echo substr($row['description'],0,200).'...<br>';	
		      			}
		      			else{
		      				echo $row['description'].'<br>';
		      			}
		      			echo '<a>Read more...</a>';
		      		echo '</td></tr>';
		      	echo '</tbody>';
		      	
	      	echo '</table>';
	      	echo '</button>';
      	echo '</div>';
	} else {
		echo 'failed';
	}
?>