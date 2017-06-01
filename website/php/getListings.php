<?php
	include("config.php");
	session_start();
	
   	//If the pageNumber is greater than 0 show previous link
	echo '<div class="center wrapper">';

		echo '<input type="text" id="searchValue" onkeyup="searchTables()" placeholder="Search for listing..">';
		echo '<ul id="tableList">';
			
		if (empty($_GET['type'])){
      		$stmt = $db->query('SELECT * FROM item');
	   	}
	   	else{
	   		$stmt = $db->prepare("SELECT * FROM item WHERE category=?");
	   		$stmt->execute(array($_GET['type']));
	   	}

	   	//For each item create table using name, description and itemID
	   	if($stmt->rowCount() > 0) { 
	   		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		   		echo '<li id="itemTableID'.$row['itemID'].'"><div class="table-responsive table-padding" >';
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
		      	echo '</div></li>';
		   	}
	   	}
	   	else{
	   		echo "<span class='center'>There are no listings</span>";
	   	}
	   	echo '</ul>';

	   	echo '<!-- Item Modal -->
	   		<div class="modal fade" id="modal-item" aria-hidden="false">
	   			<div id="itemDetails"></div>
	   		<div>';
   	echo'</div>';

?>