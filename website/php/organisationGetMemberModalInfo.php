<?php
	include("config.php");
	session_start();

    //Check the user is logged in
    if(isset($_SESSION['userID'])){
        //Check if an organisation exists for that id
        $stmt = $db->prepare("SELECT name FROM organisation WHERE groupID=?");
        $stmt->execute(array($_GET['id']));
        if ($stmt->rowCount() > 0) { //If it exists
            //Get the users organisation group
            $organisationResult = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmtClient = $db->prepare("SELECT FKgroup FROM client WHERE clientID = ?");
            $stmtClient->execute(array($_SESSION['userID']));
            $clientResult = $stmtClient->fetch(PDO::FETCH_ASSOC);

            //Check if the user is an admin else if they are the organisations owner
            if ($_SESSION['accountType'] === "3"  || $_SESSION['accountType'] === "2" && $clientResult['FKgroup'] === $_GET['id']) {
                //If they are then select all of the clients that are in that organisation
                $stmt = $db->prepare("SELECT clientID, clientFirstName, clientLastName, accountType FROM client WHERE FKgroup=?");
                $stmt->execute(array($_GET['id']));
                $userCount = $stmt->rowCount();
                $userResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //Create a modal
                echo '<div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header background-color-blue">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
                            <span class="modalTitle">'.$organisationResult['name'].' members</span>
                        </div>

                        <div class="modal-body">
                            <div class="center wrapper">
                                <label>Organisation owner: <select id="orgMemberList" name="orgMemberList" class="form-control orgMemberList">';
                                //For each client in the org add them as options to a select with the default selected one being the current org owner
                                foreach ($userResults as $row) {
                                    echo '<option ';
                                    if ($row['accountType'] === '2'){
                                        echo 'selected="selected" ';
                                    }
                                    echo 'value="'.$row['clientID'].'">'.$row['clientFirstName'].' '.$row['clientLastName'].'</option>';
                                }
                                //Add a button to change the org owner to the one selected in the selected then create a table to show all of the members
                                echo '</select></label>
                                <button type="button" class="btn btn-danger" onclick="OrganisationUpdateOwner('.$_GET['id'].')">Change organisation owner</button>
                                <br><hr>
                                <p><table class="table table-hover" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Modify</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                        //For each client in the org create a row with their name and a button to remove them from the org (unless they are the org owner)
                                        foreach ($userResults as $row) {
                                            echo '<tr>
                                                <td class="notificationChangeTable" style="text-align: left;"><b>'.$row['clientFirstName'].' '.$row['clientLastName'].'&nbsp;</b></td>
                                                <td class="notificationChangeTable" style="text-align: left;">';
                                                if ($row['accountType'] != "2" ) {
                                                    echo '<button type="button" class="btn btn-default" onclick="OrganisationRemoveMember('.$row['clientID'].', '.$_GET['id'].')">Remove member</button>';
                                                } else {
                                                    echo '*Organisation owner*';
                                                }
                                                echo '</td>
                                            <tr>';
                                        }
                                    echo '</tbody>
                                </table></p>
                            </div>
                        </div>';

                        //Add buttons to go back to the org modal or close the modal window
                        echo '<div class="modal-footer testing">
                            <button type="button" class="btn btn-default" onclick="getOrganisationModal('.$_GET['id'].')">Go back</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close window</button>
                        </div>
                    </div>
                </div>';
            }
        }
    }
?>