<?php
	include("config.php");
	
	session_start();
	//Get the page number. This is used to get items starting at = $_SESSION['pageNumber'] * $itemAmount
	if(empty($_GET['id'])){
		//header("Location: ../index.html");
	}

   //For each item create table using name, description and itemID
	echo '<div class="center wrapper">';

    	$stmt = $db->prepare("SELECT * FROM organisation WHERE groupID=?");
    	$stmt->execute(array($_GET['id']));
    	$organisationResult = $stmt->fetch(PDO::FETCH_ASSOC);  	

      if ($stmt->rowCount() == 1){
  		echo '<br><table class="table table-striped table-bordered table-hover table-restrict-size table-padding fullItemDesc">';
    	    echo '<thead>';
            //Item name
    	       echo '<tr><td colspan="2"><b>'.$organisationResult['name'].'<b></td></tr>';
    	    echo '</thead>';
    	    echo '<tbody>';;
                //Description
        	    echo '<tr><td><b>Description: </b>'.$organisationResult['Information'].'</td></tr>';
                //CurrentNews
                echo '<tr><td><b>Current News: </b>'.$organisationResult['currentNews'].'</td></tr>';
    	    echo '</tbody>';
	    echo '</table>';

      echo '<iframe class="maps-frame" src="https://www.google.com/maps/embed/v1/search?q='.str_replace(' ', '+', $organisationResult['address']).'+3350+Australia
          &zoom=16
          &key=AIzaSyDnIx1QkG-_64NuLSYxxQj4vkcdt9I5zV0">
        </iframe>
      ';
    }
    else{
      echo "<b>404 - Organisation not found</b>";
    }
   echo'</div>';

?>