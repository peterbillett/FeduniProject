<?php
	include("config.php");
	session_start();

    $stmtItem = $db->prepare("SELECT client.clientFirstName, client.clientLastName, client.email, item.* FROM client, item WHERE client.clientID = item.FKclient AND item.itemID = ?");
    $stmtItem->execute(array($_GET['id']));
    $itemResult = $stmtItem->fetch(PDO::FETCH_ASSOC);

    $stmtOrg = $db->prepare("SELECT organisation.groupID, organisation.name FROM organisation WHERE groupID=?");
    $stmtOrg->execute(array($itemResult['organisation']));
    $organisationResult = $stmtOrg->fetch(PDO::FETCH_ASSOC);

   //For each item create table using name, description and itemID
	echo '<div class="modal-dialog">
    <div class="modal-content">';
                
    //Item details
    echo '<div id="itemInfo" style="display: block;">';

    //Item heading
    if ($stmtItem->rowCount() == 1) {
        echo '<div class="modal-header background-color-blue">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><modalTitle>&times;</modalTitle></button>
        <modalTitle class="myModalLabel">'.$itemResult['name'].'</modalTitle>
        </div>';

        echo '<div class="modal-body">';
            
        echo '<table class="table fullItemDesc">';

        //item Image
        echo '<tbody>';
        echo '<tr><td class="tableImage">';
        echo '<div><img src="php/imageGet.php?id='.$_GET['id'].'" class="itemImage" /></div>';
        echo '</td>';

        //Item details: client, organisation+url, end date/time
        echo '<td>';
        echo 'Supplier: '.$itemResult['clientFirstName'].' '.$itemResult['clientLastName'];
        if ($stmtOrg->rowCount() == 1) {
            echo '<br>Organisation: <a><button type="button" class="table-button inlineBlock" onclick="getOrganisationModal('.$organisationResult['groupID'].')">'.$organisationResult['name'].'</button></a>';
        } else {
            echo '<br>Organisation: [NONE]';
        }
        echo '<br>End date/time: '.$itemResult['endtime'];
        echo '<br><a href="mailto:'.$itemResult['email'].'?Subject='.$itemResult['name'].'">Send email</a>';

        //Depending on if the user is logged in (and if so if the group they are in belongs to the item) show buttons
        echo '<br>';
        if(isset($_SESSION['userID'])) {
            if ($_SESSION['userID'] == $itemResult['FKclient']) {
                echo '<button type="button" class="btn btn-primary" onclick="changeHiddenState()">Edit</button>';
                if ($itemResult['finished'] != 2) {
                    echo '<button class="btn btn-danger" onclick="changeStatus('.$_GET['id'].',2)">Set as completed</button>';
                }

                if ($itemResult['finished'] != 1) {
                    echo '<button class="btn btn-warning" onclick="changeStatus('.$_GET['id'].',1)">Set as accepted</button>';
                }

                if ($itemResult['finished'] != 0) {
                    echo '<button class="btn btn-success" onclick="changeStatus('.$_GET['id'].',3)">Set as available</button>';
                }
            } else {
                if ($itemResult['finished'] == 0) {
                    echo '<button class="btn btn-warning" onclick="changeStatus('.$_GET['id'].',1)">Set you want it</button>';
                }
                elseif ($itemResult['finished'] == 1) {
                    echo '<button class="btn btn-danger" onclick="changeStatus('.$_GET['id'].',3)">Reset to available</button>';
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
        echo '</div>'; 
        echo '</div>';

        //Editing details
        if (isset($_SESSION['userID']) & $stmtItem->rowCount() == 1) {
            if ($_SESSION['userID'] == $itemResult['FKclient']) {
                echo '<div id="itemEditing" style="display: none;">

                <div class="modal-header background-color-blue">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><h4>&times;</h4></button>
                <h4 class="myModalLabel">Editing: '.$itemResult['name'].'</h4>
                </div>

                <div class="modal-body testing">
                <label>Title<input type="text" id="newTitle" required value="'.$itemResult['name'].'" placeholder="Lisiting name..."><br/></label>
                <br>

                <label>Description
                <input type="text" id="newDescription" required value="'.$itemResult['description'].'" placeholder="Enter description..."><br/></label>
                <br>

                <label>Type
                <select id="newCategory">';
                if ($itemResult['category'] == "Request") {
                    echo '<option selected="selected" value="Request">Request</option>
                    <option value="Supplying">Supplying</option>';
                } else {
                    echo '<option value="Request">Request</option>
                    <option selected="selected" value="Supplying">Supplying</option>';
                }
                echo '</select>
                </label>

                <br>
                <br><button type="button" class="btn btn-primary" onclick="editListing('.$_GET['id'].')">Submit changes</button>
                <br><span id="itemEditMessage"></span>
                </div>

                <div class="modal-footer testing">
                <button type="button" class="btn btn-danger" onclick="removeListing('.$_GET['id'].')">Remove listing</button>
                <button type="button" class="btn btn-default" onclick="changeHiddenState()">Cancel edit</button>
                </div>
                </div>
                </div>
                </div>';
            }
        }
    } else {
        echo '<div class="modal-header background-color-blue">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><h4>&times;</h4></button>
        <h4 class="myModalLabel">Item not found</h4>
        </div>
        <div class="modal-body"></div>
        </div>'; 
    }

?>