<?php
    include("../config.php");
    include("../updateItemFinished.php");
    session_start();

    //Confirm the user is logged in
    if(isset($_SESSION['userID'])) {
        $availableCount = 0;
        $wantedCount = 0;
        $finishedCount = 0;
        $availableRequestsCount = 0;
        $wantedRequestsCount = 0;
        $finishedRequestsCount = 0;
        $availableSupplyingCount = 0;
        $wantedSupplyingCount = 0;
        $finishedSupplyingCount = 0;
        
        //Create a the wrapper to resize the page when the user adjusts the browser window
        //Create the side menu for the users settings
        echo '<div id="wrapper">
            <div id="sidebar-wrapper" class="sideMenuHeight" unselectable="on" onselectstart="return false;" onmousedown="return false;">
                <ul class="sidebar-navSide" style="margin-left:0; color:white;">
                    <br>
                    <li class="sideMenuMainItem cursorPointer"><a id="menu-toggle" data-toggle="tooltip" data-html="true" title="Toggles sidemenu"><i class="fa fa-cog" aria-hidden="true"></i><span class="sideMenuItem">SETTINGS MENU</span></a></li>
                    <li class="sideMenuSecondItem cursorPointer"><a onclick="getPasswordUpdater()" title="Update your password" data-toggle="modal" data-target="#modal-modalDetails" class="no-select-link"><i class="fa fa-key" aria-hidden="true"></i> <span class="sideMenuSize">Update Password</span></a></li>';
                    
                    $stmt = $db->prepare('SELECT * FROM client WHERE clientID = ? AND FKgroup IS NOT NULL');
                    $stmt->execute(array($_SESSION['userID']));
                    if($stmt->rowCount() > 0 ) {
                        echo '<li class="cursorPointer"><a onclick="sendOffPHP('."'modalDetails'".', '."'/php/modalLeaveOrganisation.php'".')" title="Leave your organisation"  data-toggle="modal" data-target="#modal-modalDetails" class="no-select-link"><i class="fa fa-users" aria-hidden="true"></i> <span class="sideMenuSize">Leave organisation</span></a></li>';
                    } else {
                        echo '<li class="cursorPointer"><a title="Join an organisation" class="no-select-link" data-toggle="modal" data-target="#modal-joinVol"><i class="fa fa-users" aria-hidden="true"></i> <span class="sideMenuSize">Join organisation</span></a></li>';
                    }
                    echo '<li class="cursorPointer"><a onclick="getNotificationModal()" title="Change your notification settings" data-toggle="modal" data-target="#modal-modalDetails" class="no-select-link"><i class="fa fa-envelope" aria-hidden="true"></i> <span class="sideMenuSize">Notifications</span></a></li>
                    <li class="cursorPointer"><a onclick="sendOffPHP('."'modalDetails'".', '."'/php/modalDeleteAccount.php'".')" title="Delete your account" data-toggle="modal" data-target="#modal-modalDetails" class="no-select-link"><i class="fa fa-user-times" aria-hidden="true"></i> <span class="sideMenuSize">Delete Account</span></a></li>              
                </ul>
            </div>
            <div id="page-content-wrapper">
                <div class="container-fluid">';
                    include('../legendBar.php'); //Put the legend above the item collapses

                    //Get the clients name and print it
                    $stmt = $db->prepare('SELECT clientFirstName, clientLastName FROM client WHERE clientID = ?');
                    $stmt->execute(array($_SESSION['userID']));
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo '<div class="testing table-padding"><b>Hi '.$row['clientFirstName'].' '.$row['clientLastName'].'<b><br>';
                            
                    //Get the users items and by category count each items status 
                    $stmt = $db->prepare('SELECT itemID, name, finished, category FROM item WHERE FKClient = ? ORDER BY endtime DESC');
                    $stmt->execute(array($_SESSION['userID']));
                    $listingCount = $stmt->rowCount();
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($results as $row) {
                        if ($row['category'] == "Request") {
                            switch ($row['finished']) {
                                case "0":
                                    $availableCount++;
                                    $availableRequestsCount++;
                                    break;
                                case "1":
                                    $wantedCount++;
                                    $wantedRequestsCount++;
                                    break;
                                default:
                                    $finishedCount++;
                                    $finishedRequestsCount++;                                                
                            }
                        } else {
                            switch ($row['finished']) {
                                case "0":
                                    $availableCount++;
                                    $availableSupplyingCount++;
                                    break;
                                case "1":
                                    $wantedCount++;
                                    $wantedSupplyingCount++;
                                    break;
                                default:
                                    $finishedCount++;
                                    $finishedSupplyingCount++;
                            }
                        }
                    }

                    //Calculate the percentage of item status
                    $availablePercent = GetPercentage($listingCount,$availableCount);
                    $wantedPercent = GetPercentage($listingCount,$wantedCount);
                    $finishedPercent = GetPercentage($listingCount,$finishedCount);
                    $totalPercent = ($availablePercent + $wantedPercent + $finishedPercent);
                    //Ensure that there was no error calculating 100%
                    //If there is then remove the extra %
                    if ($totalPercent > 100.00) {
                        $removePercent = $totalPercent - 100;
                        if (max($availablePercent,$wantedPercent,$finishedPercent) == $availablePercent){
                            $availablePercent = $availablePercent - $removePercent;
                        } elseif (max($availablePercent,$wantedPercent,$finishedPercent) == $wantedPercent){
                            $wantedPercent = $wantedPercent - $removePercent;
                        } else {
                            $finishedPercent = $finishedPercent - $removePercent;
                        }
                    }

                    //Create the area for the user item collapses
                    echo '<div class="panel-group">
                        <div class="panel panel-default">';

                            //Using the % calculated earlier show that in a bar (eg ava:30% of bar, wanted:10% of bar, finsihed: 60% of bar) by their associated
                            if ($listingCount > 0){
                                echo '<div class="progress">';
                                if ($availableCount > 0 ) {
                                    echo '<div class="progress-bar progress-bar-success" role="progressbar" style="width:'.$availablePercent.'%">
                                        &#8203;
                                    </div>';
                                }
                                if ($wantedCount > 0 ) {
                                    echo '<div class="progress-bar progress-bar-warning" role="progressbar" style="width:'.$wantedPercent.'%">
                                        &#8203;
                                    </div>';
                                }
                                if ($finishedCount > 0 ) {
                                    echo '<div class="progress-bar progress-bar" role="progressbar" style="width:'.$finishedPercent.'%">
                                        &#8203;
                                    </div>';
                                }
                                                                   
                            //List the number of items for the status categories for that users items (eg 10 ava, 1 wanted, 12 finished) 
                            echo '</div>
                            <h4 class="panel-title">
                                Available: <span class="badge dontHideBadge">'.$availableCount.'</span> | Reserved: <span class="badge dontHideBadge">'.$wantedCount.'</span> | Unavailable: <span class="badge dontHideBadge">'.$finishedCount.'</span>
                            </h4>';

                            //Requests collapse
                             echo '<div class="panel-heading" unselectable="on" onselectstart="return false;" onmousedown="return false;" data-toggle="collapse" href="#collapseRequests">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-parent="#panel-group">Your requests</a>
                                </h4>
                            </div>
                            <div id="collapseRequests" class="panel-collapse collapse">
                                <ul class="list-group scrollable-menu scrollbar">';    
                                //For each request item the user has: create a list item, colour code it, show the title and add the onclick item modal for it                                    
                                foreach ($results as $row) {
                                    if ($row['category'] == "Request") {
                                        echo '<li id="profileListingID'.$row['itemID'].'" class="list-group-item ';
                                        switch ($row['finished']) {
                                            case "0":
                                                echo 'available">';
                                                break;
                                            case "1":
                                                echo 'wanted">';
                                                break;
                                            default:
                                                echo 'primary">';
                                        }
                                        //Clicking the item opens the item modal with that items information 
                                        echo '<button type="button" class="table-button" onclick="getItemModal('.$row['itemID'].')" data-toggle="modal" data-target="#modal-modalDetails"><span class="dontHideBadge" style="display: flex;"><span class="fa fa-shopping-cart dontHideBadge"></span> '.$row['name'].'</span></button></li>';
                                    }
                                }
                                echo'</ul>
                            </div>';

                            //Requests collapse
                            echo '<div class="panel-heading" unselectable="on" onselectstart="return false;" onmousedown="return false;" data-toggle="collapse" href="#collapseSupplying" onclick="changeNotificationCollase()">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-parent="#panel-group">Your supplying</a>
                                </h4>
                            </div>
                            <div id="collapseSupplying" class="panel-collapse collapse">
                                <ul class="list-group scrollable-menu scrollbar">';      
                                //For each supplying item the user has: create a list item, colour code it, show the title and add the onclick item modal for it                                  
                                foreach ($results as $row) {
                                    if ($row['category'] == "Supplying") {
                                        echo '<li id="profileListingID'.$row['itemID'].'" class="list-group-item ';
                                        switch ($row['finished']) {
                                            case "0":
                                                echo 'available">';
                                                break;
                                            case "1":
                                                echo 'wanted">';
                                                break;
                                            default:
                                                echo 'primary">';
                                        }
                                        //Clicking the item opens the item modal with that items information
                                        echo '<button type="button" class="table-button" onclick="getItemModal('.$row['itemID'].')" data-toggle="modal" data-target="#modal-modalDetails"><span class="dontHideBadge" style="display: flex;"><span class="glyphicon glyphicon-gift dontHideBadge"></span> '.$row['name'].'</span></button></li>';
                                    }
                                }
                                echo'</ul>
                            </div>';
                            } else {
                                //If the user has no items the don't create the % bar and collapses. Instead report they have no listings in the % bar
                                if ($availableCount == 0 & $wantedCount == 0 & $finishedCount == 0){
                                    echo '<div class="progress-bar progress-bar-info" role="progressbar" style="width:100%">
                                        You have no listings
                                    </div>';
                                }
                            }
                               
                        echo '</div><br>
                    </div>
                </div>';

                //Load the notification table from the notificationTable.php file
                echo '<div id="notificationTable" class="testing table-padding">';
                    include("../notificationTable.php");
                echo '</div><br>
            </div>
        </div>';
    } else {
        //If the user is not logged in the reload the page (they should not be able to load the user profile page if they are not logged in)
        echo '<script>location.reload();</script>';
    }

    //Calculates the % from the passed numberes
    function GetPercentage($total, $number) {
        if ( $total > 0 ) {
            return round($number / ($total / 100),2);
        } else {
            return 0;
        }
    }
?>