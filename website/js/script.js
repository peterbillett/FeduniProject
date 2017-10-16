/*-------------TABLE OF FUNCTIONS------------------
On load
getUrlParameter
initialLoad
submitFile
getPasswordUpdater
getProfilePage
changeNotificationCollase
Date.prototype.today
Date.prototype.timeNow
getNotificationModal
autoNotification
notificationTable
setupAutoRefresh
filterNotificationTable
getIndexPage
homepageTypist
deleteAccount
organisationRemove
leaveOrganisation
updatePassword
getOrganisationsPage
OrganisationRemoveMember
OrganisationUpdateOwner
getListingsPage
getAllListings
toggleItemInfo
activateLazyLoad
searchTables
checkLoginSuccess
accountCreationError
checkAccountCreationSuccess
joinVolunteerGroup
createVolunteerGroup
validateEmail
validatePassword
validateName
logout
getUserModal
getItemModal
sendOffPHP
getOrganisationModal
isNormalInteger
createNewListing
listingsPageCallback
changeHiddenState
changeStatus
removeListing
editListing
updateItemTable
updateProfileItem
editOrganisation
viewOrganisationMembers
createNewHomepageMessage
updateOrganisationTable
loginRequiredMessage
filterArray
isInteger
createItemList
createItemTable
createOrganisationList
createOrganisationTable
createChangePageButtons
changePageVisibility
-------------------------------------------------*/


//Variables to store
var autoNotificationInterval; //Used to auto check for notification if the user is logged in
var currentListingsPage = 1; //Used for searching the tables
var totalListingsPage = 1; //Used for searching the tables
var lastlistingPage = 0; //Store the last page so if a new item is created then it will redirect to that page
var notifcationFiltered = null; //Store if the notification table is filtered and if it is then which tag
var isNotificationTableCollapsed = false; //Store if the user has collapsed the notifications table so it will remain that way when it is refreshed
var listingType = null; //Used for refreshing the items page without having to pass the filter
var toggleState = false; //Used to remember if the user has toggled the view of the tables in the item listing pages
//Default location for google maps
var defaultBounds = new google.maps.LatLngBounds(
	new google.maps.LatLng(-37.636980, 143.691664),
	new google.maps.LatLng(-37.483302, 143.976130));
var options = {
	bounds: defaultBounds
};
//Used to store the number of available and finished items to display in the homepage auto typing message bar 
var hpAvailable = "0";
var hpFinished = "0";


//On load run this
$(function () {

	//Load the navbar
	initialLoad(function(callback){

		//After the navbar has loaded check the url to see if it needs to redirect
		var activateID = getUrlParameter("confirm");
		var itemID = getUrlParameter("item");
		var orgID = getUrlParameter("organisation");
		if (itemID != null) { //If it links an item then open the listings page and load that item in the item modal
			getListingsPage(null);
			getItemModal(itemID);
			$('#modal-modalDetails').modal('show');
		} else if (orgID != null) { //if it links an organisation then open the organisations page and load that organisation in the organisation modal
			getOrganisationsPage();
			getOrganisationModal(orgID);
			$('#modal-modalDetails').modal('show');
		} else {
			if (activateID != null) { //If it links an account unlock key then call accountConfirm
				$.post("php/accountConfirm.php", { id: activateID } , function(data) {
					if (data == "success") { //If it was successful then open the login modal
						$('#modal-login').modal('show');
						$("#loginMessage").html("Your account has been confirmed<br>You can now log in");
					}
				});
			}
			getIndexPage(); //Load the homepage
		}
	});
});


//https://stackoverflow.com/questions/19491336/get-url-parameter-jquery-or-how-to-get-query-string-values-in-js 15-08-2017
//Used to get parameters from the url to redirect the user on load (eg items)
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)), sURLVariables = sPageURL.split('&'), sParameterName, i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};


//Navbar, login modal setup, create listing modal setup
function initialLoad(callback){
	$("#loadingBar").css('display', 'block'); //Show loading bar
	$.get("php/navBar.php", function(data) { //Get navbar
		$("#navBar").html(data); //Set the navbar
		autoNotification(); //Turn on auto notifications
		$('#datetimepicker1').datetimepicker({ //Activate the date time picker
			sideBySide: true,
			ignoreReadonly: true,
			minDate: moment().format("YYYY-MM-DD HH:mm"),
			defaultDate: moment().add(1,'days').format("YYYY-MM-DD HH:mm")
		});
		$('#clickDateTimePicker1').on('click touchstart', function() { //Setup touch controls for date time picker
	        $('#datetimepicker1').data("DateTimePicker").show();
	    });
		if ($('#modal-login').length) { //if the login modal exists
			$('#newPassword').pwstrength({ //Setup the password strength bar
			 	common: { usernameField: '#newEmail' },
		        ui: { showVerdictsInsideProgressBar: true }
		    });
			$("#modal-login").keypress(function(event) { //Add on key press (enter) login if the login modal is open
			    if (event.which == 13) {
			     	checkLoginSuccess();
			    } 
			});
			$("#modal-AccountCreate").keypress(function(event) { //Add on key press (enter) create account if the account create modal is open
			    if (event.which == 13) {
			     	checkAccountCreationSuccess();
			    }
			});
		}


		if ($('#modal-createVol').length) { //If the create listing modal exists
			var inputOrg = document.getElementById('createCustomAdressOrg');
			var autocompleteOrg = new google.maps.places.Autocomplete(inputOrg, options);
		}
		if ($('#modal-createListing').length) { //If the create listing modal exists
			//Setup the maps default info in the create listing modal
			var input = document.getElementById('createCustomAdress');
			var autocomplete = new google.maps.places.Autocomplete(input, options);
			//Adjust the character counter for the title in the listings modal
			$('#createTitle').keyup(function(event) {
				$("#titleCharLimit").html(250 - $('#createTitle').val().length);
				if ($('#createTitle').val().length > 250){ //If the number of characters is greater than 250 then change the colour to red, else black
					$('#titleCharLimit').css("color", "red");
				} else {
					$('#titleCharLimit').css("color", "black");
				}
			});
			//Adjust the character counter for the description in the listings modal
			$('#createDescription').keyup(function(event) {
				$('#descCharLimit').html(500 - $('#createDescription').val().length);
				if ($('#createDescription').val().length > 500){ //If the number of characters is greater than 500 then change the colour to red, else black
					$('#descCharLimit').css("color", "red");
				} else {
					$('#descCharLimit').css("color", "black");
				}
			});
			//When createAddress changes check to see if custom has been selected 
			$("input[name='createAddress']").change(function () {
				if($("input[name='createAddress']:checked").val() == "[Custom]"){ //If it has been selected then show the custom address text field
					$("#createCustomAdress").css('display', 'block');
				} else {
					$("#createCustomAdress").css('display', 'none'); //Else hide the custom address text field
				}
				});
		}
		
		$("#loadingBar").css('display', 'none'); //Hide the loading bar
		callback(false);
	});
}


//Upload a image to the passed item
function submitFile(itemID) {
	//Get file from the upload image button
	var input = document.querySelector("input[name='fileToUpload']"),
    file = input.files[0];
    //Make sure the image has been selected
    if (!file || !file.type.match(/image.*/)){
    	$("#itemEditMessage").html("No image selected.");
   		return;
   	} else if (file.size > 5242880) { //Check if the file is too large
   		$("#itemEditMessage").html("<b>Image size is over 5mb</b><p>Please choose a smaller image</p>");
   		return;
   	}
    var fd = new FormData(); //Create the formdata to send the image in
    fd.append("fileToUpload", file); //Add the image to the formdata
    $("#itemEditMessage").html("Uploading...");
    //Create the ajax request to upload the formdata
    $.ajax({
        url: "/php/imageUpload.php?id=" + itemID,
        type: "POST",
        data: fd,
        async: true,
        success: function (msg) {
            if (msg == "SUCCESS"){ //On success report success and get the image
				$("#itemEditMessage").html('<br><div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><p>Image uploaded successfuly.</p><p><button type="button" class="btn btn-success" data-dismiss="alert">Dismiss</button></p></div>');
				$('#modalImage' + itemID).attr({ src: "php/imageGet.php?id=" + itemID + "&" + new Date().getTime() });
				$('#listingImage' + itemID).attr({ src: "php/imageGet.php?id=" + itemID + "&" + new Date().getTime() });
			} else { //On failure report the failure
				$("#itemEditMessage").html(msg);
			}
        },
        cache: false,
        contentType: false,
        processData: false
    });
    e.preventDefault();
}


//Get the password updater modal
function getPasswordUpdater() {
	$("#modalDetails").html(""); //Clear the current modal
	$.get("php/modalUpdatePassword.php", function(data) { //Get the password updater modal
		$("#modalDetails").html(data); //Set the modal
	    var checkIfPasswordUpdaterIsReady = function(){ //Check if the modal has been set
		    if($('#updatePassword').length) { //If it has been set then activate the password strength bar
		    	$('#updatePassword').pwstrength({
			        ui: { showVerdictsInsideProgressBar: true }
			    });
		    } else {
		        setTimeout(checkIfPasswordUpdaterIsReady, 1000); //If it is not ready then check again in 1 second
		    }
		}
	    checkIfPasswordUpdaterIsReady();
    });
}


//Get the user profile page
function getProfilePage() {
	$("#loadingBar").css('display', 'block'); //Activate the loading bar
	$("#pageDetails").html(''); //Clear the current page
	isNotificationTableCollapsed = false; //Uncollapse the notification table
	$.get("php/pages/userProfile.php", { collapsed: false}, function(data) { //Get the user profile page
		$("#pageDetails").html(data); //Set the page

		//Add collapse to sidemenu
		var checkIfSideMenuIsReady = function(){ //Check it has been set
		    if($("#pageDetails").html() != "") { //If it has been set
		    	$("#loadingBar").css('display', 'none'); //Turn off the loading bar
		    	$("#menu-toggle").click(function(e) { //Activate the onclick toggle (open/close) for the side menu bar
	                e.preventDefault();
	                $("#wrapper").toggleClass("toggled");
	            });
	            var updateDate = new Date(); //Update the notifications last updated time to the current time
				$("#lastUpdatedTime").html("Last updated: " + updateDate.today() + " " + updateDate.timeNow());
	            setupAutoRefresh(); //Turn on the auto refresh for the notificaitons table
		    } else {
		        setTimeout(checkIfSideMenuIsReady, 1000); //If it is not ready then check again in 1 second
		    }
		}
		checkIfSideMenuIsReady();
	});
}


//Toggle the notification table collapsed variable (So when the table is refreshed it will remain in the selected state)
function changeNotificationCollase() {
	isNotificationTableCollapsed = !isNotificationTableCollapsed
}


//Get the current date
Date.prototype.today = function () { 
    return ((this.getDate() < 10)?"0":"") + this.getDate() +"/"+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +"/"+ this.getFullYear();
}


//Get the current time
Date.prototype.timeNow = function () {
     return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes() +":"+ ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
}


//Get the notfication modal so users can select which tags to be notified about
function getNotificationModal(){
	$("#loadingBar").css('display', 'block'); //Turn on the loading bar
	$("#modalDetails").html(""); //Clear the current modal
	$.get("php/modalNotifications.php", function(data) { //Get the notification modal
		$("#modalDetails").html(data); //Set the modal
		$("#loadingBar").css('display', 'none'); //Turn off the loading bar

		//Add toggle for the tags
		//When a tag is clicked the function will be called for that checkbox, sending of a post to the php file to update the database (turn on/off the notification for that tag)
		$('.switch input[type=checkbox]').change(function(event) { //On click
			$("#loadingBar").css('display', 'block'); //Turn on the loading bar
			$.post( "/php/accountNotificationUpdate.php", { id: event.target.value, status: jQuery(event.target).is(":checked") }, function( data ) { //Send of tghe post, passing the tag id and the checkbox status (off/on)
				if (data == "success") { //If the update was successful then update the notication table
					notificationTable();
				} else { //Else report the error message
					$("#notificationMsgID").html(data);
				}
				$("#loadingBar").css('display', 'none'); //Turn off the loading bar
			});
		});

	});
}


//Auto check if someone has added new item that uses a tag set to on in the users notification settings
function autoNotification() {
	var audio = new Audio('/alert.mp3'); //The sound to be played if an item has been added
	var notificationTime = moment().format('YYYY-MM-DD HH:mm:ss'); //Current time to compare against when items were added
	autoNotificationInterval = setInterval(function() { //Add repeating interval to keep checking in x amount of time
		$.get("php/notificationCheck.php", { notificationTime: notificationTime}, function(data) { //Send off request to see if an item has been made since the passed time
			if (data == "STOP") { //If it returns stop then cancel this auto loop
				clearInterval(autoNotificationInterval);
			} else if (data != "") { //Otherwise if the response is not empty then display the message and play the sound
				$("#notificationAlert").html(data);
				audio.play(); 
			}
			notificationTime = moment().format('YYYY-MM-DD HH:mm:ss'); //Update the time to pass throught in the next request
		});
	}, 30000);
}


//Get the notfication table
function notificationTable() {
	$.get("php/notificationTable.php", { collapsed: isNotificationTableCollapsed}, function(data) { //Send request for the notfication table, passing through if the table is collapsed or not
		$("#notificationTable").html(data); //Update the table with the returned repsonse
		var updateDate = new Date(); //Update the last updated time with the current datetime
		$("#lastUpdatedTime").html("Last updated: " + updateDate.today() + " " + updateDate.timeNow());
	});
}


//Auto refresh the notification table every x amount of time
function setupAutoRefresh() {
	var autoRefreshInterval = setInterval(function() {
		if($('#notificationTable').length) { //if the id exists then call the notification table method to update the table
			notificationTable();
		} else { //if the id is not there then the user has navigated away from the page so this auto refresh can be turned off
			clearInterval(autoRefreshInterval);
		}
	}, 180000);
}


//Toggle what notifications are displayed in the notification table
function filterNotificationTable(tagToToggle) { //Pass through the tag clicked
	if (notifcationFiltered == tagToToggle) { //If the tag clicked is already toggled (so it is the only one showing)
		notifcationFiltered = null; //Set filter to null and unhide all of the items
		$('#collapseNotifications').find('li').each(function() {
		    $(this).css({"display": ''});
		});
		$('#notificationTagFilters').find('b').each(function() { //Make the tag count icons full colour
		    $(this).css({"color": 'black'});
		});
	} else { //Else set the filter to the selected tag and hide all other tags
		notifcationFiltered = tagToToggle;
		$('#collapseNotifications').find('li').each(function() {
		    if ($(this).attr('id') != tagToToggle) {
		    	$(this).css({"display": 'none'});
		    } else { 
		    	$(this).css({"display": ''});
		    }
		});
		$('#notificationTagFilters').find('b').each(function() { //Make the other tag count icons dull so you can see which icon was selected
			if ($(this).attr('id') != tagToToggle) {
		    	$(this).css({"color": 'grey'});
		    } else { 
		    	$(this).css({"color": 'black'});
		    }
		});
	}
}


//Get the homepage
function getIndexPage() {
	$("#pageDetails").html(""); //Clear the current page
	$("#loadingBar").css('display', 'block'); //Turn on the loading bar
	$.get("php/pages/index.php", function(result) { //Request the homepage
		$("#pageDetails").html(result); //Set the page
    	$("#loadingBar").css('display', 'none'); //turn off the loading bar
	    $('.carousel').carousel({ //Activate the carousel
	      	interval: 6000
	    });
	    //Activate the swipe funtions for the carousel (go left/right)
       	$("#text-carousel").swiperight(function() { 
	        $(this).carousel("prev");  
	    });  
	    $("#text-carousel").swipeleft(function() {  
	        $(this).carousel("next");  
	    });
	    //Activate the auto typing message bar
	    $('.typist').typist({
			speed: 17,
			cursor: false
		});
		//Get the avilable and finished numbers from the page (passed through from index.php)
		hpAvailable = $("#hpAvailableID").text();
		hpFinished = $("#hpFinishedID").text();
		//Set the starting animation then call the typist loop
		$('.typist').animate({backgroundColor: "#5CB85C", color: "white"});
		homepageTypist();
	});
}


//The loop for the auto typing message bar on the homepage
function homepageTypist() {
	if($('.typist').length) { //If the message bar exists (if the page changes then it wont run this anymore)
		$('.typist').typistAdd('Available: ' + hpAvailable); //Write the available message
		$('.typist').typistPause(5000); //Wait
		$('.typist').typistRemove(11 + hpAvailable.length, function(){ //Remove the message
			$(".typist").animate({backgroundColor: "#337ab7"}); //Change the background colour to blue
		});
		$('.typist').typistAdd('Finished: ' + hpFinished); //Write the finished message
		$('.typist').typistPause(5000); //Wait
		$('.typist').typistRemove(10 + hpFinished.length, function(){ //Remove the message
			$(".typist").animate({backgroundColor: "#5CB85C"}); //Change the background colour to green
			homepageTypist(); //Loop
		});
	}
}


//Send off request to delete an account
function deleteAccount(userID) {
	$.post( "/php/accountDelete.php", { id: userID }, function( data ) { //Pass through the user id to delete
		if (data == 'success') { //Reload page on succes
			location.reload(); 
			$("#deleteAccountMessage").html("Account deleted. Reloading site...");
		} else { //Else on failure report error
			$("#deleteAccountMessage").html(data);
		}
	});
}


//Send off request to delete an organisation
function organisationRemove(orgID) {
	$.post( "/php/organisationDelete.php", { id: orgID }, function( data ) { //Pass through the organisation id to delete
		if (data == 'success') { //Reload page on succes
			location.reload();
			$("#organisationEditMessage").html("Organisation deleted. Reloading site...");
		} else { //Else on failure report error
			$("#organisationEditMessage").html(data);
		}
	});
}


//For users to leave an organisation
function leaveOrganisation() {
	$.post( "/php/accountLeaveOrganisation.php", function( data ) { //Send post to leave the organisation
		if (data == 'success') { //If success is returned then update the menu links so they can create/join a new one
			$("#leaveOrganisationMessage").html("You've left the organisation...");
			$("#volOrgMenu").html('<a data-toggle="modal" data-target="#modal-joinVol" class="no-select-link">Create/Join Volunteer Group</a>');
			$("#createLinkToOrganisationToggle").css('display', 'none'); //Remove link to organisation option
			$("#createAddressOrgToggle").css('display', 'none');
			getProfilePage(); //Refresh the profile page
			setTimeout(function () { //Wait then hide the leave organisation modal
				$('#modal-modalDetails').modal('hide');
			}, 2000);
			if ($('#createAddressOrg').is(":checked")) $("#createAddressNo").attr('checked', true).trigger('click'); //If the createAddressOrg was checked then change it to the no address option
		} else {
			$("#leaveOrganisationMessage").html(data); //On failure report error
		}
	});
}


//For a user to update their password
function updatePassword() {
	$("#passwordUpdateMessage").html(""); //Clear the current message
	//Get the passwords entered
	passwordOld = $("#updatePasswordOld").val();
	passwordNew = $("#updatePasswordNew").val();
	passwordConfirm = $("#updatePasswordConfirm").val();
	//Password validation
	if (passwordOld == "") { //Check the old password is not empty
		$("#passwordUpdateMessage").html("Please enter your current password.");
	} else if (validatePassword(passwordNew) == false) { //Check that the new password validates as ok (password requirements)
		$("#passwordUpdateMessage").html("Please enter a vaild password.");
	} else if (passwordNew != passwordConfirm) { //Check the confirmed password matches the new password (To prevent typos)
		$("#passwordUpdateMessage").html("Your new password does not match.");
	} else { //If the requirements are met then send request to update the password
		$.post( "/php/accountUpdatePassword.php", { oldPassword: passwordOld, newPassword: passwordNew }, function( data ) {
			if (data == 'success') { //On success
				$("#passwordUpdateMessage").html("Password updated");
			} else { //On failure report error
				$("#passwordUpdateMessage").html(data);
			}
		});
	}
}


//Get the organisation list page
function getOrganisationsPage() {
	$("#loadingBar").css('display', 'block'); //Show the loading bar
	$.get("php/organisationGetAll.php", function(data) { //Get the list of all organisations in a JSON file
		createOrganisationList(JSON.parse(data), function(result){ //Parse the JSON file then send it to createOrganisationList to make the tables for the page
			$("#pageDetails").html(result); //Fill the page with the organisation tables
			$("#loadingBar").css('display', 'none'); //Hide the loading bar
		});
	});
}


//Organisation owners can remove users from their organisation
function OrganisationRemoveMember(userToRemove, orgID) {
	$("#loadingBar").css('display', 'block'); //Show loading bar
	$.post("php/organisationRemoveUser.php", { groupID: orgID, userID: userToRemove }, function(result) { //Rend request to remove the user
		viewOrganisationMembers(orgID); //On return refresh the organisation members modal (the loading bar will be turned off in this)
	});
}


//The organisation owner can change who the organisation owner is
function OrganisationUpdateOwner(orgID) { 
	$("#loadingBar").css('display', 'block'); //Show loading bar
	$.post("php/organisationUpdateOwner.php", { groupID: orgID, userID: $('select[name=orgMemberList]').val() }, function(result) { //Rend request to chaneg the owner
		getOrganisationModal(orgID); //On return refresh the organisation members modal (the loading bar will be turned off in this)
	});
}


//Get the listings page (All, Request and Supplying pages use this by passing the type (null (for all), request, supplying))
function getListingsPage(setListingType) {
	$("#pageDetails").html(""); //Clear the current page
	$("#loadingBar").css('display', 'block'); //Show the loading bar
	listingType = setListingType; //Set the listingType for future calls without having to pass the reference
	$.get("php/pages/listings.php", function(result) { //Get the listing page
	  	$("#pageDetails").html(result); //Set the page
	  	var result = ''; //make an empty var to store the tags in
	  	$.get("php/tagGetAll.php", { "type": listingType }, function(data) { //Get all of the tags in jSON
	  		if (data != "") {
		  		obj = JSON.parse(data); //Parse the tags
				result = '<option selected="selected" value="">All</option>'; //Create the select for the tags (the user can use this to filter the items via tag)
				Object.keys(obj).forEach(function(k){ //For each tag add them to the select, displaying their name and the number of items with that tag. Value is the tags id so it can be referenced
					result += '<option value="' + obj[k].tagID + '">' + obj[k].name + ' (' + obj[k].totalItems + ')</option>';
		    	});
				
				//Check if the tags have finished being calulated
				var checkIfTagsAreReady = function(){
				    if($('#tagFilterList').length) {
				    	$("#tagFilterList").html(result); //Set the tag select
				    }
				    else {
				        setTimeout(checkIfTagsAreReady, 1000); //If it is not ready then check again in 1 second
				    }
				}
				checkIfTagsAreReady();
				getAllListings(false); //Get all of the listings to fill the page with the item tables
	  		}
		});
	});
}


//Get all of the listings, filtered on the type (null(all), request, supplying)
function getAllListings(callSearch) {
	$("#loadingBar").css('display', 'block'); //Display the loading bar
	$.get("php/itemGetAll.php", { "type": listingType}, function(data) { //Send the request to get all of the items (with the filter), return in JSON
		filterArray(JSON.parse(data),$("#tagFilterList").val(),$("input[name='statusFilter']:checked").val(), function(filteredArray){ //Parse the JSON then filter the returned results via the tag select and status checkbox
			createItemList(filteredArray, function(result){ //Create the item tables from the filtered array
				activateLazyLoad(); //Activate lazy load (loads images once they become in view to reduce impact of loading for user and server)
				if (callSearch) { //If their is currently something in the search bar then call search tables to filter the displayed item tables
					searchTables(result);
				}
				$("#loadingBar").css('display', 'none'); //Hide the loading bar
			});
		});
	});
}


//Used to toggle the view of the item tables (show/hide image+description)
function toggleItemInfo() {
	if (toggleState == false) {
		$("tr[name=itemTableInfoToggle]").each(function() {
			$(this).css({'display': 'none'});
		});
		toggleState = true;
	} else {
		$("tr[name=itemTableInfoToggle]").each(function() {
			$(this).css({'display': 'table-row'});
		});
		activateLazyLoad(); //If the expanded view is turned back on this lazy loading needs to be turned back on
		toggleState = false;
	}
}


//Turns lazy load on (loads images when they come into view to reduce impact on user and server)
function activateLazyLoad() {
	$('.lazy').Lazy({
		effect: 'fadeIn',
		effectTime: 500,
		visibleOnly: true
	});
}


//Used to filter the tables displayed on the listings pages (items and organisations)
function searchTables() {
    var filter, ul, li, a, i;
    filter = $("#searchValue").val().toUpperCase(); //Get and change the search text the user entered to uppercase 
    ul = $('#tableList'); //Get the list of item tables
    if(ul[0]) { //If there are list items
	    li = ul[0].getElementsByTagName('li'); //Get all the list elements (tables) 

	    for (i = 0; i < li.length; i++) { //For each table
	        a = li[i]; //Assign the current table
	        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) { //If it contains the search value then set display to ""
	            li[i].style.display = "";
	        } else { //If it doesnt contain the search value then hide the table (set table display to none)
	            li[i].style.display = "none";
	        }
	    }

	    if (filter == "") { //If the search box is empty then
	    	for (i = 1; i <= totalListingsPage; i++) {  //For each page hide page
	    		$('#listingPage' + i).hide();
	    	}
	    	$('#listingPage' + currentListingsPage).show(); //Unhide the page the user was on
	    	$('.listingButton').show(); //Unhide the listings buttons
	    } else { //If something is in the search box then
	    	for (i = 1; i <= totalListingsPage; i++) { //For each page
	    		$('#listingPage' + i).show(); //Unhide page
	    		var pageVis = false;
	    		$('#listingPage' + i + '> li').each(function () { //Check if there are any visible items on the page
	    			if ($(this).is(":visible")) pageVis = true;
		    	});
		    	if (pageVis == false) $('#listingPage' + i).hide(); //If all items on the page are hidden then hide that page
	    	}
	    	$('.listingButton').hide(); //Hide the listings buttons
	    }
	}
    activateLazyLoad(); //Activate lazy load
}


//Log user in
function checkLoginSuccess() {
	//Validation for email and password
	if (validateEmail($("#loginEmail").val()) == false){
		$("#loginMessage").html("Please enter a vaild email or create a new account.");
		return false;
	}
	if (validatePassword($("#loginPassword").val()) == false){
		$("#loginMessage").html("Please enter a vaild password or create a new account.");
		return false;
	}
	$("#loginMessage").html("Logging in..."); //display message that its logging in
	$("#loadingBar").css('display', 'block'); //Activate loading bar

	//Check if login is successful
	$.post( "/php/accountLogin.php", { email: $("#loginEmail").val(), password: $("#loginPassword").val() }, function( data ) { //Send post message, passing  email and password
		if (data == "success"){ //On success hide the login modal, load the index page and reload the navbar (initialLoad)
			$('#modal-login').modal('hide');
			getIndexPage();
			initialLoad(function(callback){});
		} else {
			$("#loginMessage").html(data); //On failure report error
		}
		$("#loadingBar").css('display', 'none'); //Hide loading bar
	});
}


//Used for error messages when creating accounts
function accountCreationError(errorMessage) {
	$("#accountCreationMessage").html('<br><div class="alert alert-danger alert-dismissible fade in" role="alert">' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
           	'<span aria-hidden="true">×</span>' +
        '</button>' +
           	'<p>'+errorMessage+'</p>' +
           	'<p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>' +
    '</div>');
}


//Create a new user account
function checkAccountCreationSuccess() {
	$("#accountCreationMessage").html(""); //Clear error message
	$("#loadingBar").css('display', 'block'); //Show loading bar

	//Get the entered data
	email = $("#newEmail").val();
	password = $("#newPassword").val();
	confirmPassword = $("#newConfirm").val();
	firstName = $("#newFirstName").val();
	lastName = $("#newLastName").val();

	//Validation
	if (validateEmail(email) == false) {
		accountCreationError("Invalid email address");
	} else if (password != confirmPassword) {
        accountCreationError("Your passwords do not match");
	} else if (validateEmail(email) == false) {
        accountCreationError("You can not use your email as your password");
	} else if (validatePassword(password) == false) {
        accountCreationError("Invalid password");
	} else if (validateName(firstName) == false) {
        accountCreationError("Invalid first name");
	} else if (validateName(lastName) == false) {
        accountCreationError("Invalid last name");
	} else { //If everything validates then

		//Check if login is successful
		$.post( "/php/accountCreate.php", { email: email, password: password, firstName: firstName, lastName: lastName }, function( data ) { //Send post to create account, passing through the data
			if (data == "success") { //On success send email to unlock new account
				$.post( "/php/sendEmail.php" );
				$("#accountCreationMessage").html("Your account has been created<br>Please check your email to confirm your account.");
			} else { //On failure report error
				$("#accountCreationMessage").html(data);
			}			
		});
	}
	$("#loadingBar").css('display', 'none'); //Hide loading bar
}


//User joins a volunteer group
function joinVolunteerGroup() {
	$("#volOrgJoinMessage").html(""); //Clear error message
	organisationIDToLink = $("#volOrgList").val(); //Get the choosen organisation info 
	$.post( "/php/accountLinkOrganisation.php", { groupID: organisationIDToLink }, function( data ) { //Send request, padding the organisation id
		if (data == "success") { //On success
			//Call initial load to update the navbar
			$('#modal-joinVol').modal('hide');
			initialLoad(function(callback){});
			//Get the profile page
			getProfilePage();
			//Get the organisation modal for the organisation the user joined
			getOrganisationModal(organisationIDToLink);
			$('#modal-modalDetails').modal('show');			
		} else { //On failure report error
			$("#volOrgJoinMessage").html(data);
		}			
	});
}


//Create a new volunteer group
function createVolunteerGroup() {
	$("#volOrgCreateMessage").html(""); //Clear error message
	//Get the new orgnsiation data
	newOrganisationName = $("#volOrgName").val();
	newOrganisationInformation = $("#volOrgInformation").val();
	newOrganisationAddress = $("#createCustomAdressOrg").val();
	//Post the data
	$.post( "/php/organisationCreate.php", { volOrgName: newOrganisationName, volOrgInformation: newOrganisationInformation, volOrgAddress: newOrganisationAddress }, function( data ) {
		if (isNormalInteger(data)) { //On success reload navbar and get organisation modal for the created organisation
			$('#modal-createVol').modal('hide');
			initialLoad(function(callback){});
			getOrganisationModal(data);
			$('#modal-modalDetails').modal('show');
		} else {
			$("#volOrgCreateMessage").html(data); //On failure report error
		}			
	});
}


//Validate email
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}


//Validate password
function validatePassword(password) {
    var re = /^[A-Za-z]\w{7,15}$/;  
    return re.test(password);
}


//Validate name
function validateName(name) {
    var re = /^[A-Za-z]\w{1,50}$/;  
    return re.test(name);
}


//Log user out
function logout() {
	$("#loadingBar").css('display', 'block'); //Show loading bar
	$.post( "/php/accountLogout.php", function() { //Send post request
		$("#pageDetails").html(""); //Clear page
		initialLoad(function(callback){ //Reload navbar
			getIndexPage(); //Get the index page
		});
	});
}


// Get the user modal
function getUserModal(userID) {
	$("#loadingBar").css('display', 'block'); //Show loading bar and clear modal data
	$("#modalDetails").html("");
	$.get("php/userModal.php", { id: userID}, function(data) { //Get the modal data for the passed user
		if (data == ""){ //If the response is nothing then hide modal
			$('#modalDetails').modal('hide');
		} else { //Else fill the modal with the returned data
		 	$("#modalDetails").html(data);
		}	
		$("#loadingBar").css('display', 'none'); //Hide loading bar
	});
}


//Get the item modal
function getItemModal(itemID) {
	$("#loadingBar").css('display', 'block');  //Show loading bar and clear modal data
	$("#modalDetails").html("");
	$.get("php/itemGetModalInfo.php", { id: itemID}, function(data) { //Get the modal data for the item
		if (data == ""){ //If the response was empty then report error
			$("#modalDetails").html("There was an error getting the details for this item");
		} else { //Else fill the modal with the returned data
			$("#modalDetails").html(data);
			//Activate datetime picker
	       	$('#datetimepicker2').datetimepicker({
				sideBySide: true,
				ignoreReadonly: true,
				minDate: moment().format("YYYY-MM-DD"),
				defaultDate: moment().format("YYYY-MM-DD")
			});
			$('#newDateTime').on('click touchstart', function() {
		        $('#datetimepicker2').data("DateTimePicker").show();
		    });
		}
		$("#loadingBar").css('display', 'none'); //Hide loading bar
	});
}


//Send off php request
function sendOffPHP(elementID,fileName) {
	$("#loadingBar").css('display', 'block'); //Show loading bar and clear the passed element
	$("#"+elementID).html("");
	$.get(fileName, function(data) { //Send get request for the sent php file
		$("#"+elementID).html(data); //Set the response in the passed element
		$("#loadingBar").css('display', 'none'); //Hide the loading bar
	});
}


//Get the organisation modal
function getOrganisationModal(organisationID) {
	$("#loadingBar").css('display', 'block'); //Show loading bar and clear modal data
	$("#modalDetails").html("");
	$.get("php/organisationGetModalInfo.php", { id: organisationID}, function(data) { //Send get request, passing organisation id
		if (data == ""){ //If the response is empty then report error
			$("#modalDetails").html("There was an error getting the details for this organisation");
		} else { //Else set the modal with the response
			$("#modalDetails").html(data);
			//Activate the google map
			var input = document.getElementById('updateCustomAdressOrg');
			if (input != null) {
				var autocomplete = new google.maps.places.Autocomplete(input, options);
			}
		}
		$("#loadingBar").css('display', 'none'); //Hide loading bar
	});
}


//Checks if the passed value is an integer
function isNormalInteger(str) {
    var n = Math.floor(Number(str));
    return String(n) === str && n >= 0;
}


//Creates a new listing
function createNewListing() {
	//Get entered data and perform validation
	$("#createNewListingButton").prop("disabled",true);
	var createPerishable = $('input[name=createPerishable]:checked').val();
	var createLinkToOrganisation = $('input[name=createLinkToOrganisation]:checked').val();
	if (document.querySelector('input[name="createAddress"]:checked').value == "[Custom]") {
		var createShowMap = $("#createCustomAdress").val();

	} else {
		var createShowMap = document.querySelector('input[name="createAddress"]:checked').value;
	}
	if ($("#createTitle").val().length > 250){
		$("#createListingMessage").html('<br><div class="alert alert-danger alert-dismissible fade in" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
               	'<span aria-hidden="true">×</span>' +
            '</button>' +
               	'<p>The title must have less than 251 characters</p>' +
               	'<p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>' +
        '</div>');
		$("#createNewListingButton").prop("disabled",false);
	} else if ($("#createDescription").val().length > 500){
		$("#createListingMessage").html('<br><div class="alert alert-danger alert-dismissible fade in" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
               	'<span aria-hidden="true">×</span>' +
            '</button>' +
               	'<p>The description must have less than 501 characters</p>' +
               	'<p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>' +
        '</div>');
		$("#createNewListingButton").prop("disabled",false);
	} else if ($("#createTitle").val() != "" && $("#createDescription").val() != "" && $("#createTagID").val() != "" && $("#createDescription").val() != "" && $("#createDescription").val() != "" && createShowMap != "" && $("#createEndtime").val() != ""){
		//If all validation is passed then send post request passing the entered data
		$("#createListingMessage").html("Creating listing...");
		$.post( "/php/itemCreate.php", { title: $("#createTitle").val(), tagID: $("#createTagID").val(), description: $("#createDescription").val(), category: $("#createCategory").val(), endtime: $("#createDateTime").val(), perishable: createPerishable, linkToOrg: createLinkToOrganisation, mapLocation: createShowMap}, function( data ) {
			if (isNormalInteger(data)) { //On success				
				var itemNum = data;
				$("#createListingMessage").html("Item created. Redirecting you to the item...");
				$("#pageDetails").html(''); 
				//Get the listings page
				listingsPageCallback(function(callback){
					var checkIfListingPageIsReady = function(){
					    if($("#pageDetails").html() != '') {
					    	//Load the last page
					    	if (lastlistingPage > 1){
								changePageVisibility("listingPage"+lastlistingPage,"listingPage1");
							}
							$("#modalDetails").html("");
							$('#modal-createListing').modal('hide');
							$('#modal-modalDetails').modal('show');
							//Get the item moda info
							getItemModal(itemNum);
							//Reset the create listing options
							$("#createNewListingButton").prop("disabled",false);
							$("#createTitle").val("");
							$("#titleCharLimit").val("250");
							$("#descCharLimit").val("500");
							$("#createDescription").val("");
							$("#createTagID").selectedIndex = "0";
							$("#createCategory").selectedIndex = "0";
							$("#createListingMessage").html("");
							//Send notification emails
							$.post( "/php/sendEmail.php" );
					    }
					    else {
					        setTimeout(checkIfListingPageIsReady, 1000); //If it is not ready then check again in 1 second
					    }
					}
					checkIfListingPageIsReady();
				});
			} else {
				$("#createListingMessage").html(data);
				$("#createNewListingButton").prop("disabled",false);
			}			
		});
	} else {
		$("#createListingMessage").html('<br><div class="alert alert-danger alert-dismissible fade in" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
               	'<span aria-hidden="true">×</span>' +
            '</button>' +
               	'<p>All fields must be filled out</p>' +
               	'<p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>' +
        '</div>');
		$("#createNewListingButton").prop("disabled",false);
	}
}


function listingsPageCallback(callback){
	callback(getListingsPage(null));
}


//Used to toggle modal page (between editing page and info page)
function changeHiddenState(idType) {
    if ($('#'+idType+'Info').css('display') == 'none') {
    	$('#'+idType+'Info').css('display', 'block');
    	$('#'+idType+'Editing').css('display', 'none');
    } else {
    	$('#'+idType+'Editing').css('display', 'block');
    	$('#'+idType+'Info').css('display', 'none');
    }
}


//Change the items status
function changeStatus(itemID, newItemStatus) {
	$("#itemInfoMessage").html("");
	$.post( "/php/itemStatusChange.php", { id: itemID, status: newItemStatus }, function( data ) { //Send post, passing item id and status
		if (data == "success") { //On success reload item modal and update that items table
			getItemModal(itemID);
			updateItemTable(itemID);
		} else { //On failure report error
			$("#itemInfoMessage").html(data);
		}			
	});
}


//Remove listing
function removeListing(itemID) {
	$("#itemEditMessage").html("");
	var removeListingCheck = confirm("Are you sure you want to remove this listing?"); //Confirmation message
	if (removeListingCheck == true) { //If the user clicked yes
		$.post( "/php/itemDelete.php", { id: itemID }, function( data ) { //Send post request passing item id
			if (data == "success") { //On success
				if ($('#itemTableID'+itemID).length) { //If the item table exists then remove it
					$('#itemTableID'+itemID).remove();
				} else if($('#profileListingID'+itemID).length) { //If the item table exists then remove it
					$('#profileListingID'+itemID).remove();
				} else if ($('#carouselItemID'+itemID).length) { //If the item is on the carousel then remove it
					$('#carouselItemID'+itemID).remove();
				}
				$('#modal-modalDetails').modal('hide'); //Hide the item modal
			} else {
				$("#itemEditMessage").html(data); //On failure report error
			}			
		});
	}
}


//Edit listing info
function editListing(itemID) {
	$("#itemEditMessage").html("");
	//If the data fields are not empty
	if ($("#newTitle").val() != "" && $("#newDescription").val() != "" && $("#newCategory").val() != "" && $("#newDateTime").val()){
		//Send post request to update item with the passed data
		$.post( "/php/itemEdit.php", { id: itemID, title: $("#newTitle").val(), description: $("#newDescription").val(), category: $("#newCategory").val(), endtime: $("#newDateTime").val() }, function( data ) {
			if (data == "success") { //On success
				getItemModal(itemID); //Refresh the item modal
				updateItemTable(itemID); //Update item table (if it exists)
			} else {
				$("#itemEditMessage").html(data);
			}			
		});
	} else {
		$("#itemEditMessage").html('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><p>All fields must not be empty!</p><p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p></div>');
	}
}


//Update the item table
function updateItemTable(itemID,locationType) {
	//If the table exists
	if ($('#itemTableID'+itemID).length || $('#profileListingID'+itemID).length) {
		$.get("php/itemGetSingle.php", { id: itemID}, function(data) { //Get the info for that item
			if (data != "failed") { //On success update the item table
				if ($('#itemTableID'+itemID).length) {
					createItemTable(JSON.parse(data), function(result){
						$('#itemTableID'+itemID).html(result);
						activateLazyLoad();
					});
				} else if($('#profileListingID'+itemID).length){
					updateProfileItem(JSON.parse(data), '#profileListingID'+itemID, function(result){
						$('#profileListingID'+itemID).html(result);
					});
				}
			} else {
				location.reload(); //On failure reload the page
			}			
		});
	}
}


//Updates a profile item
function updateProfileItem(itemObj, itemID, callback){
    switch (itemObj.finished) { //Change the status colour for an item
        case "0":
        	jQuery(itemID).removeClass().addClass('list-group-item').addClass('available');
            break;
        case "1":
            jQuery(itemID).removeClass().addClass('list-group-item').addClass('wanted');
            break;
        default:
            jQuery(itemID).removeClass().addClass('list-group-item').addClass('primary');
    }
    var updatedProfileItem = ""; //Update the table button
    updatedProfileItem += '<button type="button" class="table-button" onclick="getItemModal(' + itemObj.itemID + ')" data-toggle="modal" data-target="#modal-modalDetails">' + itemObj.name + '</button></li>';
  	callback(updatedProfileItem);
}


//Edit organisations info
function editOrganisation(orgID) {
	$("#organisationEditMessage").html("");
	//If the data fields are not empty then send post request passing through the data
	if ($("#updateName").val() != "" && $("#updateDescription").val() != "" && $("#updateCustomAdressOrg").val() != ""){
		$.post( "/php/organisationEdit.php", { id: orgID, name: $("#updateName").val(), description: $("#updateDescription").val(), currentNews: $("#updateCurrentNews").val(), address: $("#updateCustomAdressOrg").val()}, function( data ) {
			if (data == "success") { //On success refresh the organisation modal and update the organisation table if it exists
				getOrganisationModal(orgID);
				updateOrganisationTable(orgID);
			} else { //On failur ereport error
				$("#organisationEditMessage").html(data);
			}			
		});
	} else {
		$("#organisationEditMessage").html('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><p>Name, description and address must not be blank</p><p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p></div>');
	}
}


//Get the orgnsation member modal
function viewOrganisationMembers(orgID) {
	$("#loadingBar").css('display', 'block'); //Show loading bar
	$.get("php/organisationGetMemberModalInfo.php", { id: orgID}, function(data) { //Send get request passing the organisations id
		if (data == ""){ //If the request returns nothing then report error
			$("#modalDetails").html('There was an error getting the members for this organisation<br><button type="button" class="btn btn-default testing" data-dismiss="modal" aria-hidden="true">Close window</button>');
		} else { //Else set the modal details to the returned data
			$("#modalDetails").html(data);
		}
		$("#loadingBar").css('display', 'none'); //Hide loading bar
	});
}


//Send new homepage message to database
function createNewHomepageMessage(){
	$("#hpCreateMessage").html("");
	//If the fields are not empty then send post request, passing throug the data
	if ($("#hpDescription").val() != "" && $("#hpDescription").val() != ""){
		$.post( "/php/updateHomepageMessage.php", { title: $("#hpTitle").val(), description: $("#hpDescription").val()}, function( data ) {
			if (data == "success") { //On success report the message has been updated and clear the data fields
				$("#hpCreateMessage").html("The homepage message has been updated.");
				$("#hpTitle").val("");
				$("#hpDescription").val("");
			} else { //On failure report error
				$("#hpCreateMessage").html(data);
			}			
		});
	} else {
		$("#hpCreateMessage").html('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><p>All fields must not be empty!</p><p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p></div>');
	}
}


//Updates an organisations table
function updateOrganisationTable(orgID) {
	//Check the table exists so it can be updated
	if ($("#organisationTableID"+orgID).length){
		//Send get request to get a single organisations info
		$.get( "/php/organisationGetSingle.php", { id: orgID }, function( data ) {
			if (data != "") { //if it didnt fail
				//Create the new table
				createOrganisationTable(JSON.parse(data), function(result){
					$("#organisationTableID"+orgID).html(result); //Update the old table with the new table
					activateLazyLoad(); //Activate lazy load
				});
			};
		});
	}
}


//If the user is logged out but tries to create an item display this message
function loginRequiredMessage(requiredCheck) {
	if (requiredCheck == true){
		$("#loginMessage").html("You must be logged in before you can create a listing");
	} else {
		$("#loginMessage").html("");
	}
}


//Filters an array of items
function filterArray(arrayToFilter,tagFilter,finishedFilter,callback) {
	//Array of all items from request
	var filteredArray = arrayToFilter;
	//If there is a tag filter 
	if (tagFilter != "") { //For all items check if they match the selected tag, return the items that match into the array 
		filteredArray = filteredArray.filter(function( obj ) {
		  	return obj.FKtagID == tagFilter;
		});
	}
	//If there is a status filter 
	if (finishedFilter != "") { //For all items check if they match the selected status, return the items that match into the array 
		filteredArray = filteredArray.filter(function( obj ) {
		  	return obj.finished == finishedFilter;
		});
	}
	//Return the filtered array
	callback(filteredArray);
}


function isInteger(num) {
  	return (num ^ 0) === num;
}


//Create the item list (item pages)
function createItemList(obj, callback) {
	var itemsPerPage = 20; //Number of items to display per page
	var numOfItemsInObj = Object.keys(obj).length; //Number of items in array
	lastlistingPage = Math.ceil(numOfItemsInObj / itemsPerPage); //Number of pages there will be
	var maxPage = lastlistingPage;
	var listingsStr = "";
	var currentPage = 1; //Default page number
	var currentItem = 0; //Default item number

	//Create the list to store the tables in
	listingsStr += '<ul id="tableList">';
	//Place the top buttons at the top
	listingsStr += '<div id="listingPage' + currentPage + '" style="display: block">';
	createChangePageButtons('listingPage',currentPage,maxPage, function(result){
		listingsStr += result;
	});

	//For each item
	Object.keys(obj).forEach(function(k){
		var tempa = currentItem / itemsPerPage; //Check if it is the end of the page
		if (isInteger(tempa) && currentItem != 0){ //If it is not the first page
			//Place page buttons on the end of the page
			createChangePageButtons('listingPage',currentPage,maxPage, function(result){
				listingsStr += result;
				currentPage++;			
				//Add buttons to the top of the new page
				listingsStr += '<br></div><div id="listingPage' + currentPage + '" style="display: none">';
				createChangePageButtons('listingPage',currentPage,maxPage, function(result){
					listingsStr += result;
				});
			});
		}

		//Add the items table to the page
		currentItem++;
		listingsStr += '<li id="itemTableID' + obj[k].itemID + '">';
		createItemTable(obj[k], function(result){
			listingsStr += result;
			listingsStr += '</li>';
		});
	});
	
	//Add buttons to the end of the last page
	totalListingsPage = currentPage;
	createChangePageButtons('listingPage',currentPage,maxPage, function(result){
		listingsStr += result;
	});

	//Set data and return the number of pages
	listingsStr += '</div></ul>';
	$("#listingArea").html(listingsStr);
	callback(maxPage);
}


//Create an item table
function createItemTable(itemObj, callback){
	//Seperate the item tables
	var newItemTable = "<p>";
	//Create surrounding div, responsive to make it resize correctly, padding for appearance and nounderline for links
	newItemTable += '<div class="table-responsive table-padding noUnderline">';
		//Make the table (bootstrap formating), with the pointer for cursor on hover to show it is a link
		//On click open the item modal and get the data for that item for the modal 
      	newItemTable += '<table class="table table-striped table-hover cursorPointer" onclick="getItemModal(' + itemObj.itemID + ')" data-toggle="modal" data-target="#modal-modalDetails">';
      	
      		//The body of the table
	      	newItemTable += '<tbody>';
	      		newItemTable += '<tr class="table-bordered">';
	      		//The heading of the table, contains the item name
		      		newItemTable += '<td colspan="2" ';
		      			//Depending on the status of the item change the colour (blue, green and orange)
		      			switch (itemObj.finished) {
		            		case "0":
		                        newItemTable += 'class="available" value="available">';
		            			break;
		            		case "1":
		                        newItemTable += 'class="wanted" value="reserved">';
		            			break;
		            		default:
		                        newItemTable += 'class="primary" value="unavailable">';
		            	}
		            	//Depending on the category show if it is a request item or supply item via an icon
		            	if (itemObj.category == "Request") {
		            		newItemTable += '<span class="fa fa-shopping-cart dontHideBadge" style="display: flex;">';
		            	} else {
		            		newItemTable += '<span class="glyphicon glyphicon-gift dontHideBadge" style="display: flex;">';
		            	}
		            	//Item name
						newItemTable += '<h2>&nbsp; ' + itemObj.name + '</h2></span>';
		      		newItemTable += '</td>';
	      		newItemTable += '</tr>';

	      		//This row holds the image and description (which can be toggled via the toggle view button)
	      		newItemTable += '<tr name="itemTableInfoToggle" class="table-bordered" style="';
	      		//Check the toggle state to load the table with the correct display
	      		if (toggleState == false) {
	      			newItemTable += 'display: table-row">';
	      		} else {
	      			newItemTable += 'display: none">';
	      		}
	      			//Image goes here
		      		newItemTable += '<td class="tableImage" style="padding:0px">';
		      			//Uses php to get the correct image and falls (lazy load prevents the call untill it goes into view)
		      			newItemTable += '<img id="listingImage' + itemObj.itemID + '" class="lazy" style="display:block" data-src="php/imageGet.php?id=' + itemObj.itemID + '&' + new Date().getTime() + '"  width="140" height="120" alt="' + itemObj.imgTag + '">';
		      		newItemTable += '</td>';

		      		//Description does here
		      		newItemTable += '<td class="table-listings">';
		      			//If the description is too long then get the first 200 characters and add ...
		      			if (itemObj.description.length > 200){
		      				newItemTable += itemObj.description.substring(0,200) + '...<br>';	
		      			}
		      			else{
		      				newItemTable += itemObj.description + '<br>';
		      			}
		      			//Add read more to the description using the default link styling 
		      			newItemTable += '<a>Read more...</a>';
		      		newItemTable += '</td>';
	      		newItemTable += '</tr>';
	      	newItemTable += '</tbody>';
	      	
      	newItemTable += '</table>';
  	newItemTable += '</div>';
  	//Return the created table
  	callback(newItemTable);
}


//Create the organisation list (pages)
function createOrganisationList(obj, callback){
	var currentPage = 1; //Default number of pages
	var currentOrg = 0; //Default number of organisations
	var orgsPerPage = 20; //Number of organisations to display per page
	var organisationsStr; //String to store list in
	var numOfItemsInObj = Object.keys(obj).length; //Calculate the number of organisations in array
	var maxPage = Math.ceil(numOfItemsInObj / orgsPerPage); //Calculate the number of pages needed

	//Create the wrapper to house the content
	organisationsStr = '<div class="center wrapper">';
	//Add the search bar for searching for organisations
	organisationsStr += '<input type="text" id="searchValue" onkeyup="searchTables()" placeholder="Search for organisation..">';
	//Create the list
	organisationsStr += '<ul id="tableList">';
	//Create the first organisation page
	organisationsStr += '<div id="listingPage' + currentPage + '" style="display: block">';
	//Add the page buttons along the top of the page
	createChangePageButtons('listingPage',currentPage,maxPage, function(result){
		organisationsStr += result;
	});

	//For each organisation
	Object.keys(obj).forEach(function(k){
		var tempa = currentOrg / orgsPerPage; //Check if it is the end of the page
		if (isInteger(tempa) && currentOrg != 0){ //If it is not the first organisation
			//Add the page buttons to the bottom of the page
			createChangePageButtons('listingPage',currentPage,maxPage, function(result){
				organisationsStr += result;
				currentPage++;			
				//Create the next page and add the page buttons along the top
				organisationsStr += '<br></div><div id="listingPage' + currentPage + '" style="display: none">';
				createChangePageButtons('listingPage',currentPage,maxPage, function(result){
					organisationsStr += result;
				});
			});
		}

		currentOrg++;
		//Create the organisation table
		organisationsStr += '<li id="organisationTableID' + obj[k].groupID + '">';
		createOrganisationTable(obj[k], function(result){
			organisationsStr += result;
			organisationsStr += '</li>';
		});
	});
	
	//At the end of the last organisation page put the page buttons
	totalListingsPage = currentPage;
	createChangePageButtons('listingPage',currentPage,maxPage, function(result){
		organisationsStr += result;
	});

	//Return the created organisation list (pages)
	organisationsStr += '</div></ul>';
	callback(organisationsStr);
}


//Create an organisation table
function createOrganisationTable(organisationObj, callback){
	var newOrganisationTable = "";
	//Create the wrapper
	newOrganisationTable += '<div class="table-responsive table-padding cursorPointer">';
	//Make a link that on click opens the organisation modal and loads the data for it
	newOrganisationTable += '<a type="button" class="table-button noUnderline" onclick="getOrganisationModal(' + organisationObj.groupID + ')" data-toggle="modal" data-target="#modal-modalDetails">';
  	//Create the table
  	newOrganisationTable += '<table class="table table-striped table-bordered table-hover table-restrict-size"">';
  	newOrganisationTable += '<thead>';
  	//The organisation name goes in the header/ first row
  	newOrganisationTable += '<tr><td><b>' + organisationObj.name + '</b></td></tr>';
  	newOrganisationTable += '</thead>';
  	newOrganisationTable += '<tbody>';
  	//The next row contains the description
  	newOrganisationTable += '<tr><td class="table-listings">';
  	//if the description is larger than 200 characters then get the first 200 characters and add ...
  	if (organisationObj.Information.length > 200){
		newOrganisationTable += organisationObj.Information.substring(0,200) + '...<br>';	
	} else {
		newOrganisationTable +=  organisationObj.Information + '<br>';
	}
	//Add read more in a default styled link
  	newOrganisationTable += '<a>Read more...</a></td></tr>';
  	newOrganisationTable += '</tbody>';
  	newOrganisationTable += '</table>';
  	newOrganisationTable += '</a>';
  	newOrganisationTable += '</div>';
  	//Return the table
  	callback(newOrganisationTable);
}


//Creates page buttons to swap between item/organisation pages
function createChangePageButtons(pageType,currentPage,maxPage,callback){
	var pageButtons = "";
	//maxButtons Must be an odd number
	var maxButtons = 7;

	if (maxPage > 1){
		pageButtons += '<div id="organisationButton" class="testing listingButton">';
		pageButtons += '<ul class="pagination pagination-sm">';

		//If it is the first page then put up to the next 4 pages (If more than maxButtons pages then make the 5th page the last page)
		if (currentPage == 1){
			pageButtons += '<li class="active"><a>1</a></li>';
			if (maxPage > maxButtons){
				for(var i = 2; i < maxButtons; i++){
					pageButtons += '<li class="cursorPointer"><a onclick="changePageVisibility(' + "'" + (pageType + i) + "'" + ',' + "'" + (pageType + currentPage) + "'" + ')">' + i + '</a></li>';
				}
				pageButtons += '<li class="cursorPointer"><a onclick="changePageVisibility(' + "'" + (pageType + maxPage) + "'" + ',' + "'" + (pageType + currentPage) + "'" + ')">' + maxPage + '</a></li>';
			} else {
				for(var i = 2; i <= maxPage; i++){
					pageButtons += '<li class="cursorPointer"><a onclick="changePageVisibility(' + "'" + (pageType + i) + "'" + ',' + "'" + (pageType + currentPage) + "'" + ')">' + i + '</a></li>';
				}
			}
		
		//If it is the last page then put up to the previous 4 pages (If more than maxButtons pages then make the 1st page the first page)
		} else if(currentPage == maxPage) {
			pageButtons += '<li class="cursorPointer"><a onclick="changePageVisibility(' + "'" + (pageType + '1') + "'" + ',' + "'" + (pageType + currentPage) + "'" + ')">1</a></li>';
			if (maxPage > maxButtons){
				for(var i = currentPage - (maxButtons-2); i < currentPage; i++){
					pageButtons += '<li class="cursorPointer"><a onclick="changePageVisibility(' + "'" + (pageType + i) + "'" + ',' + "'" + (pageType + currentPage) + "'" + ')">' + i + '</a></li>';
				}
			} else {
				for(var i = 2; i < maxPage; i++){
					pageButtons += '<li class="cursorPointer"><a onclick="changePageVisibility(' + "'" + (pageType + i) + "'" + ',' + "'" + (pageType + currentPage) + "'" + ')">' + i + '</a></li>';
				}
			}
			pageButtons += '<li class="active"><a>' + currentPage + '</a>';

		//If the page is inbetween 1-maxPage then put up to maxButtons button (including first page and last page)
		} else {
			if (maxPage > maxButtons){
				var buttonSplit = Math.floor(maxButtons/2) - 1;
				var lowerButtons = buttonSplit;
				var upperButtons = buttonSplit;
				if (currentPage - buttonSplit <= 1) {
					lowerButtons = buttonSplit - (currentPage - 2 - buttonSplit);
					upperButtons = currentPage - 2;
				} else if (currentPage + buttonSplit >= maxPage) {
					lowerButtons = maxPage - currentPage - 1;
					upperButtons = buttonSplit - (maxPage - currentPage - 1 - buttonSplit);
				}

				pageButtons += '<li class="cursorPointer"><a onclick="changePageVisibility(' + "'" + (pageType + '1') + "'" + ',' + "'" + (pageType + currentPage) + "'" + ')">1</a></li>';
				for(var i = currentPage - upperButtons; i < currentPage; i++){
					pageButtons += '<li class="cursorPointer" ><a onclick="changePageVisibility(' + "'" + (pageType + i) + "'" + ',' + "'" + (pageType + currentPage) + "'" + ')">' + i +  '</a></li>';
				}
				pageButtons += '<li class="active"><a>' + currentPage + '</a>';
				for(var i = currentPage + 1; i <= currentPage + lowerButtons; i++){
					pageButtons += '<li class="cursorPointer"><a onclick="changePageVisibility(' + "'" + (pageType + i) + "'" + ',' + "'" + (pageType + currentPage) + "'" + ')">' + i +  '</a></li>';
				}
				pageButtons += '<li class="cursorPointer"><a onclick="changePageVisibility(' + "'" + (pageType + maxPage) + "'" + ',' + "'" + (pageType + currentPage) + "'" + ')">' + maxPage + '</a></li>';
			} else {
				for(var i = 1; i < currentPage; i++){
					pageButtons += '<li class="cursorPointer"><a onclick="changePageVisibility(' + "'" + (pageType + i) + "'" + ',' + "'" + (pageType + currentPage) + "'" + ')">' + i + '</a></li>';
				}
				pageButtons += '<li class="active"><a>' + currentPage + '</a>';
				for(var i = currentPage + 1; i <= maxPage; i++){
					pageButtons += '<li class="cursorPointer"><a onclick="changePageVisibility(' + "'" + (pageType + i) + "'" + ',' + "'" + (pageType + currentPage) + "'" + ')">' + i + '</a></li>';
				}
			}
			
		}
		pageButtons += '</ul>';
		pageButtons += '</div>';
	}
	
	callback(pageButtons);
}


//Changes which page is visble (used by item/organisation page buttons)
function changePageVisibility(newPage,previousPage){
	$("#"+previousPage).css('display', 'none');
	$("#"+newPage).css('display', 'block');
	currentListingsPage = newPage;
	activateLazyLoad();
	window.scrollTo(0, 0);
}