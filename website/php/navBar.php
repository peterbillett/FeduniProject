<?php
	session_start();
	if (isset($_SESSION['userID'])){
		include("config.php");

		echo '<!-- Join Volunteer Group Modal -->
		<div class="modal" id="modal-joinVol">
		  	<div class="modal-dialog">
		    	<div class="modal-content">

		      		<div class="modal-header background-color-blue">
		      			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
		        		<span class="modalTitle">Join Volunteer Group</span>
		      		</div>

		      		<div class="modal-body testing">
		      			<label>Volunteer Organisation Name: <select id="volOrgList" class="form-control removeSelectWidth">';
							foreach($db->query('SELECT name, groupID FROM organisation ORDER BY name ASC') as $row) {
								echo '<option value="'.$row['groupID'].'">'.$row['name'].'</option>';
							}
		      			echo '</select></label>
					  	<br>
					  	<span id="volOrgJoinMessage"></span>
                    </div>

			      	<div class="modal-footer testing">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<a class="btn btn-primary" href="#modal-createVol" data-toggle="modal" data-dismiss="modal">Create New Volunteer Group</a>
			        	<button class="btn btn-primary" onclick="joinVolunteerGroup()">Submit</button>
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
		      		</div>

			      	<div class="modal-body testing">
						<label>Volunteer Organisation Name:<br><input type="text" class="form-control" id="volOrgName" required placeholder="Enter a valid name"></label>
						<br><label>Information: <br><input type="text" class="form-control" id="volOrgInformation" required placeholder="Enter organisation info"></label>
					  	<br>
					  	<span id="volOrgCreateMessage"></span>
			      	</div>

			      	<div class="modal-footer testing">
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        	<a class="btn btn-primary" href="#modal-joinVol" data-toggle="modal" data-dismiss="modal">Cancel</a>
			        	<button class="btn btn-primary" onclick="createVolunteerGroup()">Submit</button>
			      	</div>

		    	</div>
		  	</div>
		</div>';
	}

   	echo'<div class="container-fluid">
			<div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		    </div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="no-select-link pointer" onclick="getIndexPage()"><a class="no-select-link"><span class="glyphicon glyphicon-home" title="Link to homepage"></span></a></li>
					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Volunteer Organisations<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="no-select-link pointer" onclick="getOrganisationsPage()"><a class="no-select-link">Volunteer Organisation List</a></li>';

							//Checks to see if the user is logged in (Only logged in users can create Volunteer Groups)
							if (isset($_SESSION['userID'])){
								$stmt = $db->prepare("SELECT FKgroup FROM client WHERE clientID = ?");
						   		$stmt->execute(array($_SESSION['userID']));
						   		$stmt = $stmt->fetch(PDO::FETCH_ASSOC); 
						      	if ($stmt['FKgroup'] != NULL){
						      		echo '<li id="volOrgMenu" class="no-select-link pointer" onclick="getOrganisationModal('.$stmt['FKgroup'].')" data-toggle="modal" data-target="#modal-modalDetails"><a class="no-select-link">Your Volunteer Group</a></li>';
						      	} else {
						      		echo '<li id="volOrgMenu" class="no-select-link pointer" data-toggle="modal" data-target="#modal-joinVol"><a class="no-select-link">Create/Join Volunteer Group</a></li>';
						      	}
						    }
							echo '</ul>
						</li>';
							
					echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Listings<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="no-select-link pointer" onclick="getListingsPage('."'php/itemGetAll.php'".')"><a class="no-select-link">All</a></li>
							<li class="no-select-link pointer" onclick="getListingsPage('."'php/itemGetAll.php?type=Request'".')"><a class="no-select-link">Requesting</a></li>
							<li class="no-select-link pointer" onclick="getListingsPage('."'php/itemGetAll.php?type=Supplying'".')"><a class="no-select-link">Supplying</a></li>
						</ul>
					</li>';

					if (isset($_SESSION['userID'])){
						echo '<li class="no-select-link pointer"><a class="no-select-link" data-toggle="modal" data-target="#modal-createListing">Create Listing</a></li>';
					} else {
						echo '<li class="no-select-link pointer" onclick="loginRequiredMessage(true)" data-toggle="modal" data-target="#modal-login"><a class="no-select-link">Create listing</a></li>';
					}

					echo '<li class="no-select-link pointer" onclick="sendOffPHP('."'pageDetails'".', '."'php/pages/FAQ.php'".')"><a class="no-select-link">FAQ</a></li>';

					if (isset($_SESSION['userID'])){
						echo '<li class="dropdown pointer"><a class="dropdown-toggle" data-toggle="dropdown">Your Account<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="no-select-link pointer" onclick="getProfilePage()"><a class="no-select-link">Your Profile</a></li>
								<li class="no-select-link pointer" onclick="logout()"><a class="no-select-link">Logout</a></li>
							</ul>
						</li>

						<!-- Create Listing Modal -->
						<div class="modal fade" id="modal-createListing">
						  	<div class="modal-dialog">
						    	<div class="modal-content">

						      		<div class="modal-header background-color-blue">
						      			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
						        		<span class="modalTitle">Create Listing</span>
						      		</div>

						      		<div class="modal-body testing">
						      			
										<input type="text" class="form-control" id="createTitle" required placeholder="Enter lisiting name..."></input><br>

										<textarea type="text" class="form-control" placeholder="Enter description..." id="createDescription" rows="4" cols="30"></textarea>
										<br>
										
										<label>Tag: <select id="createTagID" class="form-control removeSelectWidth">';
										foreach($db->query('SELECT * FROM tag') as $row) {
										    echo '<option value="'.$row['tagID'].'">'.$row['name'].'</option>';
										}
										echo '</select></label>

										<label>Category: 
											<select id="createCategory" class="form-control removeSelectWidth">
												<option value="Request">Request</option>
												<option value="Supplying">Supplying</option>
											</select>
										</label>
										<br>
										
								        <div class="row">
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

								       	echo '<div id="createLinkToOrganisationToggle" class="row"';
								       	if ($stmt['FKgroup'] == NULL){
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
								    	</div>
										
										<input style="display: none" type="text" class="form-control" id="createCustomAdress" required placeholder="Enter custom address..."></input><br>

										<label>End datetime: 
							                <div class="input-group date" id="datetimepicker1">
							                    <input id="createDateTime" type="text" class="form-control">
							                    <span class="input-group-addon">
							                        <span class="glyphicon glyphicon-calendar"></span>
							                    </span>
							                </div>
										</label>

                                    </div>

							      	<div class="modal-footer testing">
							        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							        	<button id="createNewListingButton" class="btn btn-primary" onclick="createNewListing();">Submit</button>
							        	<br><span id="createListingMessage"></span>
							      	</div>

							    </div>
							</div>
						</div>';
					}
					else{
                        echo '<li class="no-select-link pointer" onclick="loginRequiredMessage(false)" data-toggle="modal" data-target="#modal-login"><a class="no-select-link">Login</a></li>

						<!-- Login Modal -->
						<div class="modal fade" id="modal-login">
						  	<div class="modal-dialog">
						    	<div class="modal-content">

						      		<div class="modal-header background-color-blue">
						      			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
						        		<span class="modalTitle">LOGIN</span>
						      		</div>

						      		<div class="modal-body testing">
										<label>Email: </label>
										<br><input type="email" class="form-control" id="loginEmail" placeholder="Enter email" required ><br />
										<br>
										<label>Password: </label>
										<br><input type="password" class="form-control" id="loginPassword" required placeholder="Enter password"><br />
									  	<br><button class="btn btn-primary" onclick="checkLoginSuccess()">Login</button>
										<br><span id="loginMessage"></span>
                                    </div>

							      	<div class="modal-footer testing">
							        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							        	<a class="btn btn-primary" href="#modal-AccountCreate" data-toggle="modal" data-dismiss="modal">Create Account</a>
							      	</div>

							    </div>
							</div>
						</div>
						  
						<!-- Create Account Modal -->
						<div class="modal fade" id="modal-AccountCreate">
						  	<div class="modal-dialog">
						    	<div class="modal-content">

						      		<div class="modal-header background-color-blue">
						        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
						        		<span class="modalTitle">Create Account</span>
						      		</div>

							      	<div class="modal-body testing">
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
							      	</div>

							      	<div class="modal-footer testing">
							        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							        	<a class="btn btn-primary" href="#modal-login" data-toggle="modal" data-dismiss="modal">Back to login</a>
							      	</div>

						    	</div>
						  	</div>
						</div>';
					}
					
				echo '</ul>
			</div>
		</div>
		<div id="newItemDetails"></div>
		';
?>