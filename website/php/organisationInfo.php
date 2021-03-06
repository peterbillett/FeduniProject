<?php
	include("config.php");
	session_start();

	//Get the page number. This is used to get items starting at = $_SESSION['pageNumber'] * $itemAmount
	if(!empty($_GET['id'])){
    echo '<div class="center wrapper">';
      //Select the organisations details
    	$stmt = $db->prepare("SELECT * FROM organisation WHERE groupID=?");
    	$stmt->execute(array($_GET['id']));
    	$organisationResult = $stmt->fetch(PDO::FETCH_ASSOC);  	

      if ($stmt->rowCount() == 1) {
  		echo '<br><table class="table table-striped table-bordered table-hover table-restrict-size table-padding fullItemDesc">';
        echo '<thead>';
          //Organisation name
          echo '<tr><td colspan="2"><b>'.$organisationResult['name'].'<b></td></tr>';
        echo '</thead>';
    	  echo '<tbody>';;
          //Description
          echo '<tr><td><b>Description: </b>'.$organisationResult['Information'].'</td></tr>';
          //CurrentNews
          echo '<tr><td><b>Current News: </b>'.$organisationResult['currentNews'].'</td></tr>';
    	  echo '</tbody>';
	    echo '</table>';

      //Show the organisation on a map
      echo '<iframe class="maps-frame" src="https://www.google.com/maps/embed/v1/search?q='.str_replace(' ', '+', $organisationResult['address']).'+3350+Australia
        &zoom=16
        &key=AIzaSyDnIx1QkG-_64NuLSYxxQj4vkcdt9I5zV0">
      </iframe>';
    }
    else { //if nothing is returned then report error
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
        <p>404 - Organisation not found</p>
      </div>';
    }
   echo'</div>';
  }
?>