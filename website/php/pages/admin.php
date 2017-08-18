<?php
	session_start();
	if (isset($_SESSION['userID'])){
		if ($_SESSION['accountType'] === "3"){

			include("../config.php");
			$allUsers = $db->prepare('SELECT clientID, clientFirstName, clientLastName, accountType, email, FKgroup, organisation.name orgName FROM client LEFT JOIN organisation ON client.FKgroup = organisation.groupID ORDER BY clientID DESC');
            $allUsers->execute();
            $allUsers = $allUsers->fetchAll(PDO::FETCH_ASSOC);

            $allItems = $db->prepare('SELECT FKclient, count(*) as NUM FROM item GROUP BY FKclient');
            $allItems->execute();
            $allItems = $allItems->fetchAll(PDO::FETCH_ASSOC);
            echo '<div class="panel-group">
	    		<div class="panel panel-default">
		            <div class="panel-heading" unselectable="on" onselectstart="return false;" onmousedown="return false;" data-toggle="collapse" href="#collapseUsers">
		                <h4 class="panel-title accordion-toggle testing" data-parent="#panel-group"><b>Users</b></h4>
		            </div>
		            <div id="collapseUsers" class="panel-collapse collapse">
		                <ul class="list-group scrollable-menu scrollbar">';                                        
		                foreach ($allUsers as $row) {
		                    echo '<li class="list-group-item primary pointer" value="'.$row['clientID'].'" onclick="getUserModal('.$row['clientID'].')" data-toggle="modal" data-target="#modal-modalDetails">[';
		                    	switch ($row['accountType']) {
		                    		case "1":
		                                echo 'N';
		                                break;
		                            case "2":
		                                echo 'O';
		                                break;
		                            case "3":
		                                echo 'A';
		                                break;
		                    	}
		                    	$orgName = "NO ORG";
		                    	if ($row['orgName'] != "") $orgName = $row['orgName'];
							echo '] '.$row['email'].' ('.$row['clientFirstName'].' '.$row['clientLastName'].') - '.$orgName.' - (ITEMS: ';
								$itemCount = 0;
								foreach ($allItems as $itemrow) {
									if ($row['clientID'] === $itemrow['FKclient']) {
										$itemCount = $itemrow['NUM'];
									}
								}
							echo $itemCount.')</li>';
		                }
		                echo'</ul>
		            </div>';

		            $allOrgs = $db->prepare('SELECT * FROM organisation ORDER BY groupID DESC');
		            $allOrgs->execute();
		            $allOrgs = $allOrgs->fetchAll(PDO::FETCH_ASSOC);

		            $allOrgUsers = $db->prepare('SELECT FKgroup, count(*) as NUM FROM client GROUP BY FKgroup');
		            $allOrgUsers->execute();
		            $allOrgUsers = $allOrgUsers->fetchAll(PDO::FETCH_ASSOC);

		           	echo '<div class="panel-heading" unselectable="on" onselectstart="return false;" onmousedown="return false;" data-toggle="collapse" href="#collapseTags">
		                <h4 class="panel-title accordion-toggle testing" data-parent="#panel-group"><b>Organisations</b></h4>
		            </div>
		            <div id="collapseTags" class="panel-collapse collapse">
		                <ul class="list-group scrollable-menu scrollbar">';                                        
		                foreach ($allOrgs as $row) {
		                	$orgMembers = 0;
								foreach ($allOrgUsers as $memberrow) {
									if ($row['groupID'] === $memberrow['FKgroup']) {
										$orgMembers = $memberrow['NUM'];
									}
								}
		                    echo '<li class="list-group-item primary" value="'.$row['groupID'].'">';
		                    echo '<button type="button" class="table-button" onclick="getOrganisationModal('.$row['groupID'].')" data-toggle="modal" data-target="#modal-modalDetails">'.$row['name'].' (MEMBERS: '.$orgMembers.')</button></li>';
		                }
		                echo'</ul>
		            </div>
	            
		            <div class="panel-heading" unselectable="on" onselectstart="return false;" onmousedown="return false;" data-toggle="collapse" href="#collapseHomepageUpdate">
		                <h4 class="panel-title accordion-toggle testing" data-parent="#panel-group"><b>Update homepage welcome message</b></h4>
		            </div>
		            <div id="collapseHomepageUpdate" class="panel-collapse collapse">
						<input type="text" class="form-control" id="hpTitle" required placeholder="Enter message title">
						<textarea type="text" class="form-control" id="hpDescription" required placeholder="Enter message description" rows="4" cols="30" autocomplete="off"></textarea><br>
						<div class="testing">
							<button id="createNewHomepageMessage" class="btn btn-primary" onclick="createNewHomepageMessage();">Submit</button><br>
					  		<span id="hpCreateMessage"></span>
					  	</div>
			      	</div>
		      	</div>
            </div>';
		} 
	} 
?>