<?php
    include("../config.php");
    include("../updateItemFinished.php");
    session_start();

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
                    echo '<li class="cursorPointer"><a onclick="sendOffPHP('."'modalDetails'".', '."'/php/modalNotifications.php'".')" title="Change your notification settings" data-toggle="modal" data-target="#modal-modalDetails" class="no-select-link"><i class="fa fa-envelope" aria-hidden="true"></i> <span class="sideMenuSize">Notifications</span></a></li>
                    <li class="cursorPointer"><a onclick="sendOffPHP('."'modalDetails'".', '."'/php/modalDeleteAccount.php'".')" title="Delete your account" data-toggle="modal" data-target="#modal-modalDetails" class="no-select-link"><i class="fa fa-user-times" aria-hidden="true"></i> <span class="sideMenuSize">Delete Account</span></a></li>              
                </ul>
            </div>

            <div id="page-content-wrapper">
                <div class="container-fluid">';
                    include('../legendBar.php');
                    /*
                    $stmt = $db->prepare("SELECT FKgroup FROM client WHERE clientID = ?");
                    $stmt->execute(array($_SESSION['userID']));
                    if ($stmt->rowCount() > 0){
                        $stmt = $stmt->fetch(PDO::FETCH_ASSOC); 
                        echo '<br><div class="panel-group">
                            <div class="panel panel-default">
                                <ul class="list-group">                                        
                                    <li class="list-group-item cursorPointer testing" style="background-color:#312A25; color:white" <button type="button" class="table-button" onclick="getOrganisationModal('.$stmt['FKgroup'].')" data-toggle="modal" data-target="#modal-modalDetails">Your organisation</button></li>
                                </ul>
                            </div>
                        </div><br>';
                    }
                    */

                    echo' <div class="testing table-padding"><b>Your Listings<b><br>';
                            
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

                    $availablePercent = GetPercentage($listingCount,$availableCount);
                    $wantedPercent = GetPercentage($listingCount,$wantedCount);
                    $finishedPercent = GetPercentage($listingCount,$finishedCount);
                    $totalPercent = ($availablePercent + $wantedPercent + $finishedPercent);
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

                    echo '<div class="panel-group">
                        <div class="panel panel-default">';

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
                                                                   
                            echo '</div>
                            <h4 class="panel-title">
                                Available: <span class="badge dontHideBadge">'.$availableCount.'</span> | Wanted: <span class="badge dontHideBadge">'.$wantedCount.'</span> | Finished: <span class="badge dontHideBadge">'.$finishedCount.'</span>
                            </h4>';

                             echo '<div class="panel-heading" unselectable="on" onselectstart="return false;" onmousedown="return false;" data-toggle="collapse" href="#collapseRequests">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-parent="#panel-group">Your requests</a>
                                </h4>
                            </div>
                            <div id="collapseRequests" class="panel-collapse collapse">
                                <ul class="list-group scrollable-menu scrollbar">';                                        
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
                                        echo '<button type="button" class="table-button" onclick="getItemModal('.$row['itemID'].')" data-toggle="modal" data-target="#modal-modalDetails"><span class="dontHideBadge" style="display: flex;"><span class="fa fa-shopping-cart dontHideBadge"></span> '.$row['name'].'</span></button></li>';
                                    }
                                }
                                echo'</ul>
                            </div>

                            <div class="panel-heading" unselectable="on" onselectstart="return false;" onmousedown="return false;" data-toggle="collapse" href="#collapseSupplying" onclick="changeNotificationCollase()">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-parent="#panel-group">Your supplying</a>
                                </h4>
                            </div>
                            <div id="collapseSupplying" class="panel-collapse collapse">
                                <ul class="list-group scrollable-menu scrollbar">';                                        
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
                                        echo '<button type="button" class="table-button" onclick="getItemModal('.$row['itemID'].')" data-toggle="modal" data-target="#modal-modalDetails"><span class="dontHideBadge" style="display: flex;"><span class="glyphicon glyphicon-gift dontHideBadge"></span> '.$row['name'].'</span></button></li>';
                                    }
                                }
                                echo'</ul>
                            </div>';
                            } else {
                                if ($availableCount == 0 & $wantedCount == 0 & $finishedCount == 0){
                                    echo '<div class="progress-bar progress-bar-info" role="progressbar" style="width:100%">
                                        You have no listings
                                    </div>';
                                }
                            }
                               
                        echo '</div><br>
                    </div>
                </div>
                <div id="notificationTable" class="testing table-padding">';
                    include("../notificationTable.php");
                echo '</div>
            </div>
        </div>';
    } else {
        echo '<script>location.reload();</script>';
    }

    function GetPercentage($total, $number) {
        if ( $total > 0 ) {
            return round($number / ($total / 100),2);
        } else {
            return 0;
        }
    }
?>