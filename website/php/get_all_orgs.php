<?php
	include("config.php");
	
	session_start();
	//Get the page number. This is used to get organisations starting at = $_SESSION['pageNumber'] * $itemAmount
	if(empty($_GET['pageNumber']) || !isset($_SESSION['pageNumber'])){
		$_SESSION['pageNumber'] = 0;
	}
	else{
		$_SESSION['pageNumber'] = $_GET['pageNumber'];
	}

	//Number of organisations that will be fetched
	$orgAmount = 6;

   //If the pageNumber is greater than 0 show previous link
	echo'<div class="orgsPages">';
   if ($_SESSION['pageNumber'] > 0){
   	echo '<a href="allOrgs.html?pageNumber='.($_SESSION['pageNumber']-1).'">Previous Page</a>';
   }

   //If there are more organisations then show next link
   $orgCount = $db->query("SELECT groupID FROM organisation");
	if($orgCount->rowCount() > (($_SESSION['pageNumber']+1)*$orgAmount)){
		if ($_SESSION['pageNumber'] > 0){
			echo ' - ';
		}
		echo '<a href="allOrgs.html?pageNumber='.($_SESSION['pageNumber']+1).'">Next Page</a>';
	}
	echo'</div>';

   //For each organisation create table using name, description and itemID
	echo '<div class="center wrapper">';
   foreach($db->query("SELECT name, Information FROM organisation LIMIT ".($_SESSION['pageNumber']*$orgAmount).", ".$orgAmount) as $row) {    
      echo '<div class="table-responsive" >';
      echo '<table class="table table-striped table-bordered table-hover table-restrict-size"">';
      echo '<thead>';
      echo '<tr><td><b>'.$row['name'].'<b></td></tr>';
      echo '</thead>';
      echo '<tbody>';
      echo '<tr><td>'.$row['Information'].'<br>';
      //echo '<a href="item.html?item='.$row['groupID'].'">Read more...</a></td></tr>';
      echo '</tbody>';
      echo '</table>';
      echo '</div><p>';
   }
   echo'</div>';

?>