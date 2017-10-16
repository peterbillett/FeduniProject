<?php
	include("config.php");
	session_start();

    //Select all details for the organisation
    $stmt = $db->prepare("SELECT * FROM organisation WHERE groupID=?");
    $stmt->execute(array($_GET['id']));

    //Create a modal
	echo '<div class="modal-dialog">
        <div class="modal-content">
            <div id="organisationInfo" style="display: block;">
                <div class="modal-header background-color-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><modalTitle>&times;</modalTitle></button>';

                //If a result was found then
                if ($stmt->rowCount() > 0) {
                    $organisationResult = $stmt->fetch(PDO::FETCH_ASSOC);
                    //Print the orgs name
                        echo '<modalTitle class="myModalLabel">'.$organisationResult['name'].'</modalTitle>
                    </div>
                    <div class="modal-body">
                        <div class="center wrapper">';
                            //Create buttons to share a link to this organisation on facebook and twitter
                            echo '<a class="btn facebook" href="https://www.facebook.com/sharer/sharer.php?u=https://peterbillett.com?organisation='.$_GET['id'].'" target="_blank"><i class="icon-facebook-sign" aria-hidden="true"></i> Share on Facebook</a>
                            <a class="btn twitter"href="https://twitter.com/intent/tweet?text=https://peterbillett.com?organisation='.$_GET['id'].'"><i class="icon-twitter" aria-hidden="true"></i> Tweet</a> ';
                            //If the user is logged in
                            if (isset($_SESSION['userID'])) {
                                //Get the users details
                                $stmtClient = $db->prepare("SELECT accountType, FKgroup FROM client WHERE clientID = ?");
                                $stmtClient->execute(array($_SESSION['userID']));
                                $clientResult = $stmtClient->fetch(PDO::FETCH_ASSOC);
                                //If the user is an admin or the organisation owner then display buttons to edit the org and view the orgs members
                                if ($_SESSION['accountType'] === "3"  || $_SESSION['accountType'] === "2" && $clientResult['FKgroup'] === $organisationResult['groupID']) {
                                    echo '<a class="btn btn-default" onclick="changeHiddenState('."'organisation'".')">Edit</a>
                                    <button type="button" class="btn btn-default" onclick="viewOrganisationMembers('.$_GET['id'].')">View members</button>';
                                }
                            }

                            //Create a table to display their information, news, a map showing their location and a button to close the modal window
                            echo '<table class="table table-striped table-bordered table-hover table-restrict-size table-padding fullItemDesc">
                                <thead>
                                    <tr><td><b>Description: </b>'.$organisationResult['Information'].'</td></tr>
                                </thead>
                                <tbody>
                                    <tr><td><b>Current News: </b>'.$organisationResult['currentNews'].'</td></tr>
                                </tbody>
                            </table>
                            <br>
                            <iframe class="maps-frame" src="https://www.google.com/maps/embed/v1/search?q='.str_replace(' ', '+', $organisationResult['address']).'&zoom=16&key=AIzaSyDnIx1QkG-_64NuLSYxxQj4vkcdt9I5zV0"></iframe>
                            <br><button type="button" class="btn btn-default testing" data-dismiss="modal" aria-hidden="true"">Close window</button>
                        </div>
                    </div>
                </div>';

                //Editing details
                //Check the user is logged in
                if (isset($_SESSION['userID'])) {
                    //Check they are either an admin or the org owner
                    if ($_SESSION['accountType'] === "3"  || $clientResult['accountType'] === "2" && $clientResult['FKgroup'] === $organisationResult['groupID']) {
                        //Create another inner modal but set it to display none (so its hidden on default)
                        echo '<div id="organisationEditing" style="display: none;">

                        <div class="modal-header background-color-blue">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><h4>&times;</h4></button>
                            <h4 class="myModalLabel">Editing: '.$organisationResult['name'].'</h4>
                        </div>';

                        //Create input fields to update the organisations name, information, news and address on click of the submit button
                        echo '<div class="modal-body testing">
                            <b>Update Name</b>
                            <input type="text" class="form-control" id="updateName" required value="'.$organisationResult['name'].'" placeholder="Enter new name..."></input>

                            <b>Update Description</b>
                            <textarea type="text" class="form-control" placeholder="Enter description..." id="updateDescription" required rows="4" cols="30">'.$organisationResult['Information'].'</textarea>
                            
                            <b>Update Current News</b>
                            <textarea type="text" class="form-control" placeholder="Enter currentNews..." id="updateCurrentNews" rows="4" cols="30">'.$organisationResult['currentNews'].'</textarea>

                            <b>Update Address</b>
                            <input type="text" class="form-control" id="updateCustomAdressOrg" required value="'.$organisationResult['address'].'" placeholder="Enter address..."></input>

                            <br><button type="button" class="btn btn-primary" onclick="editOrganisation('.$_GET['id'].')">Submit changes</button><br>
                            <span id="organisationEditMessage"></span>
                        </div>';

                        //Buttons to delete the organisation and a cancel edit button that returns to the organisation info modal view
                        echo '<div class="modal-footer testing">
                            <button type="button" class="btn btn-danger" onclick="organisationRemove('.$_GET['id'].')">Delete Organisation</button>
                            <button type="button" class="btn btn-default" onclick="changeHiddenState('."'organisation'".')">Cancel edit</button>
                        </div>
                    </div>
                </div>
            </div>';
                }
            }
        } else { //If no organisation is returned then set the inner modal details to say it was not found and a close modal button
            echo '<modalTitle class="myModalLabel">404 - Organisation not found</modalTitle>
            </div>
            <div class="modal-body">
                <div class="center wrapper">
                    <button type="button" class="btn btn-default testing" data-dismiss="modal" aria-hidden="true"">Close window</button>
                </div>
            </div>';
        }

        echo'</div>
    </div>';

?>