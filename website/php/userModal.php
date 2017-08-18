<?php	
	session_start();
    if (isset($_SESSION['userID'])){
        if ($_SESSION['accountType'] === "3"){
            if (!empty($_GET['id'])) {
                include("config.php");
            	echo '<div class="modal-dialog">
                    <div class="modal-content">
                        <div id="itemInfo" style="display: block;">
                            <div class="modal-header background-color-blue">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><modalTitle>&times;</modalTitle></button>';
                                $stmt = $db->prepare("SELECT client.clientFirstName, client.clientLastName, organisation.name orgName, organisation.groupID, client.accountType FROM client LEFT JOIN organisation ON client.FKgroup = organisation.groupID WHERE clientID=?");
                                $stmt->execute(array($_GET['id']));
                                $userName = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo '<modalTitle class="myModalLabel">['.$_GET['id'].'] '.$userName['clientFirstName'].' '.$userName['clientLastName'].' - ';
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
                                    if($userName['groupID'] != null) {
                                        echo '<p class="testing">Organisation: <a class="pointer" onclick="getOrganisationModal('.$userName['groupID'].')">'.$userName['orgName'].'</a></p>';
                                    }
                                    echo '<button class="btn btn-primary testing" onclick="deleteAccount('.$_GET['id'].')">Delete account</button>
                                    <br><table class="table table-bordered fullItemDesc" style="table-layout: fixed; overflow: hidden;">
                                        <thead>
                                            <tr>
                                                <td><b>User items<b></td>
                                            </tr>
                                        </thead>
                                        <tbody>';

                                            $stmt = $db->prepare("SELECT itemID, name, category, finished FROM item WHERE FKclient=? ORDER BY finished ASC");
                                            $stmt->execute(array($_GET['id']));
                                            if ($stmt->rowCount() == 0) {
                                                echo '<tr><td>NONE</td></tr>';
                                            } else {
                                                $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($stmt as $row) {
                                                    echo '<tr class="pointer" onclick="getItemModal('.$row['itemID'].')">
                                                        <td class="';
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
                                                        echo '">['.$row['itemID'].'] '.$row['name'].'</td>
                                                    </tr>';
                                                }
                                            }

                                        echo '</tbody>
                                    </table>
                                    <br><button type="button" class="btn btn-default testing" data-dismiss="modal" aria-hidden="true"">Close window</button>
                                </div>
                            </div>';
                        echo'</div>
                    </div>
                </div>';
            }
        }
    }
?>