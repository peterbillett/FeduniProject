<?php
	include("config.php");
	
	session_start();
	//Get the page number. This is used to get items starting at = $_SESSION['pageNumber'] * $itemAmount
	if(empty($_GET['item'])){
		header("Location: ../get_all_listings.html");
	}

   //For each item create table using name, description and itemID
	echo '<div class="center wrapper">';

		$stmt = $db->prepare("SELECT * FROM item JOIN client ON client.clientID = item.FKclient WHERE itemID=?");
    	$stmt->execute(array($_GET['item']));
    	$itemResult = $stmt->fetch(PDO::FETCH_ASSOC);

    	$stmt = $db->prepare("SELECT * FROM organisation WHERE groupID=?");
    	$stmt->execute(array($itemResult['organisation']));
    	$organisationResult = $stmt->fetch(PDO::FETCH_ASSOC);  	
  		
        echo'<div class="listPages">';
           if (isset($_SESSION['pageNumber'])){
                echo '<a href="allListings.html?pageNumber='.($_SESSION['pageNumber']).'">Back to listings</a>';
           }
           else{
                echo '<a href="allListings.html">Back to listings</a>';
           }
        echo'</div>';

  		//Item name
  		echo '<table class="table table-striped table-bordered table-hover table-restrict-size table-padding fullItemDesc">';
    	    echo '<thead>';
    	       echo '<tr><td colspan="2"><b>'.$itemResult['name'].'<b></td></tr>';
    	    echo '</thead>';

    	    //item Image
    	    echo '<tbody>';
          		echo '<tr><td class="tableImage">';
            	    echo '<div><img src="php/getImage.php?id='.$_GET['item'].'" class="itemImage" /></div>';
            	echo '</td>';

            	//Item details: client, organisation+url, end date/time
            	echo '<td>';
            	    echo 'Supplier: '.$itemResult['clientFirstName'].' '.$itemResult['clientLastName'];
            	    echo '<br>Organisation: <a href="organisation.html?id='.$organisationResult['groupID'].'"">'.$organisationResult['name'].'</a>';
            	    echo '<br>End date/time: '.$itemResult['endtime'];
            	    echo '<br>Contact email: <a href="mailto:'.$itemResult['email'].'?Subject='.$itemResult['name'].'">'.$itemResult['email'].'</a>';

                    //Depending on if the user is logged in (and if so if the group they are in belongs to the item) show buttons
                    echo '<br>';
                    if(isset($_SESSION['userID'])){
                        if ($_SESSION['userID'] == $itemResult['FKclient']){
                            //echo '<a href="../editItem.html?id='.$_GET['item'].'" class="btn btn-primary">Edit</a> ';
                            echo '<a href="#" class="btn btn-primary">Edit</a> ';
                            if ($itemResult['finished'] < 2){
                                echo '<a href="./php/changeItemStatus.php?id='.$_GET['item'].'&status=2" class="btn btn-success">Set as completed</a> ';
                            }
                            if ($itemResult['finished'] != 1){
                                echo '<a href="./php/changeItemStatus.php?id='.$_GET['item'].'&status=1" class="btn btn-warning">Set as accepted</a> ';
                            }
                            if ($itemResult['finished'] != 0){
                                echo '<a href="./php/changeItemStatus.php?id='.$_GET['item'].'&status=0" class="btn btn-danger">Reset to available</a>';
                            }                            
                        }
                        else{
                            if ($itemResult['finished'] == 0){
                                echo '<a href="./php/changeItemStatus.php?id='.$_GET['item'].'&status=1" class="btn btn-warning">Set you want it</a>';
                            }
                            elseif ($itemResult['finished'] == 1){
                                echo '<a href="./php/changeItemStatus.php?id='.$_GET['item'].'&status=0" class="btn btn-danger">Reset to available</a>';
                            }
                        }
                    }
            	echo '</td></tr>';
            	
                //Depending on the item status set class for colouring and text shown
            	switch ($itemResult['finished']) {
            		case 0:
                        echo '<tr><td colspan="2" class="itemStatus available">';
            			echo '<span>Available<span>';
            			break;
            		case 1:
                        echo '<tr><td colspan="2" class="itemStatus wanted">';
            			echo '<span>Marked as wanted<span>';
            			break;
            		default:
                        echo '<tr><td colspan="2" class="itemStatus finished">';
            			echo '<span>Finished<span>';
            	}
            	echo '</td></tr>';

            	//Item description
        	    echo '<tr><td colspan="2"><b>Description: </b>'.$itemResult['description'].'</td></tr>';
    	    echo '</tbody>';
	    echo '</table>';
   echo'</div>';

?>