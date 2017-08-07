var currentListingsPage = 1;
var totalListingsPage = 1;
var indexData = null;
var lastlistingPage = 0;
var notifcationFiltered = null;
var isNotificationTableCollapsed = false;
var listingType = null;

$(function () {

	//Load navBar
	document.getElementById("loadingBar").style.display = "block";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("navBar").innerHTML = this.responseText;
			autoNotification();
			$('#datetimepicker1').datetimepicker({
				sideBySide: true,
				minDate: moment().format("YYYY-MM-DD HH:mm"),
				defaultDate: moment().add(1,'days').format("YYYY-MM-DD HH:mm")
			});
			if ($('#modal-login').length) {
				$('#newPassword').pwstrength({
				 	common: { usernameField: '#newEmail' },
			        ui: { showVerdictsInsideProgressBar: true }
			    });
				$("#modal-login").keypress(function(event) {
				    if (event.which == 13) {
				     	checkLoginSuccess();
				    } 
				});
				$("#modal-AccountCreate").keypress(function(event) {
				    if (event.which == 13) {
				     	checkAccountCreationSuccess();
				    }
				});
			}
			if ($('#modal-createListing').length) {
				var defaultBounds = new google.maps.LatLngBounds(
					new google.maps.LatLng(-37.636980, 143.691664),
					new google.maps.LatLng(-37.483302, 143.976130));
				var options = {
					bounds: defaultBounds
				};
				var input = document.getElementById('createCustomAdress');
				var autocomplete = new google.maps.places.Autocomplete(input, options);
				$("#modal-createListing").keypress(function(event) {
				    if (event.which == 13) {
				     	createNewListing();
				    }
				});
				$("input[name='createAddress']").change(function () {
					if($("input[name='createAddress']:checked").val() == "[Custom]"){
						document.getElementById("createCustomAdress").style.display = 'block';
					} else {
						document.getElementById("createCustomAdress").style.display = 'none';
					}
   				});
			}
			
			document.getElementById("loadingBar").style.display = "none";
		}
	};
	xmlhttp.open("GET", "/php/navBar.php", true);
	xmlhttp.send();

	getIndexPage();
});


function submitFile(itemID) {
	var input = document.querySelector("input[name='fileToUpload']"),
    file = input.files[0];
    if (!file || !file.type.match(/image.*/)) return;
    var fd = new FormData();
    fd.append("fileToUpload", file);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "/php/imageUpload.php?id=" + itemID, true);
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == "SUCCESS"){
				document.getElementById("itemEditMessage").innerHTML = '<br><div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><p>Image uploaded successfuly.</p><p><button type="button" class="btn btn-success" data-dismiss="alert">Dismiss</button></p></div>';
				document.getElementById('modalImage' + itemID).src = "php/imageGet.php?id=" + itemID + "&" + new Date().getTime();
				document.getElementById('listingImage' + itemID).src = "php/imageGet.php?id=" + itemID + "&" + new Date().getTime();
			} else {
				document.getElementById("itemEditMessage").innerHTML = this.responseText;
			}
		}
    }
	xmlhttp.send(fd);
}


function getPasswordUpdater() {
	waitForCallback('modalDetails', '/php/modalUpdatePassword.php', function(result){
	    var checkIfPasswordUpdaterIsReady = function(){
		    if($('#updatePassword').length) {
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


function getProfilePage() {
	document.getElementById("loadingBar").style.display = "block";
	isNotificationTableCollapsed = false;
	waitForCallback("pageDetails", "php/pages/userProfile.php?collapsed="+isNotificationTableCollapsed, function(result){
		//Add collapse to sidemenu
		var checkIfSideMenuIsReady = function(){
		    if(document.getElementById("pageDetails").innerHTML != "") {
		    	document.getElementById("loadingBar").style.display = "none";
		    	$("#menu-toggle").click(function(e) {
	                e.preventDefault();
	                $("#wrapper").toggleClass("toggled");
	            });
	            var updateDate = new Date();
				document.getElementById("lastUpdatedTime").innerHTML = "Last updated: " + updateDate.today() + " " + updateDate.timeNow();
	            setupAutoRefresh();
		    } else {
		        setTimeout(checkIfSideMenuIsReady, 1000); //If it is not ready then check again in 1 second
		    }
		}
		checkIfSideMenuIsReady();
	});
}


function changeNotificationCollase() {
	isNotificationTableCollapsed = !isNotificationTableCollapsed
}


Date.prototype.today = function () { 
    return ((this.getDate() < 10)?"0":"") + this.getDate() +"/"+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +"/"+ this.getFullYear();
}


Date.prototype.timeNow = function () {
     return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes() +":"+ ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
}


function removeNotification(notificationID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == "SUCCESS") {
				sendOffPHP('modalDetails','/php/modalNotifications.php');

			} else {				
				document.getElementById("notificationMsgID").innerHTML = this.responseText;
			}
		}
	}
	xmlhttp.open("GET", "/php/accountNotificationRemove.php?id="+notificationID, true);
	xmlhttp.send();
}


function addNotification() {
	var xmlhttpTEST = new XMLHttpRequest();
	xmlhttpTEST.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == "SUCCESS") {
				sendOffPHP('modalDetails','/php/modalNotifications.php');
			} else {				
				document.getElementById("notificationMsgID").innerHTML = this.responseText;
			}
		}
	}
	xmlhttpTEST.open("GET", "/php/accountNotificationAdd.php?id="+document.getElementById("notificationTags").value, true);
	xmlhttpTEST.send();
}


function autoNotification() {
	var audio = new Audio('/alert.mp3');
	var notificationTime = moment().format('YYYY-MM-DD HH:mm:ss');
	var autoNotificationInterval = setInterval(function() {
		var xmlhttpTEST = new XMLHttpRequest();
		xmlhttpTEST.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == "STOP") {
					clearInterval(autoNotificationInterval);
				} else if (this.responseText != "") {
					$("#notificationAlert").html(this.responseText);
					audio.play(); 
				}
				notificationTime = moment().format('YYYY-MM-DD HH:mm:ss');
			}
		}
		xmlhttpTEST.open("GET", "/php/notificationCheck.php?notificationTime="+notificationTime, true);
		xmlhttpTEST.send();
	}, 30000);
}


function setupAutoRefresh() {
	var autoRefreshInterval = setInterval(function() {
		if($('#notificationTable').length) {
			var xmlhttpTEST = new XMLHttpRequest();
			xmlhttpTEST.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("notificationTable").innerHTML = this.responseText;
					var updateDate = new Date();
					document.getElementById("lastUpdatedTime").innerHTML = "Last updated: " + updateDate.today() + " " + updateDate.timeNow();
				}
			};
			xmlhttpTEST.open("GET", "/php/notificationTable.php?collapsed="+isNotificationTableCollapsed, true);
			xmlhttpTEST.send();
		} else {
			clearInterval(autoRefreshInterval);
		}
	}, 180000);
}


function filterNotificationTable(tagToToggle) {
	if (notifcationFiltered == tagToToggle) {
		notifcationFiltered = null;
		$('#collapseNotifications').find('li').each(function() {
		    $(this).css({"display": ''});
		});
		$('#notificationTagFilters').find('b').each(function() {
		    $(this).css({"color": 'black'});
		});
	} else {
		notifcationFiltered = tagToToggle;
		$('#collapseNotifications').find('li').each(function() {
		    if ($(this).attr('id') != tagToToggle) {
		    	$(this).css({"display": 'none'});
		    } else { 
		    	$(this).css({"display": ''});
		    }
		});
		$('#notificationTagFilters').find('b').each(function() {
			if ($(this).attr('id') != tagToToggle) {
		    	$(this).css({"color": 'grey'});
		    } else { 
		    	$(this).css({"color": 'black'});
		    }
		});
	}
}


function getIndexPage() {
	document.getElementById("loadingBar").style.display = "block";
	waitForCallback("pageDetails", "php/pages/index.php", function(result) {
		//Add swiping to carousel
		var checkIfCarouselIsReady = function() {
		    if(document.getElementById("pageDetails").innerHTML != "") {
		    	document.getElementById("loadingBar").style.display = "none";
		       	$("#text-carousel").swiperight(function() {  
			        $(this).carousel("prev");  
			    });  
			    $("#text-carousel").swipeleft(function() {  
			        $(this).carousel("next");  
			    });
		    }
		    else {
		        setTimeout(checkIfCarouselIsReady, 1000); //If it is not ready then check again in 1 second
		    }
		}
		checkIfCarouselIsReady();
	});
}


function deleteAccount() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText.substring(0,21) != '<br><div class="alert') {
				document.getElementById("deleteAccountMessage").innerHTML = "Account deleted. Reloading site...";
				location.reload();
			} else {
				document.getElementById("deleteAccountMessage").innerHTML = this.responseText;
			}
		}
	};
	xmlhttp.open("POST", "/php/accountDelete.php", true);
	xmlhttp.send();
}


function leaveOrganisation() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText.substring(0,21) != '<br><div class="alert') {
				document.getElementById("leaveOrganisationMessage").innerHTML = "You've left the organisation...";
				document.getElementById("volOrgMenu").innerHTML = '<a data-toggle="modal" data-target="#modal-joinVol" class="no-select-link">Create/Join Volunteer Group</a>';
				document.getElementById("createLinkToOrganisationToggle").style.display = 'none';
				document.getElementById("createAddressOrgToggle").style.display = 'none';
				getProfilePage();
				setTimeout(function () {
					$('#modal-modalDetails').modal('hide');
				}, 2000);
				if (document.querySelector('input[id="createAddressOrg"]').checked == true) $("#createAddressNo").attr('checked', true).trigger('click');
			} else {
				document.getElementById("leaveOrganisationMessage").innerHTML = this.responseText;
			}
		}
	};
	xmlhttp.open("POST", "/php/accountLeaveOrganisation.php", true);
	xmlhttp.send();
}


function updatePassword() {
	document.getElementById("passwordUpdateMessage").innerHTML = "";
	password = document.getElementById("updatePassword").value;
	if (validatePassword(password) == false){
		document.getElementById("passwordUpdateMessage").innerHTML = "Please enter a vaild password or create a new account.";
	} else {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText.substring(0,21) != '<br><div class="alert') {
					document.getElementById("passwordUpdateMessage").innerHTML = "Password updated";
				} else {
					document.getElementById("modalDetails").innerHTML = this.responseText;
				}
			}
		};
		xmlhttp.open("GET", "/php/accountUpdatePassword.php?newPassword="+password, true);
		xmlhttp.send();
	}
}


function getOrganisationsPage() {
	document.getElementById("loadingBar").style.display = "block";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			createOrganisationList(JSON.parse(this.responseText), function(result){
				document.getElementById("pageDetails").innerHTML = result;
				document.getElementById("loadingBar").style.display = "none";
			});
		}
	};
	xmlhttp.open("GET", "/php/organisationGetAll.php", true);
	xmlhttp.send();
}

function getListingsPage(setListingType) {
	document.getElementById("pageDetails").innerHTML = '';
	document.getElementById("loadingBar").style.display = "block";
	waitForCallback("pageDetails", "php/pages/listings.php", function(result){
		var result = '';
		getTagList(function(obj){

			result = '<option selected="selected" value="">All</option>';
			Object.keys(obj).forEach(function(k){
				result += '<option value="' + obj[k].tagID + '">' + obj[k].name + ' (' + obj[k].totalItems + ')</option>';
	    	});
			
			var checkIfTagsAreReady = function(){
			    if($('#tagFilterList').length) {
			    	$("#tagFilterList").html(result);
			    }
			    else {
			        setTimeout(checkIfTagsAreReady, 1000); //If it is not ready then check again in 1 second
			    }
			}
			checkIfTagsAreReady();
			listingType = setListingType;
			getAllListings("listingArea",false);
			document.getElementById("loadingBar").style.display = "none";
		});
	});
}


function waitForCallback(positionID,phpFile,callback){
	callback(sendOffPHP(positionID, phpFile));
}


$('.dropdown-content').click(function(e) {
    e.stopPropagation();
});


function getAllListings(postionID,callSearch) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			filterArray(JSON.parse(this.responseText),$("#tagFilterList").val(),$("input[name='statusFilter']:checked").val(), function(filteredArray){
				createItemList(filteredArray, function(result){
					document.getElementById(postionID).innerHTML = result;
					activateLazyLoad();
					if (callSearch) {
						searchTables();
					}
				});
			});
		}
	};
	phpFile = "php/itemGetAll.php?type=" + listingType;
	xmlhttp.open("GET", phpFile, true);
	xmlhttp.send();
}


function sendOffPHP(elementID, phpDetails) {
	document.getElementById(elementID).innerHTML = '';
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById(elementID).innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", phpDetails, true);
	xmlhttp.send();
}


function activateLazyLoad() {
	$('.lazy').Lazy({
		effect: 'fadeIn',
		effectTime: 500,
		visibleOnly: true
	});
}


function searchTables() {
    var input, filter, ul, li, a, i;
    input = document.getElementById('searchValue');
    filter = input.value.toUpperCase();
    ul = document.getElementById("tableList");
    li = ul.getElementsByTagName('li');

    for (i = 0; i < li.length; i++) {
        a = li[i];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }

    if (filter == "") {
    	for (i = 1; i <= totalListingsPage; i++) { 
    		$('#listingPage' + i).hide();
    	}
    	$('#listingPage' + currentListingsPage).show();
    	$('.listingButton').show();
    } else {
    	for (i = 1; i <= totalListingsPage; i++) { 
    		$('#listingPage' + i).show();
    		var pageVis = false;
    		$('#listingPage' + i + '> li').each(function () {
    			if ($(this).is(":visible")) pageVis = true;
	    	});
	    	if (pageVis == false) $('#listingPage' + i).hide();
    	}
    	$('.listingButton').hide();
    }
    activateLazyLoad();
}


function checkLoginSuccess() {
	email = document.getElementById("loginEmail").value;
	password = document.getElementById("loginPassword").value;
	//SHA256(document.getElementById("password").value)

	//Validation
	if (validateEmail(email) == false){
		document.getElementById("loginMessage").innerHTML = "Please enter a vaild email or create a new account.";
		return false;
	}
	if (validatePassword(password) == false){
		document.getElementById("loginMessage").innerHTML = "Please enter a vaild password or create a new account.";
		return false;
	}
	document.getElementById("loginMessage").innerHTML = "Logging in...";

	//Check if login is successful
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == "success"){
				document.getElementById("loginMessage").innerHTML = "You have been logged in";
				window.location.reload(false); 
			} else {
				document.getElementById("loginMessage").innerHTML = this.responseText;
				return false;
			}			
		}
	};
	xmlhttp.open("GET", "/php/accountLogin.php?email="+email+"&password="+password, true);
	xmlhttp.send();
}


function accountCreationError(errorMessage) {
	document.getElementById("accountCreationMessage").innerHTML = '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
           	'<span aria-hidden="true">×</span>' +
        '</button>' +
           	'<p>'+errorMessage+'</p>' +
           	'<p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>' +
    '</div>';
}


function checkAccountCreationSuccess() {
	document.getElementById("accountCreationMessage").innerHTML = "";
	email = document.getElementById("newEmail").value;
	password = document.getElementById("newPassword").value;
	confirmPassword = document.getElementById("newConfirm").value;
	firstName = document.getElementById("newFirstName").value;
	lastName = document.getElementById("newLastName").value;
	//SHA256(document.getElementById("password").value)

	//Validation
	if (validateEmail(email) == false) {
		accountCreationError("Invalid email address");
	} else if (password != confirmPassword) {
        accountCreationError("Your passwords do not match");
	} else if (validateEmail(email) == false) {
        accountCreationError("You can not use your email as your password");
	} else if (validatePassword(password) == false || validatePassword(confirmPassword) == false) {
        accountCreationError("Invalid password");
	} else if (validateName(firstName) == false) {
        accountCreationError("Invalid first name");
	} else if (validateName(lastName) == false) {
        accountCreationError("Invalid last name");
	} else {

		//Check if login is successful
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == "success") {
					window.location.reload(false);
				} else {
					document.getElementById("accountCreationMessage").innerHTML = this.responseText;
				}			
			}
		};
		xmlhttp.open("GET", "/php/accountCreate.php?email="+email+"&password="+password+"&firstName="+firstName+"&lastName="+lastName, true);
		xmlhttp.send();
	}
}


function joinVolunteerGroup() {
	document.getElementById("volOrgJoinMessage").innerHTML = "";
	organisationIDToLink = document.getElementById("volOrgList").value;
	organisationSelectID = document.getElementById("volOrgList");
	organisationName = organisationSelectID.options[organisationSelectID.selectedIndex].text;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == "success") {
				document.getElementById("volOrgMenu").innerHTML = '<a class="no-button no-select-link" onclick="getOrganisationModal(' + organisationIDToLink + ')" data-toggle="modal" data-target="#modal-modalDetails">Your Volunteer Group</a>';
				document.getElementById("volOrgJoinMessage").innerHTML = "<p>You have joined "+organisationName+".</p><p>Loading organisation page...</p>";
				document.getElementById("createLinkToOrganisationToggle").style.display = 'inline-block';
				document.getElementById("createAddressOrgToggle").style.display = 'inline-block';
				getProfilePage();
				getOrganisationModal(organisationIDToLink);
				setTimeout(function () {
					$('#modal-joinVol').modal('hide');
					$('#modal-modalDetails').modal('show');
					document.getElementById("volOrgJoinMessage").innerHTML = "";					
			    }, 1000);				
			} else {
				document.getElementById("volOrgJoinMessage").innerHTML = this.responseText;
			}			
		}
	}
	xmlhttp.open("POST", "/php/accountLinkOrganisation.php?groupID="+organisationIDToLink, true);
	xmlhttp.send(); 
}


function createVolunteerGroup() {
	document.getElementById("volOrgCreateMessage").innerHTML = "";
	newOrganisationName = document.getElementById("volOrgName").value;
	newOrganisationInformation = document.getElementById("volOrgInformation").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText.substring(0,21) != '<br><div class="alert') {
				document.getElementById("volOrgMenu").innerHTML = '<a class="no-select-link"><a class="no-button no-select-link" onclick="getOrganisationModal(' + this.responseText + ')" data-toggle="modal" data-target="#modal-modalDetails">Your Volunteer Group</a></a></li></ul>';
				$('#modal-createVol').modal('hide');
			} else {
				document.getElementById("volOrgCreateMessage").innerHTML = this.responseText;
			}			
		}
	}
	xmlhttp.open("POST", "/php/organisationCreate.php?volOrgName="+newOrganisationName+"&volOrgInformation="+newOrganisationInformation, true);
	xmlhttp.send();
}


function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}


function validatePassword(password) {
    var re = /^[A-Za-z]\w{7,15}$/;  
    return re.test(password);
}


function validateName(name) {
    var re = /^[A-Za-z]\w{1,50}$/;  
    return re.test(name);
}


function logout() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			window.location.reload(false);
		}
	};
	xmlhttp.open("POST", "/php/accountLogout.php", true);
	xmlhttp.send();
}


function getItemModal(itemID) {
	document.getElementById("modalDetails").innerHTML = '<img class="loading" src="/img/loading.gif" alt="Loading items...">';
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == ""){
				document.getElementById("modalDetails").innerHTML = "There was an error getting the details for this item";
			} else {
				$("#modalDetails").html(this.responseText);
				$('#datetimepicker2').datetimepicker({
					sideBySide: true,
					minDate: moment().format("YYYY-MM-DD"),
					defaultDate: moment().format("YYYY-MM-DD")
				});
			}			
		}
	};
	xmlhttp.open("GET", "/php/itemGetModalInfo.php?id="+itemID, true);
	xmlhttp.send();
}


function getOrganisationModal(organisationID) {
	document.getElementById("modalDetails").innerHTML = '<img class="loading" src="/img/loading.gif" alt="Loading items...">';
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == ""){
				document.getElementById("modalDetails").innerHTML = "There was an error getting the details for this organisation";
			} else {
				document.getElementById("modalDetails").innerHTML = this.responseText;
			}
		}
	};
	xmlhttp.open("GET", "/php/organisationGetModalInfo.php?id="+organisationID, true);
	xmlhttp.send();
}


function isNormalInteger(str) {
    var n = Math.floor(Number(str));
    return String(n) === str && n >= 0;
}


function createNewListing() {
	var createNewListingButton = document.getElementById("createNewListingButton");
	createNewListingButton.disabled = true;
	var createTitle = document.getElementById("createTitle");
	var createDescription = document.getElementById("createDescription");
	var createTagID = document.getElementById("createTagID");
	var createCategory = document.getElementById("createCategory");
	var createEndtime = document.getElementById("createDateTime");
	var createPerishable = document.querySelector('input[name="createPerishable"]:checked');
	var createLinkToOrganisation = document.querySelector('input[name="createLinkToOrganisation"]:checked');
	if (document.querySelector('input[name="createAddress"]:checked').value == "[Custom]") {
		var createShowMap = document.getElementById("createCustomAdress").value;

	} else {
		var createShowMap = document.querySelector('input[name="createAddress"]:checked').value;
	}
	if (createTitle.value != "" & createDescription.value != "" & createTagID.value != "" & createCategory.value != "" & createEndtime.value != "" & createShowMap.value != ""){
		document.getElementById("createListingMessage").innerHTML = "Creating listing...";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (isNormalInteger(this.responseText)) {
					var itemNum = this.responseText;
					document.getElementById("createListingMessage").innerHTML = "Item created. Redirecting you to the item...";
					document.getElementById("pageDetails").innerHTML = "";
					listingsPageCallback(function(callback){
						getItemModal(itemNum);
						var checkIfListingPageIsReady = function(){
						    if(document.getElementById("pageDetails").innerHTML != "") {
						    	if (lastlistingPage > 1){
									changePageVisibility("listingPage"+lastlistingPage,"listingPage1");
								}
								$('#modal-createListing').modal('hide');
								$('#modal-modalDetails').modal('show');
								setTimeout(function () {
									createNewListingButton.disabled = false;
									createTitle.value = "";
									createDescription.value = "";
									createTagID.selectedIndex = "0";
									createCategory.selectedIndex = "0";
									document.getElementById("createListingMessage").innerHTML = "";
					    		}, 3000);	
						    }
						    else {
						        setTimeout(checkIfListingPageIsReady, 1000); //If it is not ready then check again in 1 second
						    }
						}
						checkIfListingPageIsReady();
					});
				} else {
					document.getElementById("createListingMessage").innerHTML = this.responseText;
					createNewListingButton.disabled = false;
				}			
			}
		};
		xmlhttp.open("GET", "/php/itemCreate.php?title="+createTitle.value+"&tagID="+createTagID.value+"&description="+createDescription.value+"&category="+createCategory.value+"&endtime="+createEndtime.value+"&perishable="+createPerishable.value+"&linkToOrg="+createLinkToOrganisation.value+"&mapLocation="+createShowMap, true);
		xmlhttp.send();
	} else {
		document.getElementById("createListingMessage").innerHTML = '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
               	'<span aria-hidden="true">×</span>' +
            '</button>' +
               	'<p>All fields must be filled out</p>' +
               	'<p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>' +
        '</div>';
		document.getElementById("createNewListingButton").disabled = false;
	}
}



function listingsPageCallback(callback){
	callback(getListingsPage('php/itemGetAll.php'));
}


function changeHiddenState() {
    var itemD = document.getElementById("itemInfo");
    var itemE = document.getElementById("itemEditing");
    document.getElementById("itemInfoMessage").innerHTML = "";
    
    if (itemD.style.display === 'none') {
        itemD.style.display = 'block';
        itemE.style.display = 'none';
    } else {
        itemE.style.display = 'block';
        itemD.style.display = 'none';
    }
}


function getXMLHttpRequest() {
    if (window.XMLHttpRequest) {
        return new window.XMLHttpRequest;
    } else {
        try {
            return new ActiveXObject("MSXML2.XMLHTTP.3.0");
        } catch(ex) {
            return null;
        }
    }
}


function changeStatus(itemID, newItemStatus) {
	document.getElementById("itemInfoMessage").innerHTML = "";
	var xmlhttp = getXMLHttpRequest();
    xmlhttp.open("GET", "/php/itemStatusChange.php?id="+itemID+"&status="+newItemStatus, true);
    xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == "success") {
				getItemModal(itemID);
				updateItemTable(itemID);
			} else {
				document.getElementById("itemInfoMessage").innerHTML = this.responseText;
			}			
		}
	}
    xmlhttp.send();
}


function removeListing(itemID) {
	document.getElementById("itemEditMessage").innerHTML = "";
	var removeListingCheck = confirm("Are you sure you want to remove this listing?");
	if (removeListingCheck == true) {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == "success") {
					//UPDATE HERE
					$('#modal-modalDetails').modal('hide');
				} else {
					document.getElementById("itemEditMessage").innerHTML = this.responseText;
				}			
			}
		};
		xmlhttp.open("POST", "/php/itemDelete.php?id="+itemID, true);
		xmlhttp.send();
	}
}


function editListing(itemID) {
	document.getElementById("itemEditMessage").innerHTML = "";
	var newDescription = document.getElementById("newDescription");
	var newTitle = document.getElementById("newTitle");
	var newCategory = document.getElementById("newCategory");
	var newDateTime = document.getElementById("newDateTime");
	if (newDescription.value != "" && newTitle.value != "" && newDateTime.value != "" ){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == "success") {
					getItemModal(itemID);
					updateItemTable(itemID);
				} else {
					document.getElementById("itemEditMessage").innerHTML = this.responseText;
				}			
			}
		};
		xmlhttp.open("GET", "/php/itemEdit.php?id="+itemID+"&title="+newTitle.value+"&description="+newDescription.value+"&category="+newCategory.value+"&endtime="+newDateTime.value, true);
		xmlhttp.send();
	} else {
		document.getElementById("itemEditMessage").innerHTML = '<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><p>All fields must not be empty!</p><p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p></div>';
	}
}


function updateItemTable(itemID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText != "failed") {
				getItemModal(itemID);
				if (document.getElementById("itemTableID"+itemID) != null){
					createItemTable(JSON.parse(this.responseText), function(result){
						document.getElementById("itemTableID"+itemID).innerHTML = result;
						activateLazyLoad();
					});
				}
			} else {
				location.reload();
			}			
		}
	};
	xmlhttp.open("GET", "/php/itemGetSingle.php?id="+itemID, true);
	xmlhttp.send();
}


function loginRequiredMessage(requiredCheck) {
	if (requiredCheck == true){
		document.getElementById("loginMessage").innerHTML = "You must be logged in before you can create a listing";
	} else {
		document.getElementById("loginMessage").innerHTML = "";
	}
}


function getTagList(callback) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			callback(JSON.parse(this.responseText));
		}
	};
	xmlhttp.open("GET", "/php/tagGetAll.php", true);
	xmlhttp.send();
}


function filterArray(arrayToFilter,tagFilter,finishedFilter,callback) {
	var filteredArray = arrayToFilter;
	if (tagFilter != "") {
		filteredArray = filteredArray.filter(function( obj ) {
		  	return obj.FKtagID == tagFilter;
		});
	}
	if (finishedFilter != "") {
		filteredArray = filteredArray.filter(function( obj ) {
		  	return obj.finished == finishedFilter;
		});
	}

	callback(filteredArray);
}

function isInteger(num) {
  	return (num ^ 0) === num;
}


function createItemList(obj, callback) {
	var listingsStr = "";
	var currentPage = 1;
	var currentItem = 0;
	var itemsPerPage = 20;
	var numOfItemsInObj = Object.keys(obj).length;
	var maxPage = Math.ceil(numOfItemsInObj / itemsPerPage);
	lastlistingPage = maxPage;

	listingsStr += '<ul id="tableList">';
	listingsStr += '<div id="listingPage' + currentPage + '" style="display: block">';
	createChangePageButtons('listingPage',currentPage,maxPage, function(result){
		listingsStr += result;
	});

	Object.keys(obj).forEach(function(k){
		var tempa = currentItem / itemsPerPage;
		if (isInteger(tempa) && currentItem != 0){
			createChangePageButtons('listingPage',currentPage,maxPage, function(result){
				listingsStr += result;
				currentPage++;			
				listingsStr += '<br></div><div id="listingPage' + currentPage + '" style="display: none">';
				createChangePageButtons('listingPage',currentPage,maxPage, function(result){
					listingsStr += result;
				});
			});
		}

		currentItem++;
		listingsStr += '<li id="itemTableID' + obj[k].itemID + '">';
		createItemTable(obj[k], function(result){
			listingsStr += result;
			listingsStr += '</li>';
		});
	});
	
	totalListingsPage = currentPage;
	createChangePageButtons('listingPage',currentPage,maxPage, function(result){
		listingsStr += result;
	});

	listingsStr += '</div></ul>';
	callback(listingsStr);
}


function createItemTable(itemObj, callback){
	var newItemTable = "";
	newItemTable += '<div class="table-responsive table-padding noUnderline">';
      	newItemTable += '<table class="table table-striped table-hover cursorPointer" onclick="getItemModal(' + itemObj.itemID + ')" data-toggle="modal" data-target="#modal-modalDetails">';
      	
	      	newItemTable += '<tbody>';
	      		newItemTable += '<tr class="table-bordered">';
		      		newItemTable += '<td colspan="2" ';
		      			switch (itemObj.finished) {
		            		case "0":
		                        newItemTable += 'class="available" value="available">';
		            			break;
		            		case "1":
		                        newItemTable += 'class="wanted" value="wanted">';
		            			break;
		            		default:
		                        newItemTable += 'class="primary" value="finished">';
		            	}
						newItemTable += '<h2>' + itemObj.name + '</h2>';
		      		newItemTable += '</td>';
	      		newItemTable += '</tr>';

	      		newItemTable += '<tr class="table-bordered">';
		      		newItemTable += '<td class="tableImage" style="padding:0px">';
		      			newItemTable += '<img id="listingImage' + itemObj.itemID + '" class="lazy" style="display:block" data-src="php/imageGet.php?id=' + itemObj.itemID + '&' + new Date().getTime() + '"  width="140" height="120" alt="' + itemObj.imgTag + '">';
		      		newItemTable += '</td>';

		      		newItemTable += '<td class="table-listings">';
		      			if (itemObj.description.length > 200){
		      				newItemTable += itemObj.description.substring(0,200) + '...<br>';	
		      			}
		      			else{
		      				newItemTable += itemObj.description + '<br>';
		      			}
		      			newItemTable += '<a>Read more...</a>';
		      		newItemTable += '</td>';
	      		newItemTable += '</tr>';
	      	newItemTable += '</tbody>';
	      	
      	newItemTable += '</table>';
  	newItemTable += '</div>';
  	callback(newItemTable);
}

$('#datetimepicker').datetimepicker();

function createOrganisationList(obj, callback){
	var currentPage = 1;
	var currentOrg = 0;
	var orgsPerPage = 20;
	var organisationsStr;
	var numOfItemsInObj = Object.keys(obj).length;
	var maxPage = Math.ceil(numOfItemsInObj / orgsPerPage);

	organisationsStr = '<div class="center wrapper">';
	organisationsStr += '<input type="text" id="searchValue" onkeyup="searchTables()" placeholder="Search for organisation..">';
	organisationsStr += '<ul id="tableList">';
	organisationsStr += '<div id="listingPage' + currentPage + '" style="display: block">';

	createChangePageButtons('listingPage',currentPage,maxPage, function(result){
		organisationsStr += result;
	});

	Object.keys(obj).forEach(function(k){
		var tempa = currentOrg / orgsPerPage;
		if (isInteger(tempa) && currentOrg != 0){			
			createChangePageButtons('listingPage',currentPage,maxPage, function(result){
				organisationsStr += result;
				currentPage++;			
				organisationsStr += '<br></div><div id="listingPage' + currentPage + '" style="display: none">';
				createChangePageButtons('listingPage',currentPage,maxPage, function(result){
					organisationsStr += result;
				});
			});
		}

		currentOrg++;
		organisationsStr += '<li id="organisationTableID' + obj[k].itemID + '">';
		createOrganisationTable(obj[k], function(result){
			organisationsStr += result;
			organisationsStr += '</li>';
		});
	});
	
	totalListingsPage = currentPage;
	createChangePageButtons('listingPage',currentPage,maxPage, function(result){
		organisationsStr += result;
	});

	organisationsStr += '</div></ul>';
	callback(organisationsStr);
}


function createOrganisationTable(organisationObj, callback){
	var newOrganisationTable = "";
	newOrganisationTable += '<div class="table-responsive table-padding cursorPointer">';
	newOrganisationTable += '<a type="button" class="table-button noUnderline" onclick="getOrganisationModal(' + organisationObj.groupID + ')" data-toggle="modal" data-target="#modal-modalDetails">';
  	newOrganisationTable += '<table class="table table-striped table-bordered table-hover table-restrict-size"">';
  	newOrganisationTable += '<thead>';
  	newOrganisationTable += '<tr><td><b>' + organisationObj.name + '</b></td></tr>';
  	newOrganisationTable += '</thead>';
  	newOrganisationTable += '<tbody>';
  	newOrganisationTable += '<tr><td class="table-listings">';
  	if (organisationObj.Information.length > 200){
		newOrganisationTable += organisationObj.Information.substring(0,200) + '...<br>';	
	} else {
		newOrganisationTable +=  organisationObj.Information + '<br>';
	}
  	newOrganisationTable += '<a>Read more...</a></td></tr>';
  	newOrganisationTable += '</tbody>';
  	newOrganisationTable += '</table>';
  	newOrganisationTable += '</a>';
  	newOrganisationTable += '</div>';
  	callback(newOrganisationTable);
}


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


function changePageVisibility(newPage,previousPage){
	document.getElementById(previousPage).style.display = "none";
	document.getElementById(newPage).style.display = "block";
	activateLazyLoad();
	window.scrollTo(0, 0);
}