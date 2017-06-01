<?php
	include("config.php");
	session_start();

    $stmt = $db->prepare("SELECT client.clientFirstName, client.clientLastName, client.email, client.FKgroup, item.* FROM client, item WHERE client.clientID = item.FKclient AND item.itemID = ?");
    $stmt->execute(array($_GET['id']));
    $itemResult = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT organisation.groupID, organisation.name FROM organisation WHERE groupID=?");
    $stmt->execute(array($itemResult['FKgroup']));
    $organisationResult = $stmt->fetch(PDO::FETCH_ASSOC);

   //For each item create table using name, description and itemID
	echo '
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="center wrapper">';
                    
              		//Item details
                    echo '<div id="itemInfo" style="display: block;">';

                        //Item heading
                        echo '<div class="modal-header background-color-blue">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><h4>&times;</h4></button>
                                <h4 class="myModalLabel">'.$itemResult['name'].'</h4>
                            </div>';

                        echo '<div class="modal-body">';
                      		echo '<table class="table fullItemDesc">';

                        	    //item Image
                        	    echo '<tbody>';
                              		echo '<tr><td class="tableImage">';
                                	    echo '<div><img src="php/getImage.php?id='.$_GET['id'].'" class="itemImage" /></div>';
                                	echo '</td>';

                                	//Item details: client, organisation+url, end date/time
                                	echo '<td>';
                                	    echo 'Supplier: '.$itemResult['clientFirstName'].' '.$itemResult['clientLastName'];
                                	    echo '<br>Organisation: <a href="organisation.html?id='.$organisationResult['groupID'].'">'.$organisationResult['name'].'</a>';
                                	    echo '<br>End date/time: '.$itemResult['endtime'];
                                	    echo '<br>Contact email: <a href="mailto:'.$itemResult['email'].'?Subject='.$itemResult['name'].'">'.$itemResult['email'].'</a>';

                                        //Depending on if the user is logged in (and if so if the group they are in belongs to the item) show buttons
                                        echo '<br>';
                                        if(isset($_SESSION['userID'])){
                                            if ($_SESSION['userID'] == $itemResult['FKclient']){
                                                echo '<button class="btn btn-primary" onclick="changeHiddenState()">Edit</button>';

                                                if ($itemResult['finished'] != 2){
                                                    echo '<button class="btn btn-danger" onclick="changeStatus('.$_GET['id'].',2)">Set as completed</button>';
                                                }

                                                if ($itemResult['finished'] != 1){
                                                    echo '<button class="btn btn-warning" onclick="changeStatus('.$_GET['id'].',1)">Set as accepted</button>';
                                                }

                                                if ($itemResult['finished'] != 0){
                                                    echo '<button class="btn btn-success" onclick="changeStatus('.$_GET['id'].',3)">Set as available</button>';
                                                }

                                            }
                                            else{
                                                if ($itemResult['finished'] == 0){
                                                    echo '<button class="btn btn-warning" onclick="changeStatus('.$_GET['id'].',1)">Set you want it</button>';
                                                    //echo '<a href="./php/changeItemStatus.php?id='.$_GET['id'].'&status=1" class="btn btn-warning">Set you want it</a>';
                                                }
                                                elseif ($itemResult['finished'] == 1){
                                                    echo '<button class="btn btn-danger" onclick="changeStatus('.$_GET['id'].',3)">Reset to available</button>';
                                                    //echo '<a href="./php/changeItemStatus.php?id='.$_GET['id'].'&status=0" class="btn btn-danger">Reset to available</a>';
                                                }
                                            }
                                        }
                                	echo '</td></tr>';
                                	
                                    //Depending on the item status set class for colouring and text shown
                                	switch ($itemResult['finished']) {
                                		case 0:
                                            echo '<tr id="currentItemStatus"><td colspan="2" class="itemStatus available">';
                                			echo '<span>Available<span></td></tr>';
                                			break;
                                		case 1:
                                            echo '<tr id="currentItemStatus"><td colspan="2" class="itemStatus wanted">';
                                			echo '<span>Marked as wanted<span></td></tr>';
                                			break;
                                		default:
                                            echo '<tr id="currentItemStatus"><td colspan="2" class="itemStatus finished">';
                                			echo '<span>Finished<span></td></tr>';
                                	}

                                	//Item description
                            	    echo '<tr><td colspan="2"><b>Description: </b>'.$itemResult['description'].'</td></tr>';
                        	    echo '</tbody>';
                    	    echo '</table>';
                            echo '<div class="testing" id="itemInfoMessage"></div>';
                        echo'</div>'; 
                    echo'</div>';    

                    echo '<div id="itemEditing" style="display: none;">';
                        echo '<div class="modal-header background-color-blue">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><h4>&times;</h4></button>
                            <h4 class="myModalLabel">Editing: '.$itemResult['name'].'</h4>
                        </div>
                        <div class="modal-body testing">

                            <label>Title </label>
                                <input type="text" id="newTitle" required value="'.$itemResult['name'].'" placeholder="Lisiting name...">
                            <br/>
                            <br>
                                <label>Description </label>
                                <input type="text" id="newDescription" required value="'.$itemResult['description'].'" placeholder="Enter description...">
                            <br/>
                            <br>
                                <label>Type </label>
                                <select id="newCategory">';
                                if ($itemResult['category'] == "Request"){
                                    echo '<option selected="selected" value="Request">Request</option>
                                        <option value="Supplying">Supplying</option>';
                                } else{
                                    echo '<option value="Request">Request</option>
                                        <option selected="selected" value="Supplying">Supplying</option>';
                                }
                                echo '
                                </select>
                            </br>
                            </br>
                            <button class="btn btn-primary" onclick="editListing('.$_GET['id'].',)">Submit changes</button>

                        </div>
                        <div class="modal-footer testing">
                            <button onclick="removeListing('.$_GET['id'].')" class="btn btn-danger">Remove listing</button>
                            <button class="btn btn-default" onclick="changeHiddenState()">Cancel editing</button>
                        </div>';
                        echo '<div class="testing" id="itemEditMessage"></div>';
                    echo'</div>';

                echo'</div>
            </div>
        </div>
    </div>';

                

?>