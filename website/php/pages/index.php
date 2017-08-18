<?php
    include("../config.php");
    include("../updateItemFinished.php");
    session_start();

    $availableCount = 0;
    $wantedCount = 0;
    $finishedCount = 0;
    $stmt = $db->prepare('SELECT finished FROM item');
    $stmt->execute();
    $listingCount = $stmt->rowCount();
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

     echo '<div class="panel-group testing">
        <div class="panel panel-default">
            <p id="homepageTypist" class="typist">WELCOME TO CONNECT ME BALLARAT</p>
            <span style="display:none" id="hpAvailableID">'.$availableCount.'</span>
            <span style="display:none" id="hpFinishedID">'.$finishedCount.'</span>';

            /*if ($listingCount > 0){
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
            } else {
                echo '<div class="progress-bar progress-bar-info" role="progressbar" style="width:100%">
                    You have no listings
                </div>';
            }                                  
                 
            echo '</div>
            <h4 class="panel-title">
                Available: <span class="badge dontHideBadge">'.$availableCount.'</span> | Wanted: <span class="badge dontHideBadge">'.$wantedCount.'</span> | Finished: <span class="badge dontHideBadge">'.$finishedCount.'</span>
            </h4>*/
        echo '</div>
    </div>';




    $firstLoop = true;
    $stmtItem = $db->prepare('SELECT itemID, name, description, endtime, organisation FROM item WHERE endtime > NOW() ORDER BY endtime ASC LIMIT 5');
    $stmtItem->execute();
    $itemResult = $stmtItem->fetchAll(PDO::FETCH_ASSOC);

    if($stmtItem->rowCount() > 0) { 
        echo '<div id="text-carousel" class="carousel slide" data-ride="carousel">
    	    <!-- Slides -->
    	    <div class="row">
                <div class="carousel-inner">';
                    foreach ($itemResult as $row) {
                        if ($firstLoop == true) {
                            $firstLoop = false;
                            echo '<div class="item active">';
                        } else {
                            echo '<div id="carouselItemID'.$row['itemID'].'" class="item">';
                        }
    	                echo '<button class="no-button no-select-link" onclick="getItemModal('.$row['itemID'].')" data-toggle="modal" data-target="#modal-modalDetails" data-keyboard="true">
                			<span class="modalTitle">'.$row['name'].'</span>';
                            if (strlen($row['description']) > 100) {
                                echo '<br>'.substr($row['description'],0,97).'...';
                            } else {
                                echo '<br>'.$row['description'].'';
                            }                            
                			echo '<br>End date/time: '.$row['endtime'].'<br> ';

                            $stmtOrg = $db->prepare("SELECT organisation.name FROM organisation WHERE groupID=?");
                            $stmtOrg->execute(array($row['organisation']));
                            $organisationResult = $stmtOrg->fetch(PDO::FETCH_ASSOC);
                            if ($stmtOrg->rowCount() == 1) {
                                echo 'Organisation: '.$organisationResult['name'];
                            }
                            echo '</br></button>
                        </div>';
                    }   
                echo '</div>
    	    </div>

        	<!--Controls -->
        	<a class="left carousel-control" href="#text-carousel" data-slide="prev">
        		<span class="glyphicon glyphicon-chevron-left"></span>
      		</a>
     		<a class="right carousel-control" href="#text-carousel" data-slide="next">
        		<span class="glyphicon glyphicon-chevron-right"></span>
      		</a>
    	</div>';
    }

    echo '<div id="indexNews">';
        $stmt = $db->query('SELECT title, news FROM homepageNews ORDER BY newsDate DESC LIMIT 1');
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<b>'.$row['title'].'</b>';
            echo '<p>'.$row['news'].'</p>';
        }
    echo '</div>';

    function GetPercentage($total, $number) {
        if ( $total > 0 ) {
            return round($number / ($total / 100),2);
        } else {
            return 0;
        }
    }
?>