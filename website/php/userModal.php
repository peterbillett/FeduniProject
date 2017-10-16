<?php
    //Admin can access this to view and edit the members to an organisation 
	session_start();
    //Check the user is logged in
    if (isset($_SESSION['userID'])){
        //Check if user is an admin
        if ($_SESSION['accountType'] === "3"){
            //Check an id has been passed
            if (!empty($_GET['id'])) {
                include("config.php");
                //Create a modal
            	echo '<div class="modal-dialog">
                    <div class="modal-content">
                        <div id="itemInfo" style="display: block;">
                            <div class="modal-header background-color-blue">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><modalTitle>&times;</modalTitle></button>';
                                //Select the clients details and their organisation details
                                $stmt = $db->prepare("SELECT client.clientFirstName, client.clientLastName, organisation.name orgName, organisation.groupID, client.accountType FROM client LEFT JOIN organisation ON client.FKgroup = organisation.groupID WHERE clientID=?");
                                $stmt->execute(array($_GET['id']));
                                $userName = $stmt->fetch(PDO::FETCH_ASSOC);
                                //Print their id and name for the title
                                echo '<modalTitle class="myModalLabel">['.$_GET['id'].'] '.$userName['clientFirstName'].' '.$userName['clientLastName'].' - ';
                                //Print what type of account they have 
                                switch ($userName['accountType']) {
                                    case '1':
                                        echo 'Normal user';
                                        break;
                                    case '2':
                                        echo 'Organisation owner';
                                        break;
                                    case '3':
                                        echo 'Admin';
                                        break;
                                }
                                echo '</modalTitle>
                            </div>
                            <div class="modal-body">
                                <div class="center wrapper">';
                                    //If they are in a group then print (their name) a link to its organisation modal
                                    if($userName['groupID'] != null) {
                                        echo '<p class="testing">Organisation: <a class="pointer" onclick="getOrganisationModal('.$userName['groupID'].')">'.$userName['orgName'].'</a></p>';
                                    }
                                    //Create a button to delete the client then create a table to display all of the clients items
                                    echo '<button class="btn btn-primary testing" onclick="deleteAccount('.$_GET['id'].')">Delete account</button>
                                    <br><table class="table table-bordered fullItemDesc" style="table-layout: fixed; overflow: hidden;">
                                        <thead>
                                            <tr>
                                                <td><b>User items<b></td>
                                            </tr>
                                        </thead>
                                        <tbody>';

                                            //Select all of the clients items
                                            $stmt = $db->prepare("SELECT itemID, name, category, finished FROM item WHERE FKclient=? ORDER BY finished ASC");
                                            $stmt->execute(array($_GET['id']));
                                            //If it returns nothing then print the client has no items
                                            if ($stmt->rowCount() == 0) {
                                                echo '<tr><td>NONE</td></tr>';
                                            } else { //Else for each item
                                                $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($stmt as $row) { //Print a row that can be clicked to open its item modal
                                                    echo '<tr class="pointer" onclick="getItemModal('.$row['itemID'].')">
                                                        <td class="';
                                                        //Deoending on the status change the colour (blue, orange, green)
                                                        switch ($row['finished']) {
                                                            case "0":
                                                                echo 'available';
                                                                break;
                                                            case "1":
                                                                echo 'wanted';
                                                                break;
                                                            default:
                                                                echo 'primary';
                                                        }
                                                        //Print the items id and name
                                                        echo '">['.$row['itemID'].'] '.$row['name'].'</td>
                                                    </tr>';
                                                }
                                            }
                                            //Finished the table and add a close window button
                                        echo '</tbody>
                                    </table>
                                    <br><button type="button" class="btn btn-default testing" data-dismiss="modal" aria-hidden="true"">Close window</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }
    }
?>