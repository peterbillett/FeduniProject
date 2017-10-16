<?php
    session_start();

    //Create modal
    echo '<div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header background-color-blue">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
                <span class="modalTitle">Leave organisation</span>
            </div>

            <div id="leaveOrganisationMessage" class="modal-body testing">';
            //Check the user is logged in
            if (isset($_SESSION['userID'])){
                //Show warning and button to confirm leaving the organisation 
                if ($_SESSION['accountType'] === "2"){
                    include("config.php");
                    $stmt = $db->prepare("SELECT FKgroup FROM client WHERE clientID = ?");
                    $stmt->execute(array($_SESSION['userID']));
                    $groupID = $stmt->fetch(PDO::FETCH_ASSOC);

                    $stmt = $db->prepare("SELECT clientID FROM client WHERE FKgroup = ?");
                    $stmt->execute(array($groupID['FKgroup']));
                    if ($stmt->rowCount() > 1) {
                        echo 'You must designate another member to be the owner of your organisation before you can leave it.<br>
                        <button type="button" class="btn btn-default" onclick="viewOrganisationMembers('.$groupID['FKgroup'].')">Click this button to change the owner</button> 
                        </div>
                        <div class="modal-footer testing">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>';
                    } else {
                        echo 'WARNING: You are the last member in this organisation,<br>
                        Leaving this organisation will delete it.
                        </div>
                        <div class="modal-footer testing">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" onclick="leaveOrganisation()">Yes delete organisation</button>
                        </div>';
                    }
                } else {
                    echo 'WARNING: Are you sure you want to leave your organisation?<br>
                    </div>
                    <div class="modal-footer testing">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" onclick="leaveOrganisation()">Yes leave organisation</button>
                    </div>';
                }
            } else {
                echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <p>YOU MUST BE LOGGED IN TO LEAVE YOUR ORGANISATION</p>
                </div>
                </div>
                <div class="modal-footer testing">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>';
            }
        echo '</div>
    </div>';
?>