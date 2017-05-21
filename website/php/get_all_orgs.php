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
	$orgAmount = 20;
	echo '<div class="center wrapper">';

		echo '<input type="text" id="searchValue" onkeyup="searchTables()" placeholder="Search..">';
		echo '<ul id="tableList">';

		//If the pageNumber is greater than 0 show previous link
		echo'<div class="listPages">';
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
	   	foreach($db->query("SELECT name, Information, groupID FROM organisation ORDER BY name LIMIT ".($_SESSION['pageNumber']*$orgAmount).", ".$orgAmount) as $row) {    
	      	echo '<li><div class="table-responsive table-padding" >';
	      	echo '<table class="table table-striped table-bordered table-hover table-restrict-size"">';
	      	echo '<thead>';
	      	echo '<tr><td><a href="organisation.html?id='.$row['groupID'].'"><b>'.$row['name'].'<b></a></td></tr>';
	      	echo '</thead>';
	      	echo '<tbody>';
	      	echo '<tr><td>';
	      	if (strlen($row['Information'])>200){
					echo substr($row['Information'],0,200).'...<br>';	
				}
				else{
					echo $row['Information'].'<br>';
				}
	      	echo '<a href="organisation.html?id='.$row['groupID'].'">Read more...</a></td></tr>';
	      	echo '</tbody>';
	      	echo '</table>';
	      	echo '</div></li>';
	   }
   echo'</div>';

?>