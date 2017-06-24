<?php
	include("config.php");
	session_start();

    $stmt = $db->prepare("SELECT * FROM organisation WHERE groupID=?");
    $stmt->execute(array(@$_GET['id']));
    $organisationResult = $stmt->fetch(PDO::FETCH_ASSOC);

   //For each item create table using name, description and itemID
	echo '<div class="modal-dialog">
        <div class="modal-content">';
                
          	//Item details
            echo '<div id="itemInfo" style="display: block;">';

                //Item heading
                echo '<div class="modal-header background-color-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><h4>&times;</h4></button>
                    <h4 class="myModalLabel">'.$organisationResult['name'].'</h4>
                </div>';

                echo '<div class="modal-body">';
                  	
                    echo '<div class="center wrapper">';
                    if ($stmt->rowCount() == 1) {
                        echo '<br><table class="table table-striped table-bordered table-hover table-restrict-size table-padding fullItemDesc">';
                            echo '<thead>';
                            //Item name
                               echo '<tr><td colspan="2"><b>'.$organisationResult['name'].'<b></td></tr>';
                            echo '</thead>';
                            echo '<tbody>';;
                                //Description
                                echo '<tr><td><b>Description: </b>'.$organisationResult['Information'].'</td></tr>';
                                //CurrentNews
                                echo '<tr><td><b>Current News: </b>'.$organisationResult['currentNews'].'</td></tr>';
                            echo '</tbody>';
                        echo '</table>';

                        echo '<iframe class="maps-frame" src="https://www.google.com/maps/embed/v1/search?q='.str_replace(' ', '+', $organisationResult['address']).'+3350+Australia&zoom=16&key=AIzaSyDnIx1QkG-_64NuLSYxxQj4vkcdt9I5zV0"></iframe>
                      ';
                    } else {
                        echo "<b>Organisation not found</b>";
                    }
                    echo'</div>';

                echo'</div>'; 
            echo'</div>
        </div>
    </div>';

?>