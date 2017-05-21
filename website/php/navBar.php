<?php
	session_start();

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
					<li><a href="index.html"><span class="glyphicon glyphicon-home"></span></p></a></li>
					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Volunteer Organisations<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="allOrgs.html">Volunteer Organisation List</a></li>';
	//First echo ends here
							//Checks to see if the user is logged in (Only logged in users can create Volunteer Groups
							if (isset($_SESSION['userID'])){
								//Makes 'Create a Volunteer Group' option visiable
								echo '<li><a href="createVolOrgAccount.html">Create a Volunteer Group</a></li>';
							}
							
	echo '				</ul>
					</li>
					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Listings<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="allListings.html">All</a></li>
							<li><a href="allRequests.html">Requests</a></li>
							<li><a href="allSupplying.html">Supplying</a></li>
						</ul>
					</li>
					<li><a href="createListing.html">Create listing</a></li>
					<li><a href="#">FAQ</a></li>';
					if (isset($_SESSION['userID'])){
						echo '<li><a href="./php/logout.php">Logout</a></li>';
					}
					else{
						echo '<li><a href="createAccountLogin.html">Login</a></li>';
					}
				echo '</ul>
			</div>
		</div>';
	//Second echo ends here
?>