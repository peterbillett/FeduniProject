<?php
	//This page is for the admin to view all user accounts, organisations, items and to edit these. It is also for changing the welcome message
	//Check that the user is logged in and the account type is set to admin
	session_start();
	if (isset($_SESSION['userID'])){
		if ($_SESSION['accountType'] === "3"){

			include("../config.php");
			//Get each of users id, name, account type, email and organisation ID (if not null then also that organisations name)
			$allUsers = $db->prepare('SELECT clientID, clientFirstName, clientLastName, accountType, email, FKgroup, organisation.name orgName FROM client LEFT JOIN organisation ON client.FKgroup = organisation.groupID ORDER BY clientID DESC');
            $allUsers->execute();
            $allUsers = $allUsers->fetchAll(PDO::FETCH_ASSOC);

            //Count the number of items each user has
            $allItems = $db->prepare('SELECT FKclient, count(*) as NUM FROM item GROUP BY FKclient');
            $allItems->execute();
            $allItems = $allItems->fetchAll(PDO::FETCH_ASSOC);

            //Create a collapse to list all of the users in
            echo '<div class="panel-group">
	    		<div class="panel panel-default">
		            <div class="panel-heading" unselectable="on" onselectstart="return false;" onmousedown="return false;" data-toggle="collapse" href="#collapseUsers">
		                <h4 class="panel-title accordion-toggle testing" data-parent="#panel-group"><b>Users</b></h4>
		            </div>
		            <div id="collapseUsers" class="panel-collapse collapse">
		                <ul class="list-group scrollable-menu scrollbar">';  //Scrollable and limited in height to prevent the page extending too far                                      
		                foreach ($allUsers as $row) { //For each user print create a list item that can open to their admin user modal view
		                    echo '<li class="list-group-item primary pointer" value="'.$row['clientID'].'" onclick="getUserModal('.$row['clientID'].')" data-toggle="modal" data-target="#modal-modalDetails">[';
		                    	switch ($row['accountType']) { //Show what type of account the user has
		                    		case "1":
		                                echo 'N'; //Normal account
		                                break;
		                            case "2":
		                                echo 'O'; //Organisation owner
		                                break;
		                            case "3":
		                                echo 'A'; //Admin
		                                break;
		                    	}
		                    	$orgName = "NO ORG";
		                    	if ($row['orgName'] != "") $orgName = $row['orgName']; //Set organisation name if the user is in one
								echo '] '.$row['email'].' ('.$row['clientFirstName'].' '.$row['clientLastName'].') - '.$orgName.' - (ITEMS: '; //Print the users email and name
								$itemCount = 0;
								foreach ($allItems as $itemrow) {
									if ($row['clientID'] === $itemrow['FKclient']) {
										$itemCount = $itemrow['NUM'];
									}
								}
							echo $itemCount.')</li>'; //Print the users total item number
		                }
		                echo'</ul>
		            </div>';

		            //Get all of the organisations
		            $allOrgs = $db->prepare('SELECT * FROM organisation ORDER BY groupID DESC');
		            $allOrgs->execute();
		            $allOrgs = $allOrgs->fetchAll(PDO::FETCH_ASSOC);

		            //Count the number of users in the organisations
		            $allOrgUsers = $db->prepare('SELECT FKgroup, count(*) as NUM FROM client GROUP BY FKgroup');
		            $allOrgUsers->execute();
		            $allOrgUsers = $allOrgUsers->fetchAll(PDO::FETCH_ASSOC);

		            //Create a collapse to list all of the organisations in
		           	echo '<div class="panel-heading" unselectable="on" onselectstart="return false;" onmousedown="return false;" data-toggle="collapse" href="#collapseTags">
		                <h4 class="panel-title accordion-toggle testing" data-parent="#panel-group"><b>Organisations</b></h4>
		            </div>
		            <div id="collapseTags" class="panel-collapse collapse">
		                <ul class="list-group scrollable-menu scrollbar">';                                        
		                foreach ($allOrgs as $row) { //For each organisation
		                	$orgMembers = 0;
								foreach ($allOrgUsers as $memberrow) { //Count the number of users in the organisation
									if ($row['groupID'] === $memberrow['FKgroup']) {
										$orgMembers = $memberrow['NUM'];
									}
								}
		                    echo '<li class="list-group-item primary" value="'.$row['groupID'].'">'; //Print the list item for the organisation then print their name and member total (on click open the admin organisation modal)
		                    echo '<button type="button" class="table-button" onclick="getOrganisationModal('.$row['groupID'].')" data-toggle="modal" data-target="#modal-modalDetails">'.$row['name'].' (MEMBERS: '.$orgMembers.')</button></li>';
		                }

		                //Homepage welcome message update section
		                //It is a text input for the message title and a textarea for the message. Clicking the submit button sends the message off to the database
		                echo'</ul>
		            </div>
	                <h4 class="panel-title accordion-toggle testing" data-parent="#panel-group"><b>Update homepage welcome message</b></h4>
					<input type="text" class="form-control" id="hpTitle" required placeholder="Enter message title">
					<textarea type="text" class="form-control" id="hpDescription" required placeholder="Enter message description" rows="4" cols="30" autocomplete="off"></textarea><br>
					<div class="testing">
						<button id="createNewHomepageMessage" class="btn btn-primary" onclick="createNewHomepageMessage();">Submit</button><br>
				  		<span id="hpCreateMessage"></span>
				  	</div>
		      	</div>
            </div>';
		} 
	} 
?>