<?php
	include("config.php");
    include("updateItemFinished.php");
	session_start();

    //Get the items info, items owner info and the items tags info
    $stmtItem = $db->prepare("SELECT client.clientFirstName, client.clientLastName, client.email, client.accountType, client.FKgroup, item.*, tag.name imgTag FROM client, item INNER JOIN tag ON item.FKTagID = tag.tagID WHERE client.clientID = item.FKclient AND item.itemID = ?");
    $stmtItem->execute(array($_GET['id']));
    $itemResult = $stmtItem->fetch(PDO::FETCH_ASSOC);

    //Get the organisation info
    $stmtOrg = $db->prepare("SELECT name FROM organisation WHERE groupID=?");
    $stmtOrg->execute(array($itemResult['organisation']));
    $organisationResult = $stmtOrg->fetch(PDO::FETCH_ASSOC);

    //If the user is logged in then select their organisation
    if (isset($_SESSION['userID'])) {
        $stmtItem = $db->prepare("SELECT FKgroup FROM client WHERE clientID = ?");
        $stmtItem->execute(array($_SESSION['userID']));
        $clientResult = $stmtItem->fetch(PDO::FETCH_ASSOC);
    }

	echo '<div class="modal-dialog">
    <div class="modal-content">';
                
    //Item details
    echo '<div id="itemInfo" style="display: block;">';
    if ($stmtItem->rowCount() == 1) {
        //Item heading
        echo '<div class="modal-header background-color-blue">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><modalTitle>&times;</modalTitle></button>
            <modalTitle class="modalHeadings">'.$itemResult['name'].'</modalTitle>
        </div>
        <div class="modal-body">';
        //Social media links
        echo '<a class="btn facebook" href="https://www.facebook.com/sharer/sharer.php?u=https://peterbillett.com?item='.$_GET['id'].'" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i> Share on Facebook</a>
        <a class="btn twitter"href="https://twitter.com/intent/tweet?text=https://peterbillett.com?item='.$_GET['id'].'"><i class="fa fa-twitter" aria-hidden="true"></i> Tweet</a>
        <table class="table fullItemDesc">';

        //item Image
        echo '<tbody>
        <tr>
            <td class="tableImage">
                <div>
                    <img id="modalImage'.$_GET['id'].'" src="php/imageGet.php?id='.$_GET['id'].'&'.date('Y-m-d H:i:s').'" class="itemImage" alt="'.$itemResult['imgTag'].'"/>
                </div>
            </td>';

            //Item details: client, organisation+url, end date/time
            echo '<td>';
            if ($itemResult['category'] === "Supplying") {
                echo 'Supplier: ';
            } else {
                echo 'Requester: ';
            }
            echo $itemResult['clientFirstName'].' '.$itemResult['clientLastName'];
            if ($stmtOrg->rowCount() == 1) {
                echo '<br>Organisation: <a><button type="button" class="table-button inlineBlock" onclick="getOrganisationModal('.$itemResult['organisation'].')">'.$organisationResult['name'].'</button></a>';
            } else {
                echo '<br>Organisation: [NONE]';
            }
            echo '<br>End date/time: '.$itemResult['endtime'];
            echo '<br><a href="mailto:'.$itemResult['email'].'?Subject='.$itemResult['name'].'">Send email</a>';

            //Depending on if the user is logged in (and if so if the group they are in belongs to the item) show buttons
            echo '<br>';
            if(isset($_SESSION['userID'])) {
                if ($_SESSION['userID'] === $itemResult['FKclient'] || $_SESSION['accountType'] === "3"  || $_SESSION['accountType'] === "2" && $clientResult['FKgroup'] === $itemResult['organisation'] && $itemResult['organisation'] != NULL) {
                    echo '<button type="button" class="btn btn-default" onclick="changeHiddenState('."'item'".')">Edit</button>';
                    if ($itemResult['finished'] != 2) {
                        echo '<button class="btn btn-primary" onclick="changeStatus('.$_GET['id'].',2)">Set as Unavailable</button>';
                    }

                    if ($itemResult['finished'] != 1) {
                        echo '<button class="btn btn-warning" onclick="changeStatus('.$_GET['id'].',1)">Set as Reserved</button>';
                    }

                    if ($itemResult['finished'] != 0) {
                        echo '<button class="btn btn-success" onclick="changeStatus('.$_GET['id'].',3)">Set as Available</button>';
                    }

                } else {
                    if ($itemResult['finished'] == 0) {
                        echo '<button class="btn btn-warning" onclick="changeStatus('.$_GET['id'].',1)">Reserve this</button>';
                    }
                    elseif ($itemResult['finished'] == 1) {
                        echo '<button class="btn btn-success" onclick="changeStatus('.$_GET['id'].',3)">Reset to Available</button>';
                    }
                }
            }
            echo '</td>
        </tr>';

        //Depending on the item status set class for colouring and text shown
        switch ($itemResult['finished']) {
            case 0:
                echo '<tr id="currentItemStatus"><td colspan="2" class="itemStatus available">
                <span>Available<span></td></tr>';
                break;
            case 1:
                echo '<tr id="currentItemStatus"><td colspan="2" class="itemStatus wanted">
                <span>Reserved<span></td></tr>';
                break;
            default:
                echo '<tr id="currentItemStatus"><td colspan="2" class="itemStatus primary">
                <span>Unavailable<span></td></tr>';
        }

        //Item description
        echo '<tr><td colspan="2"><b>Description: </b>'.$itemResult['description'].'</td></tr>
        </tbody>
        </table>';

        //If an address is set for the item then show the map
        if ($itemResult['location'] !== NULL){
             echo '<iframe class="maps-frame" src="https://www.google.com/maps/embed/v1/search?q='.str_replace(' ', '+', $itemResult['location']).'&zoom=16&key=AIzaSyDnIx1QkG-_64NuLSYxxQj4vkcdt9I5zV0"></iframe>';
        }

        echo '<button type="button" class="btn btn-default testing" data-dismiss="modal" aria-hidden="true"">Close window</button>
        <div class="testing" id="itemInfoMessage"></div>
        </div>
        </div>';

        //Editing details
        if (isset($_SESSION['userID'])) {
            if ($_SESSION['userID'] === $itemResult['FKclient'] || $_SESSION['accountType'] === "3" || $_SESSION['accountType'] === "2" && $clientResult['FKgroup'] == $itemResult['organisation'] && $itemResult['organisation'] != NULL) {
                //Heading
                echo '<div id="itemEditing" style="display: none;">

                <div class="modal-header background-color-blue">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><h4>&times;</h4></button>
                <h4 class="myModalLabel">Editing: '.$itemResult['name'].'</h4>
                </div>

                <div class="modal-body testing">';

                //New title textbox and description textarea
                echo '<input type="text" class="form-control" id="newTitle" required value="'.$itemResult['name'].'" placeholder="Enter lisiting name..."></input><br>
                <textarea type="text" class="form-control" placeholder="Enter description..." id="newDescription" required rows="4" cols="30">'.$itemResult['description'].'</textarea><br>';

                //Category select (The current category is the one selected first)
                echo '<label>Category: 
                    <select class="form-control removeSelectWidth" id="newCategory">';
                        if ($itemResult['category'] == "Request") { //If it is currently a request then show that as the default
                            echo '<option selected="selected" value="Request">Request</option>
                            <option value="Supplying">Supplying</option>';
                        } else { //If it is currently supplying then show that as the default
                            echo '<option value="Request">Request</option>
                            <option selected="selected" value="Supplying">Supplying</option>';
                        }
                    echo '</select>
                </label>';

                //Datetime picker to update the end datetime
                echo '<label>End datetime: 
                    <div class="input-group date" id="datetimepicker2">
                        <input id="newDateTime" readonly="true" type="text" class="form-control">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </label>';
                
                //Submit button
                echo '<br><br><button type="button" class="btn btn-primary" onclick="editListing('.$_GET['id'].')">Submit changes</button><br>';

                //Upload image button
                echo '<br><label class="btn btn-block btn-primary">
                    Browse&hellip; <input type="file" name="fileToUpload" id="fileToUpload" style="display: none;">
                </label>
                <input class="btn btn-block btn-default" type="button" onclick="submitFile('.$_GET['id'].')" value="';
                if ($itemResult['image'] == NULL) { //if there is currently no image then the button should say upload image else it should say update image
                    echo 'Upload Image';
                } else {
                    echo 'Update Image';
                }
                echo '" name="submit">';

                //Messages can be sent to this span
                echo '<span id="itemEditMessage"></span>
                </div>';

                //Buttons to remove the listing or cancel the edit
                echo '<div class="modal-footer testing">
                <button type="button" class="btn btn-danger" onclick="removeListing('.$_GET['id'].')">Remove listing</button>
                <button type="button" class="btn btn-default" onclick="changeHiddenState('."'item'".')">Cancel edit</button>
                </div>
                </div>
                </div>
                </div>';
            }
        }
    } else { //if the item is not found then return this
        echo '<div class="modal-header background-color-blue">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><h4>&times;</h4></button>
        <h4 class="myModalLabel">Item not found</h4>
        </div>
        <div class="modal-body"></div>
            <button type="button" class="btn btn-default testing" data-dismiss="modal" aria-hidden="true"">Close window</button>
        </div>'; 
    }

?>