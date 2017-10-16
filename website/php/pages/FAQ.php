<?php
	//Array of FAQ items. Each one has the section it belongs to, the title and its description.
	//To edit the FAQ just add to or remove from this array (ensure that those in the same section are sequential)
	$FAQArray = array(
		array("section" => "FAQ",
			"title" => "What is the point of this website?",
			"description" => "Welcome to Connect Me Ballarat. This is a FREE marketplace designed to help goods and services flow between volunteer organisations and other similar groups. Here, you can put goods such as food, clothing, and furniture as well as services, like gardening and cooking."),
		array("section" => "FAQ",
			"title" => "Types of Listings",
			"description" => "<p>There are 2 types of listings, these are: <p>-Request: Goods, items and/or work is being requested by the person/organisation who created the listing.</p><p>-Supplying: Goods, items and/or work that is being offered by the person/organisation who created the listing.</p><br><p>The listings fall into 3 categories:<p>-Available (Green): The listing is available and able to be claimed by anyone.</p><p>-Wanted (Yellow): The listing has been marked as wanted by another user. Currently cannot be claimed by anyone, but may return to being available if an arrangement cannot be made.</p><p>-Finished (Blue): The listing has ended and cannot be claimed by anyone.</p></p>"),
		array("section" => "HELP",
			"title" => "How to Create an Account",
			"description" => "Click on the 'Login' tab in the navigation bar at the top of the page, and then click on the 'Create Account' button. Fill out all the boxes with the information below:<p>-Email: Your current email address (eg johnsmith@gmail.com)</p><p>-Password: Your desired password – must be at least 7 characters in length</p><p>-Confirm Password: Re-enter the password exactly as before</p><p>-First Name: Your First Name</p><p>-Last Name: Your Last Name After entering this information, click on the 'Submit' button."),
		array("section" => "HELP",
			"title" => "How to Login and Logout",
			"description" => "Click on the 'Login' tab in the navigation bar at the top of the page. Enter both your email address and your password, and click the 'Login' button. If you have entered this information incorrectly, the website will prompt you to re-enter your details. To logout of the website, click the 'Your Account' tab in the navigation bar at the top of the page. When a small drop-down list appears, click the 'Logout' button. Your account will be successfully logged out and you will be taken to the home page of the website."),
		array("section" => "HELP",
			"title" => "How to Change Your Account Details",
			"description" => "In order to change your account details, you are required to be logged in., follow the 'How to Login and logout' instructions above. If you do not have an account, follow the 'How to Create an Account' instructions above. To access your account after logging in, click the 'Your Account' tab in the navigation bar at the top of the page. In the Settings menu to the left of the screen, there are options to edit your profile. Options to edit:<p>-Update Password: change your current password to another</p><p>-Leave Organisation: Leave your current organisation, un-affiliating yourself with that organisation</p><p>-Notifications: Change your current notifications</p><p>-Delete Account: Delete’s your account and removes any personal information stored on the site."),
		array("section" => "HELP",
			"title" => "How to Join an Organisation",
			"description" => "In order to join an organisation, you are required to be logged in. If you are not logged in, follow the 'How to Login and Logout' instructions above. If you do not have an account, follow the 'How to Create an Account' instructions above.<br>To join an organisation, click on the 'Your Account' tab in the navigation bar at the top of the page. Once you are on the 'Your Account' page, click 'Join Organisation' in the Settings menu on the left of the screen. A pop-up will then appear, asking you to choose an organisation to join. Once you have found the organisation you wish to join, click on the name of your chosen organisation, and then click the 'Submit' button. You will be then taken to the organisation’s page, indicating you have successfully joined that organisation."),
		array("section" => "HELP",
			"title" => "How to Leave an Organisation",
			"description" => "In order to leave your current organisation, you are required to be logged in. If you are not logged in, follow the 'How to Login and Logout' instructions above. If you do not have an account, follow the 'How to Create an Account' instructions above.<br>To leave an organisation, click the 'Your Account' tab in the navigation bar at the top of the page. Once on the page, click the 'Leave Organisation' button in the Settings menu on the left of the screen. A pop-up will appear, asking you to confirm if you want to leave the organisation. To confirm, click the 'Yes, Leave Organisation' button. A confirmation message will appear, and you will be directed to the 'Your Account' page."),
		array("section" => "HELP",
			"title" => "How to Receive and Change Notifications",
			"description" => "In order to receive and change notifications, you are required to be logged in. If you are not logged in, follow the 'How to Login and Logout' instructions above. If you do not have an account, follow the 'How to Create an Account' instructions above.<br>To receive and change notifications, click the 'Your Account' tab in the Navigation bar at the top of the page. A drop-down menu will appear with 2 options, click the 'Your Profile' button. At the right of the page, in the settings menu, click the 'Notifications' button. A pop-up will appear, enabling you to add and remove which tags you receive notifications for. Once you have completed choosing your notifications, click the 'Close' button to finish."),
		array("section" => "HELP",
			"title" => "How to create an organisation",
			"description" => "In order to create an organisation, you are required to be logged in. If you are not logged in, follow the 'How to Login and Logout' instructions above. If you do not have an account, follow the 'How to Create an Account' instructions above.<br>To create an organisation, click the 'Volunteer Organisations' tab in the Navigation Bar at the top of the page. A drop-down menu will appear, with 2 options shown. Click 'Create/Join Volunteer Group'. A pop-up will appear, giving the option to either join a currently existing volunteer group, or create a new one. Click the 'Create New Volunteer Group' button, after which you will be prompted to enter your new organisations name and information. Once you have entered all fields, click the 'Submit' button. To view your new organisation, click the 'Volunteer Organisations' tab again, and in the drop-down menu, click the 'Your Volunteer Group' button."),
		array("section" => "HELP",
			"title" => "How to edit your organisation’s details",
			"description" => "In order to edit your organisations details, you are required to be logged in. If you are not logged in, follow the 'How to Login and Logout' instructions above. If you do not have an account, follow the 'How to Create an Account' instructions above.<br>You must also hold administrative privileges within your organisation to be able to edit it. To edit your organisation, click the 'Volunteer Organisations' tab in the Navigation Bar at the top of the page. A drop-down menu will appear, with 2 options shown. click the 'Your Volunteer Group' button. A pop-up will appear, showing your organisations details and location. Below the Name of the organisation, there is an 'Edit' button. Click that button, and another pop-up will appear, enabling you to change several details:</p><p>-Change the Name of the organisation</p><p>-Change the Description of the organisation</p><p>-Update current news about the organisation</p><p>-Delete the organisation from the website</p><p>Once completing the updates, click the 'Submit Changes' button in the middle of the pop-up. To cancel any changes you have made, click the 'Cancel Edit' button at the bottom of the pop-up."),
		array("section" => "HELP",
			"title" => "How to Create a Listing",
			"description" => "In order to create a listing, you are required to be logged in. If you are not logged in, follow the 'How to Login and Logout' instructions above. If you do not have an account, follow the 'How to Create an Account' instructions above.<br>To create a listing, click the 'Create Listing' button in the Navigation bar at the top of the page. A pop-up menu will appear, with several fields to be filled out. These fields are:<p>-Enter Listing Name: Enter the name for the listing</p><p>-Enter Description: Enter any relevant information relating to the description</p><p>-Tag: Choose a relevant tag for the listing (e.g. if the item is sausages, choose Food as the tag)</p><p>-Category: Choose whether the listing is a Supply-type or a Request-type listing</p><p>-Perishable: Choose whether this item has an expiry date or not</p><p>-Link to Organisation: Choose whether your organisation’s name will appear on the listing or not</p><p>-Show Location: Choose whether the item will show your organisation’s location, a location of your choosing or do not show on the map at all</p><p>-End Datetime: Give the listing a date and time, on which it will expire</p>Once all relevant details are entered, click the 'Submit' button to submit the listing. Once submitted, you will be re-directed to the listing’s page, showing that the listing has been successfully created."),
		array("section" => "HELP",
			"title" => "How to Edit a Listing and Add an Image",
			"description" => "In order to edit a listing, you are required to be logged in. If you are not logged in, follow the 'How to Login and Logout' instructions above. If you do not have an account, follow the 'How to Create an Account' instructions above.<br>To edit your listing, click the 'Your Account' tab in the navigation bar at the top of the page, after which a drop-down menu will appear. Click the 'Your Profile' button, which will take you to your profile page. From there, find the listing you wish to edit in the 'Your Listings' section in the middle of the page. If it is a Request-type listing, it will be under the 'Your Requests' section, and if it is a Supply-type listing, it will be in the 'Your Supplying' section. Once the listing to be edited has been found, click on it, which will then show a pop-up. To edit, click the 'Edit' button, located to the right of the image and above the listing’s current status. From here you can edit:</p><p>-Listing Name</p><p>-Listing Description</p><p>-Category (either Supply or Request)</p><p>-End Datetime</p><p>-Upload Image: To upload an image, click the 'Browse' button, which will then re-direct to your computer, where you can locate and upload an image. Once located, click the 'Upload Image' button to upload it. A message will appear below the 'Upload Image' button, indicating whether the picture was successfully uploaded or not.</p>Once all desired details have been changed, click the 'Submit Changes' button in the middle of the pop-up. You will then be directed to the listing itself, showing all details, including those that have been changed."),
		array("section" => "HELP",
			"title" => "How to Accept a Listing",
			"description" => "In order to accept a listing, you are required to be logged in. If you are not logged in, follow the 'How to Login and Logout' instructions above. If you do not have an account, follow the 'How to Create an Account' instructions above.<br>To accept a listing, first find a listing on the 'Listings' page that you are interested in. Then, click on that listing, which will bring up a pop-up. Click the 'Set You Want It' button, which will change the status from 'Available' to 'Wanted'. Then, contact the supplier in any of the methods they have supplied (email is always available).")
	);
	
	$section = "";
	foreach ($FAQArray as $i => $row) {
		if ($row['section'] != $section) { //For new sections print the sections name and seperate it from the prior section
			echo '<br><h2 class="testing" style="color:black">'.$row['section'].'</h2>';
			$section = $row['section'];
		} //Print a collapse for each FAQ item. The header is the title. Clicking it expands the panel to show the description
		echo '<div class="panel-group">
	        <div class="panel panel-default">
	        	<div class="panel-heading" unselectable="on" onselectstart="return false;" onmousedown="return false;" data-toggle="collapse" href="#collapseFAQ'.$i.'">
	                <h4 class="panel-title">
	                    <a class="accordion-toggle" data-parent="#panel-group">'.$row['title'].'</a>
	                </h4>
	            </div>
		        <div id="collapseFAQ'.$i.'" class="panel-collapse collapse">
	                <ul class="list-group scrollable-menu scrollbar">
	                	<li class="list-group-item">'.$row['description'].'</li>
	                </ul>
				</div>
			</div>
		</div>';
	}
	echo '<br>';

?>