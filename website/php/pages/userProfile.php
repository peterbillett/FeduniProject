<?php
    include("../config.php");
    session_start();
    $availableCount = 0;
    $wantedCount = 0;
    $finishedCount = 0;

    echo '<div class="testing table-padding"><b>Your Listings<b><br>';
            
    $stmt = $db->prepare('SELECT itemID, name, finished FROM item WHERE FKClient = ? ORDER BY itemID DESC');
    $stmt->execute(array($_SESSION['userID']));
    if($stmt->rowCount() > 0) { 
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $row) {
            switch ($row['finished']) {
                case "0":
                    $availableCount++;
                    break;
                case "1":
                    $wantedCount++;
                    break;
                default:
                    $finishedCount++;
            }
        }
        echo 'Available items: '.$availableCount.' | Wanted items: '.$wantedCount.' | Finished items: '.$finishedCount;

        echo '<table class="table-userListings testing table-bordered "';
        if (sizeof($results) > 10){
            echo 'style="height:250px"';
        }
        echo'>';
        foreach ($results as $row) {
            echo '<tr><td class="';
            switch ($row['finished']) {
                case "0":
                    echo 'available table-maxwidth" value="available">';
                    break;
                case "1":
                    echo 'wanted table-maxwidth" value="wanted">';
                    break;
                default:
                    echo 'finished table-maxwidth" value="finished">';
            }
            echo '<button type="button" class="table-button" onclick="getItemModal('.$row['itemID'].')" data-toggle="modal" data-target="#modal-modalDetails">'.$row['name'].'</button></td></tr>';
        }
        echo'</table>';
    }
    echo '</div>';

?>