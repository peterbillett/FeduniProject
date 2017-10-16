<?php
    include("../config.php");
    include("../updateItemFinished.php");
    session_start();

    //Count all item status
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

    //Create the section for the auto typing baner. Storing the values for available and unavailable in spans to be grabbed with javascript via their id
    echo '<div class="panel-group testing">
        <div class="panel panel-default">
            <p id="homepageTypist" class="typist">&nbsp;</p>
            <span style="display:none" id="hpAvailableID">'.$availableCount.'</span>
            <span style="display:none" id="hpFinishedID">'.$finishedCount.'</span>
        </div>
    </div>';

    //Get up to 5 items that are available (ending earliest)
    $firstLoop = true;
    $stmtItem = $db->prepare('SELECT itemID, name, description, endtime, organisation, category FROM item WHERE endtime > NOW() ORDER BY endtime ASC LIMIT 5');
    $stmtItem->execute();
    $itemResult = $stmtItem->fetchAll(PDO::FETCH_ASSOC);

    //If there are items returned then create a carousel for them
    if($stmtItem->rowCount() > 0) { 
        echo '<div id="text-carousel" class="carousel slide" data-ride="carousel">
    	    <!-- Slides -->
    	    <div class="row">
                <div class="carousel-inner">';
                    foreach ($itemResult as $row) { //For each item
                        echo '<div id="carouselItemID'.$row['itemID'].'" class="item';
                        if ($firstLoop == true) { //Set the first item as active (so it is displayed)
                            $firstLoop = false;
                            echo ' active">';
                        } else {
                            echo '">';
                        }
                        //make the item a button to open the items modal
    	                echo '<button class="no-button no-select-link" onclick="getItemModal('.$row['itemID'].')" data-toggle="modal" data-target="#modal-modalDetails" data-keyboard="true">
                            <span class="modalTitle">'; //Print the type of item
                            if ($row['category'] == "Request") {
                                echo '[Request] ';
                            } else {
                                echo '[Supplying] ';
                            }
                            echo $row['name'].'</span>'; //Print the items name
                			echo '<br>End date/time: '.$row['endtime'].'<br> '; //Print the end date/time of the item

                            //Get -> Print the items organsation name
                            $stmtOrg = $db->prepare("SELECT organisation.name FROM organisation WHERE groupID=?");
                            $stmtOrg->execute(array($row['organisation']));
                            $organisationResult = $stmtOrg->fetch(PDO::FETCH_ASSOC);
                            if ($stmtOrg->rowCount() == 1) {
                                echo 'Organisation: '.$organisationResult['name'];
                            }
                            echo '</br></button>
                        </div>';
                    }   
                    //Add the controls to go left and right with the carousel
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

    //If the user is logged in then print a welcome message to them
    if(isset($_SESSION['userID'])) {
        $stmt = $db->prepare('SELECT clientFirstName FROM client WHERE clientID = ?');
        $stmt->execute(array($_SESSION['userID']));
        $clientName = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<div style="text-align: center;"><b style="padding: 10px; font-size: 30px;">Hi '.$clientName['clientFirstName'].',</b></div>';
    }

    //Print the welcome message from the database
    echo '<div id="indexNews" style="padding: 10px; text-align: center;">';
        $stmt = $db->query('SELECT title, news FROM homepageNews ORDER BY newsDate DESC LIMIT 1');
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<b style="font-size: 30px;">'.$row['title'].'</b>';
            echo '<p>'.$row['news'].'</p>';
        }
    echo '</div>';
?>