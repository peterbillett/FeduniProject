<?php
	include("config.php");
	
	session_start();
	//Get the page number. This is used to get items starting at = $_SESSION['pageNumber'] * $itemAmount
	if(empty($_GET['item'])){
		
	}

   //For each item create table using name, description and itemID
	echo '<div class="center wrapper">';

		$stmt = $db->prepare("SELECT * FROM item JOIN client ON client.clientID = item.FKclient WHERE itemID=?");
    	$stmt->execute(array($_GET['item']));
    	$itemResult = $stmt->fetch(PDO::FETCH_ASSOC);

    	$stmt = $db->prepare("SELECT * FROM organisation WHERE groupID=?");
    	$stmt->execute(array($itemResult['organisation']));
    	$organisationResult = $stmt->fetch(PDO::FETCH_ASSOC);  	
  		
  		//Item name
  		echo '<table class="table table-striped table-bordered table-hover table-restrict-size"">';
  		echo '<div class="table">';
	    echo '<thead>';
	    echo '<tr><td colspan="2"><b>'.$itemResult['name'].'<b></td></tr>';
	    echo '</thead>';

	    //item Image
	    echo '<tbody>';
  		echo '<tr><td>';
    	echo '<div><img src="getImage.php?id='.$_GET['item'].'" class="itemImage" /></div>';
    	echo '</td>';

    	//Item details: client, organisation+url, end date/time
    	echo '<td>';
    	echo 'Supplier: '.$itemResult['clientFirstName'].' '.$itemResult['clientLastName'];
    	echo '<br>Organisation: <a href="organisation.html?id='.$organisationResult['groupID'].'"">'.$organisationResult['name'].'</a>';
    	echo '<br>End date/time: '.$itemResult['endtime'];
    	echo '<br>Contact email: <a href="mailto:'.$itemResult['email'].'?Subject='.$itemResult['name'].'">'.$itemResult['email'].'</a>';
    	echo '</td></tr>';

    	//Depending on the item status set class for colouring and text shown
    	echo '<tr><td colspan="2">';
    	switch ($itemResult['finished']) {
    		case 0:
    			echo '<span class="Available">Available<span>';
    			break;
    		case 1:
    			echo '<span class="wanted">Marked as wanted<span>';
    			break;
    		default:
    			echo '<span class="finished">Finished<span>';
    	}
    	echo '</td></tr>';

    	//Item description
	    echo '<tr><td colspan="2"><b>Description: </b>'.$itemResult['description'].'</td></tr>';
	    echo '</tbody>';
	    echo '</div><p>';
	    echo '</table>';
   echo'</div>';

?>