<?php
	session_start();
	include("config.php");

	if (isset($_SESSION['userID'])){
		//if the user is logged in then create the join/create volunteer modals 
		echo '<!-- Join Volunteer Group Modal -->
		<div class="modal" id="modal-joinVol">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<div class="modal-header background-color-blue">
		      			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
		        		<span class="modalTitle">Join Volunteer Group</span>
		      		</div>';

		      		//For each group add them as an option to a select, displaying there name
		      		echo '<div class="modal-body testing">
		      			<label>Volunteer Organisation Name: <select id="volOrgList" class="form-control removeSelectWidth">';
							foreach($db->query('SELECT name, groupID FROM organisation ORDER BY name ASC') as $row) {
								echo '<option value="'.$row['groupID'].'">'.$row['name'].'</option>';
							}
		      			echo '</select></label>
					  	<br>
					  	<span id="volOrgJoinMessage"></span>
                    </div>';

                    //Add buttons to close the modal, create a new volunteer group or join the one selected
			      	echo '<div class="modal-footer testing">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<a class="btn btn-primary" href="#modal-createVol" data-toggle="modal" data-dismiss="modal">Create New Volunteer Group</a>
			        	<button class="btn btn-primary" onclick="joinVolunteerGroup()">Join</button>
			      	</div>

			    </div>
			</div>
		</div>
		  
		<!-- Create A New Volunteer Group Modal -->
		<div class="modal" id="modal-createVol">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<div class="modal-header background-color-blue">
		        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
		        		<span class="modalTitle">Create New Volunteer Group</span>
		      		</div>';

		      		//Create text fields to get the new org name, info and address
			      	echo '<div class="modal-body testing">
						<label>Volunteer Organisation Name:<br><input type="text" class="form-control" id="volOrgName" required placeholder="Enter a valid name"></label>
						<br><label>Information: <br><input type="text" class="form-control" id="volOrgInformation" required placeholder="Enter organisation info"></label>
					  	<br><input type="text" class="form-control" id="createCustomAdressOrg" required placeholder="Enter address..."></input><br>
					  	<span id="volOrgCreateMessage"></span>
			      	</div>';

			      	//Add buttons to close the modal, cancel creation or create org
			      	echo '<div class="modal-footer testing">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close window</button>
			        	<a class="btn btn-primary" href="#modal-joinVol" data-toggle="modal" data-dismiss="modal">Cancel</a>
			        	<button class="btn btn-primary" onclick="createVolunteerGroup()">Create organisation</button>
			      	</div>

		    	</div>
		  	</div>
		</div>';
	}

	//Create the nav bar
   	echo'<div class="container-fluid">';
   		//Used for mobile site to show menu icon (to expand the menu from)
		echo '<div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	    </div>';
	    //Create the menu (with the collapse class to make it shrink to fit mobile sites)
		echo '<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">';
				echo '<li class="no-select-link pointer" onclick="getIndexPage()"><a class="no-select-link"><span class="glyphicon glyphicon-home" title="Link to homepage"></span></a><span class="hideBadge">&middot;</span></li>';
				//Volunteer organisation dropdown, always shows link to all organisations
				echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Volunteer Organisations<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class="no-select-link pointer" onclick="getOrganisationsPage()"><a class="no-select-link">Volunteer Organisation List</a></li>';

						//Checks to see if the user is logged in (Only logged in users can create Volunteer Groups)
						if (isset($_SESSION['userID'])){
							$stmt = $db->prepare("SELECT FKgroup FROM client WHERE clientID = ?");
					   		$stmt->execute(array($_SESSION['userID']));
					   		$stmt = $stmt->fetch(PDO::FETCH_ASSOC); 
					   		//If the user is in an organisation then show link to their organisation modal, else show link to the create/join organisation modal
					      	if ($stmt['FKgroup'] != NULL){
					      		echo '<li id="volOrgMenu" class="no-select-link pointer"><a onclick="getOrganisationModal('.$stmt['FKgroup'].')" data-toggle="modal" data-target="#modal-modalDetails" class="no-select-link">Your Volunteer Group</a></li>';
					      	} else {
					      		echo '<li id="volOrgMenu" class="no-select-link pointer"><a data-toggle="modal" data-target="#modal-joinVol" class="no-select-link">Create/Join Volunteer Group</a></li>';
					      	}
					    }
					echo '</ul>
				<span class="hideBadge">&middot;</span></li>';
				
				//Create drop down for listings, shows links to all items, request items and supplying items
				echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Listings<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class="no-select-link pointer" onclick="getListingsPage(null)"><a class="no-select-link">All</a></li>
						<li class="no-select-link pointer" onclick="getListingsPage('."'Request'".')"><a class="no-select-link">Requesting</a></li>
						<li class="no-select-link pointer" onclick="getListingsPage('."'Supplying'".')"><a class="no-select-link">Supplying</a></li>
					</ul>
				<span class="hideBadge">&middot;</span></li>';

				//if the user is logged in then link to the create listing modal else link to the login modal
				if (isset($_SESSION['userID'])){
					echo '<li class="no-select-link pointer"><a class="no-select-link" data-toggle="modal" data-target="#modal-createListing">Create Listing</a><span class="hideBadge">&middot;</span></li>';
				} else {
					echo '<li class="no-select-link pointer" onclick="loginRequiredMessage(true)" data-toggle="modal" data-target="#modal-login"><a class="no-select-link">Create listing</a><span class="hideBadge">&middot;</span></li>';
				}
				
				//If the user is logged in then create to their profile page
				if (isset($_SESSION['userID'])){
					$loginModal = false;
					echo '<li class="dropdown pointer"><a class="dropdown-toggle" data-toggle="dropdown">Your Account<span class="caret"></span></a>
						<ul class="dropdown-menu">';
							//If they are an admin then also show link to the admin page
							if ($_SESSION['accountType'] === "3"){
								echo '<li class="no-select-link pointer" onclick="sendOffPHP('."'pageDetails', 'php/pages/admin.php'".')"><a class="no-select-link">Admin Page</a></li>';
							}
							echo '<li class="no-select-link pointer" onclick="getProfilePage()"><a class="no-select-link">Your Profile</a></li>
							<li class="no-select-link pointer" onclick="logout()"><a class="no-select-link">Logout</a></li>
						</ul>
					<span class="hideBadge">&middot;</span></li>';
				}
				else{ //Else show link to login/create account modal
                    echo '<li class="no-select-link pointer" onclick="loginRequiredMessage(false)" data-toggle="modal" data-target="#modal-login"><a class="no-select-link">Login</a><span class="hideBadge">&middot;</span></li>';
                    $loginModal = true;
				}

				//Create link to the FAQ page
				echo '<li class="no-select-link pointer" onclick="sendOffPHP('."'pageDetails'".', '."'php/pages/FAQ.php'".')"><a class="no-select-link">About</a></li>';
				
			echo '</ul>
		</div>
	</div>

	<div id="newItemDetails"></div>';

	//If the user is logged in then add the item creation modal
	if (isset($_SESSION['userID'])){
		echo '<!-- Create Listing Modal -->
		<div class="modal fade" id="modal-createListing">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<div class="modal-header background-color-blue">
		      			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
		        		<span class="modalTitle">Create Listing</span>
		      		</div>

		      		<div class="modal-body testing">';

		      			//Add input for the items name that counts the number of characters
						echo '<div><input type="text" class="form-control" style="display: inline-block; width: 90%;" id="createTitle" required placeholder="Enter listing name..."></input>
						<div id="titleCharLimit" style="display: inline-block; padding: 5px;">250</div></div>
						<br>';

						//Add input for the items description that counts the number of characters
						echo '<div><textarea type="text" class="form-control" style="display: inline-block; width: 90%;" placeholder="Enter description..." id="createDescription" rows="4" cols="30"></textarea>
						<div id="descCharLimit" style="display: inline-block; padding: 5px;">500</div></div>
						<br>';
						
						//Add all tags from the database into a select as options
						echo '<label>Tag: <select id="createTagID" class="form-control removeSelectWidth">';
						foreach($db->query('SELECT * FROM tag') as $row) {
						    echo '<option value="'.$row['tagID'].'">'.$row['name'].'</option>';
						}
						echo '</select></label>';

						//Add select for the category (currently: supplying and Request)
						echo '<label>Category: 
							<select id="createCategory" class="form-control removeSelectWidth">
								<option value="Request">Request</option>
								<option value="Supplying">Supplying</option>
							</select>
						</label>
						<br>';
						
						//Create perishable radio buttons
				        echo '<div class="row">
				      		This item is perishable:
				      		<div class="btn-group" data-toggle="buttons">
				       		 	<label class="btn">
				          			<input type="radio" id="createPerishableYes" name="createPerishable" value="true">Yes
				        		</label>
				        		<label class="btn active">
				          			<input type="radio" id="createPerishableNo" name="createPerishable" value="false" checked="checked">No
				        		</label>
					      	</div>
				    	</div>';

				    	//Option to link item to organisation
				       	echo '<div id="createLinkToOrganisationToggle" class="row"';
				       	if ($stmt['FKgroup'] == NULL) { //if the user is not in an org then hide the this option
			      			echo ' style="display:none"';
			      		}
				       	echo '>
				      		Link to your organisation:
				      		<div class="btn-group" data-toggle="buttons">
				        		<label class="btn">
				          			<input type="radio" id="createOrgLinkYes" name="createLinkToOrganisation" value="true">Yes
				        		</label>
				        		<label class="btn active">
				          			<input type="radio" id="createOrgLinkNo" name="createLinkToOrganisation" value="false" checked="checked">No
				        		</label>
					      	</div>
				    	</div>';
				    	
				    	//Create address options (org address, custom address, no address)
				    	echo '<div class="row trigger" data-toggle="buttons">
				      		Show location on map:<br>
				      		<label id="createAddressOrgToggle" class="btn"';
				       		if ($stmt['FKgroup'] == NULL){
				       		 	echo ' style="display:none"';
				       		}
			       		 	echo '>
			          			<input type="radio" id="createAddressOrg" name="createAddress" value="[Org]">Your organisations address
			        		</label>
							<label class="btn">
			          			<input type="radio" id="createAddressCustom" name="createAddress" value="[Custom]">Custom address
			        		</label>
			        		<label class="btn active">
			          			<input type="radio" id="createAddressNo" name="createAddress" value="Null" checked="checked">Don'."'".'t show map
			        		</label>
				    	</div>';
						
						//The custom address bar (hidden by default) will use google maps api to auto check address as entered
						echo '<input style="display: none" type="text" class="form-control" id="createCustomAdress" required placeholder="Enter custom address..."></input><br>';

						//Datetime picker input to select the end datetime
						echo '<label id="clickDateTimePicker1">End datetime: 
			                <div class="input-group date" id="datetimepicker1">
			                    <input id="createDateTime" readonly="true" type="text" class="form-control">
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </div>
			            </label>
                    </div>';

                    //Add buttons to close the modal and create the item
			      	echo '<div class="modal-footer testing">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			        	<button id="createNewListingButton" class="btn btn-primary" onclick="createNewListing();">Submit</button>
			        	<br><span id="createListingMessage"></span>
			      	</div>
			    </div>
			</div>
		</div>';
	}

	//If the login modal is needed then create the login/create account modal
	if ($loginModal == true) {
		echo '<!-- Login Modal -->
		<div class="modal" id="modal-login">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<div class="modal-header background-color-blue">
		      			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
		        		<span class="modalTitle">LOGIN</span>
		      		</div>';

		      		//Add email and password text inputs
		      		//Add Login button
		      		echo '<div class="modal-body testing">
						<label>Email: </label>
						<br><input type="email" class="form-control" id="loginEmail" placeholder="Enter email" required ><br />
						<br>
						<label>Password: </label>
						<br><input type="password" class="form-control" id="loginPassword" required placeholder="Enter password"><br />
					  	<br><button class="btn btn-primary" onclick="checkLoginSuccess()">Login</button>
						<br><span id="loginMessage"></span>
	                </div>';

	                //Add buttons to close and create new account
			      	echo '<div class="modal-footer testing">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<a class="btn btn-primary" href="#modal-AccountCreate" data-toggle="modal" data-dismiss="modal">Create Account</a>
			      	</div>

			    </div>
			</div>
		</div>
		  
		<!-- Create Account Modal -->
		<div class="modal" id="modal-AccountCreate">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<div class="modal-header background-color-blue">
		        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
		        		<span class="modalTitle">Create Account</span>
		      		</div>';

		      		//Add input fields for their email, password, confirm password, first name and last name
		      		//Add button to create account 
			      	echo '<div class="modal-body testing">
						<label>Email</label>
						<br><input type="email" class="form-control" id="newEmail" required placeholder="Enter a valid email address"><br/>
						<br>
						<label>Password</label>
						<br><input type="password" class="form-control" id="newPassword" required placeholder="Enter password"><br/>
						<br>
						<label>Confirm Password</label>
						<br><input type="password" class="form-control" id="newConfirm" required placeholder="Re-enter password"><br/>
						<br>
						<label>First name</label>
						<br><input type="text" class="form-control" id="newFirstName" required placeholder="Enter your first name"><br/>
						<br>
						<label>Last name</label>
						<br><input type="text" class="form-control" id="newLastName" required placeholder="Enter your last name"><br/>
						<br><button class="btn btn-primary" onclick="checkAccountCreationSuccess()">Submit</button>
					  	<br><span id="accountCreationMessage"></span>
			      	</div>';

			      	//Add buttons to close modal and go back the login modal
			      	echo '<div class="modal-footer testing">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<a class="btn btn-primary" href="#modal-login" data-toggle="modal" data-dismiss="modal">Back to login</a>
			      	</div>

		    	</div>
		  	</div>
		</div>';
	}
?>