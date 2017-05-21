<?php
	include("config.php");
	
	session_start();
	//Get the page number. This is used to get items starting at = $_SESSION['pageNumber'] * $itemAmount
	if(empty($_GET['pageNumber']) || !isset($_SESSION['pageNumber'])){
		$_SESSION['pageNumber'] = 0;
	}
	else{
		$_SESSION['pageNumber'] = $_GET['pageNumber'];
	}

	//Number of items that will be fetched
	$itemAmount = 20;

   	//If the pageNumber is greater than 0 show previous link
	echo '<div class="center wrapper">';

		echo '<input type="text" id="searchValue" onkeyup="searchTables()" placeholder="Search..">';
		echo '<ul id="tableList">';
			
		echo'<div class="listPages">';
	   	if ($_SESSION['pageNumber'] > 0){
	   		echo '<a href="allListings.html?pageNumber='.($_SESSION['pageNumber']-1).'">Previous Page</a>';
	   	}

	   	//If there are more items then show next link
	   	$itemCount = $db->query("SELECT itemID FROM item");
		if($itemCount->rowCount() > (($_SESSION['pageNumber']+1)*$itemAmount)){
			if ($_SESSION['pageNumber'] > 0){
				echo ' - ';
			}
			echo '<a href="allListings.html?pageNumber='.($_SESSION['pageNumber']+1).'">Next Page</a>';
		}
		echo'</div>';

	   	//For each item create table using name, description and itemID
	   	foreach($db->query("SELECT * FROM item ORDER BY name LIMIT ".($_SESSION['pageNumber']*$itemAmount).", ".$itemAmount) as $row) {    
	   		echo '<li><div class="table-responsive table-padding" >';
		      	echo '<table class="table table-striped table-bordered table-hover table-restrict-size"">';
			      	echo '<tbody>';
			      		echo '<tr><td>';
			      			echo '<a href="item.html?item='.$row['itemID'].'"><b>'.$row['name'].'<b></a>';
			      		echo '</td>';
						echo '<td  rowspan="2" class="tableImage">';
					    	echo '<div><img src="php/getImage.php?id='.$row['itemID'].'" class="itemImage" /></div>';
			      		echo '</td></tr>';
			      		echo '<tr><td>';
			      			if (strlen($row['description'])>200){
			      				echo substr($row['description'],0,200).'...<br>';	
			      			}
			      			else{
			      				echo $row['description'].'<br>';
			      			}
			      			echo '<a href="item.html?item='.$row['itemID'].'">Read more...</a>';
			      		echo '</td></tr>';
			      	echo '</tbody>';
		      	echo '</table>';
	      	echo '</div></li>';
	   	}
	   	echo '</ul>';
   	echo'</div>';

?>