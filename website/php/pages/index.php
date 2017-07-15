<?php
    include("../config.php");
    session_start();
    $firstLoop = true;

    $stmtItem = $db->prepare('SELECT itemID, name, description, endtime, organisation FROM item WHERE endtime > NOW() ORDER BY endtime ASC LIMIT 5');
    $stmtItem->execute();
    $itemResult = $stmtItem->fetchAll(PDO::FETCH_ASSOC);

    echo '<div id="text-carousel" class="carousel slide" data-ride="carousel">
	    <!-- Slides -->
	    <div class="row">
            <div class="carousel-inner">';
                foreach ($itemResult as $row) {
                    if ($firstLoop == true) {
                        $firstLoop = false;
                        echo '<div class="item active">';
                    } else {
                        echo '<div class="item">';
                    }
	                echo '<button type="button" class="no-button no-select-link" onclick="getItemModal('.$row['itemID'].')" data-toggle="modal" data-target="#modal-modalDetails">
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

	</div>

    <script>
        $("#text-carousel").swiperight(function() {  
            $(this).carousel("prev");  
        });  
        $("#text-carousel").swipeleft(function() {  
            $(this).carousel("next");  
        });
    </script>';
?>