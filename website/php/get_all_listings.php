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
	$itemAmount = 2;

   //If the pageNumber is greater than 0 show previous link
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
	echo '<div class="center wrapper">';
   foreach($db->query("SELECT * FROM item LIMIT ".($_SESSION['pageNumber']*$itemAmount).", ".$itemAmount) as $row) {    
      echo '<div class="table-responsive" >';
      echo '<table class="table table-striped table-bordered table-hover table-restrict-size"">';
      echo '<thead>';
      echo '<tr><td><b>'.$row['name'].'<b></td></tr>';
      echo '</thead>';
      echo '<tbody>';
      echo '<tr><td>'.$row['description'].'<br>';
      echo '<a href="item.html?item='.$row['itemID'].'">Read more...</a></td></tr>';
      echo '</tbody>';
      echo '</table>';
      echo '</div><p>';
   }
   echo'</div>';

?>