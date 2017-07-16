var currentListingsPage = 1;
var totalListingsPage = 1;
var indexData = null;
var lastItemPage = 0;

$(function () {

	//Load navBar
	document.getElementById("loadingBar").style.display = "block";
	var xmlhttpTEST = new XMLHttpRequest();
	xmlhttpTEST.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("navBar").innerHTML = this.responseText;
			$('#datetimepicker1').datetimepicker({
				sideBySide: true
			});
			document.getElementById("loadingBar").style.display = "none";
		}
	};
	xmlhttpTEST.open("GET", "/php/navBar.php", true);
	xmlhttpTEST.send();

	getIndexPage();
});


function getProfilePage() {
	document.getElementById("loadingBar").style.display = "block";
	waitForCallback("pageDetails", "php/pages/userProfile.php", function(result){
		//Add collapse to sidemenu
		var checkIfSideMenuIsReady = function(){
		    if(document.getElementById("pageDetails").innerHTML != "") {
		    	document.getElementById("loadingBar").style.display = "none";
		    	$("#menu-toggle").click(function(e) {
	                e.preventDefault();
	                $("#wrapper").toggleClass("toggled");
	            });
	            setupAutoRefresh();
		    }
		    else {
		        setTimeout(checkIfSideMenuIsReady, 1000); //If it is not ready then check again in 1 second
		    }
		}
		checkIfSideMenuIsReady();
	});
}


function setupAutoRefresh() {
	var autoRefreshInterval = setInterval(function(){
		if($('#selector').length) {
			var xmlhttpTEST = new XMLHttpRequest();
			xmlhttpTEST.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("notificationTable").innerHTML = this.responseText;
				}
			};
			xmlhttpTEST.open("GET", "/php/notificationTable.php", true);
			xmlhttpTEST.send();
		} else {
			clearInterval(autoRefreshInterval);
		}
	}, 180000);
}


function getIndexPage() {
	document.getElementById("loadingBar").style.display = "block";
	waitForCallback("pageDetails", "php/pages/index.php", function(result){
		//Add swiping to carousel
		var checkIfCarouselIsReady = function(){
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


function updatePassword() {
	document.getElementById("passwordUpdateMessage").innerHTML = "";
	password = document.getElementById("updatePassword").value;
	if (validatePassword(password) == false){
		document.getElementById("passwordUpdateMessage").innerHTML = "Please enter a vaild password or create a new account.";
	} else {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText.substring(0,5) != "Error") {
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

function getListingsPage(listingType) {
	document.getElementById("pageDetails").innerHTML = '';
	document.getElementById("loadingBar").style.display = "block";
	waitForCallback("pageDetails", "php/pages/listings.php", function(result){
		var result = '';
		getTagList(function(obj){
			result = '<option selected="selected" value="">All</option>';
			Object.keys(obj).forEach(function(k){
				result += '<option value="' + obj[k].tagID + '">' + obj[k].name + ' (' + obj[k].totalItems + ')</option>';
	    	});
			$("#tagFilterList").html(result);
			console.log(result);
			getAllListings("listingArea",listingType,false);
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


function getAllListings(postionID,phpFile,callSearch) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			filterArray(JSON.parse(this.responseText),$("#tagFilterList").val(),$("input[name='statusFilter']:checked").val(), function(filteredArray){
				createItemList(filteredArray, function(result){
					document.getElementById(postionID).innerHTML = result;
					activateLazyLoad();
					if (callSearch) {
						searchItemTables();
					}
				});
			});
		}
	};
	xmlhttp.open("GET", phpFile, true);
	xmlhttp.send();
}


function sendOffPHP(elementID, phpDetails) {
	document.getElementById(elementID).innerHTML = '';
	//document.getElementById("loadingBar").style.display = "block";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById(elementID).innerHTML = this.responseText;
			//document.getElementById("loadingBar").style.display = "none";
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


function searchItemTables() {
    var input, filter, ul, li, a, i;
    input = document.getElementById('searchValue');
    filter = input.value.toUpperCase();
    ul = document.getElementById("tableList");
    li = ul.getElementsByTagName('li');

    if (filter == "") {
    	for (i = 1; i <= totalListingsPage; i++) { 
    		var tempVis = document.getElementById('itemPage' + i);
    		tempVis.style.display = "none";
    	}
    	tempVis = document.getElementById('itemPage' + currentListingsPage);
    	tempVis.style.display = "block";  
    	$('.listingButton').show();
    } else {
    	
    	for (i = 1; i <= totalListingsPage; i++) { 
    		var tempVis = document.getElementById('itemPage' + i);
    		tempVis.style.display = "block";
    	}
    	$('.listingButton').hide();
    }

    for (i = 0; i < li.length; i++) {
        a = li[i];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }

    activateLazyLoad();
}


function searchOrgTables() {
	var input, filter, ul, li, a, i;
	input = document.getElementById('searchValue');
    filter = input.value.toUpperCase();
    ul = document.getElementById("tableList");
    li = ul.getElementsByTagName('li');
    
	for (i = 0; i < li.length; i++) {
        a = li[i];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
            li[i].style.display
        } else {
            li[i].style.display = "none";
        }
    }
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
	xmlhttp.open("GET", "/php/login_user.php?email="+email+"&password="+password, true);
	xmlhttp.send();
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
		document.getElementById("accountCreationMessage").innerHTML = "Invalid email address.";
		return false;
	}
	
	if (validatePassword(password) == false || validatePassword(confirmPassword) == false) {
		document.getElementById("accountCreationMessage").innerHTML = "Invalid passwords.";
		return false;
	}

	if (password != confirmPassword) {
		document.getElementById("accountCreationMessage").innerHTML = "Your passwords do not match.";
		return false;
	}

	if (validateName(firstName) == false) {
		document.getElementById("accountCreationMessage").innerHTML = "Invalid first name.";
		return false;
	}

	if (validateName(lastName) == false) {
		document.getElementById("accountCreationMessage").innerHTML = "Invalid last name.";
		return false;
	}

	//Check if login is successful
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == "success") {
				window.location.reload(false);
			} else {
				document.getElementById("accountCreationMessage").innerHTML = this.responseText;
				return false;
			}			
		}
	};
	xmlhttp.open("GET", "/php/accountCreate.php?email="+email+"&password="+password+"&firstName="+firstName+"&lastName="+lastName, true);
	xmlhttp.send();
}


function joinVolunteerGroup() {
	document.getElementById("volOrgJoinMessage").innerHTML = "";
	organisationIDToLink = document.getElementById("volOrgList").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText.substring(0,5) != "Error") {
				document.getElementById("volOrgMenu").innerHTML = '<a class="no-select-link"><button class="no-button no-select-link" onclick="getOrganisationModal(' + organisationIDToLink + ')" data-toggle="modal" data-target="#modal-modalDetails">Your Volunteer Group</button></a></li></ul>';
				$('#modal-createVol').modal('hide');
			} else {
				document.getElementById("volOrgJoinMessage").innerHTML = this.responseText;
				console.log("FAILED");
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
			if (this.responseText.substring(0,5) != "Error") {
				document.getElementById("volOrgMenu").innerHTML = '<a class="no-select-link"><button class="no-button no-select-link" onclick="getOrganisationModal(' + this.responseText + ')" data-toggle="modal" data-target="#modal-modalDetails">Your Volunteer Group</button></a></li></ul>';
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
	xmlhttp.open("POST", "/php/logout.php", true);
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
				document.getElementById("modalDetails").innerHTML = this.responseText;
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
				document.getElementById("modalDetails").innerHTML = "There was an error getting the details for this item";
			} else {
				document.getElementById("modalDetails").innerHTML = this.responseText;
			}			
		}
	};
	xmlhttp.open("GET", "/php/organisationGetModalInfo.php?id="+organisationID, true);
	xmlhttp.send();
}


function createNewListing() {
	var createNewListingButton = document.getElementById("createNewListingButton");
	createNewListingButton.disabled = true;
	var createTitle = document.getElementById("createTitle");
	var createDescription = document.getElementById("createDescription");
	var createTagID = document.getElementById("createTagID");
	var createCategory = document.getElementById("createCategory");
	var createEndtime = new Date();//document.getElementById("createEndtime"); temp hard code

	if (createTitle.value != "" & createDescription.value != "" & createTagID.value != "" & createCategory.value != "" & createEndtime.value != ""){
		document.getElementById("createListingMessage").innerHTML = "Creating listing...";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == "failed") {
					document.getElementById("createListingMessage").innerHTML = "Failed to create listing";
					createNewListingButton.disabled = false;
				} else {
					var itemNum = this.responseText;
					clearModal(function(){
						$('#modal-createListing').modal('hide');
						getItemModal(itemNum);
						$('#modal-modalDetails').modal('show');
						createNewListingButton.disabled = false;
						createTitle.value = "";
						createDescription.value = "";
						createTagID.selectedIndex = "0";
						createCategory.selectedIndex = "0";
						document.getElementById("createListingMessage").innerHTML = "";
					});					
				}			
			}
		};
		xmlhttp.open("GET", "/php/itemCreate.php?title="+createTitle.value+"&tagID="+createTagID.value+"&description="+createDescription.value+"&category="+createCategory.value+"&endtime="+createEndtime.value, true);
		xmlhttp.send();
	} else {
		document.getElementById("createListingMessage").innerHTML = "All fields must be filled out";
		document.getElementById("createNewListingButton").disabled = false;
	}
}

function clearModal(callback){
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
	if (xmlhttp != null) {
	    xmlhttp.open("GET", "/php/itemStatusChange.php?id="+itemID+"&status="+newItemStatus, true);
	    xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == "success") {
					getItemModal(itemID);
					updateItemTable(itemID);
				} else {
					console.log(this.responseText);
					document.getElementById("itemInfoMessage").innerHTML = this.responseText;
				}			
			}
		}
	    xmlhttp.send();
	}
	else {
	    console.log("AJAX (XMLHTTP) not supported.");
	}
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
		xmlhttp.open("POST", "/php/removeListing.php?id="+itemID, true);
		xmlhttp.send();
	}
}


function editListing(itemID) {
	console.log("FIRED");
	document.getElementById("itemEditMessage").innerHTML = "";
	var newDescription = document.getElementById("newDescription");
	var newTitle = document.getElementById("newTitle");
	var newCategory = document.getElementById("newCategory");
	//tagID

	if (newDescription.value != ""){
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
		xmlhttp.open("GET", "/php/itemEdit.php?id="+itemID+"&title="+newTitle.value+"&description="+newDescription.value+"&category="+newCategory.value, true);
		xmlhttp.send();
	} else {
		document.getElementById("itemEditMessage").innerHTML = "Information fields must not be empty";
	}
	
}


function updateItemTable(itemID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText != "failed") {
				getItemModal(itemID);
				createItemTable(JSON.parse(this.responseText), function(result){
					document.getElementById("itemTableID"+itemID).innerHTML = result;
					activateLazyLoad();
				});
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
	lastItemPage = maxPage;

	listingsStr += '<ul id="tableList">';
	listingsStr += '<div id="itemPage' + currentPage + '" style="display: block">';
	createChangePageButtons('itemPage',currentPage,maxPage, function(result){
		listingsStr += result;
	});

	Object.keys(obj).forEach(function(k){
		var tempa = currentItem / itemsPerPage;
		if (isInteger(tempa) && currentItem != 0){
			createChangePageButtons('itemPage',currentPage,maxPage, function(result){
				listingsStr += result;
				currentPage++;			
				listingsStr += '<br></div><div id="itemPage' + currentPage + '" style="display: none">';
				createChangePageButtons('itemPage',currentPage,maxPage, function(result){
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
	createChangePageButtons('itemPage',currentPage,maxPage, function(result){
		listingsStr += result;
	});

	listingsStr += '</div></ul>';
	callback(listingsStr);
}


function createItemTable(itemObj, callback){
	var newItemTable = "";
	newItemTable += '<div class="table-responsive table-padding">';
		newItemTable += '<button type="button" class="table-button" onclick="getItemModal(' + itemObj.itemID + ')" data-toggle="modal" data-target="#modal-modalDetails">';
	      	newItemTable += '<table class="table table-striped table-bordered table-hover">';
	      	
		      	newItemTable += '<tbody>';
		      		newItemTable += '<tr><td ';
		      			switch (itemObj.finished) {
		            		case "0":
		                        newItemTable += 'class="available" value="available">';
		            			break;
		            		case "1":
		                        newItemTable += 'class="wanted" value="wanted">';
		            			break;
		            		default:
		                        newItemTable += 'class="finished" value="finished">';
		            	}
						newItemTable += '<h2>' + itemObj.name + '</h2>';
		      		newItemTable += '</td>';

		      		newItemTable += '<td rowspan="2" class="tableImage">';
		      			newItemTable += '<img class="lazy" data-src="php/imageGet.php?id=' + itemObj.itemID + '"  width="120" height="110" alt="TEST">';
		      		newItemTable += '</td>';

		      		newItemTable += '</tr>';
		      		newItemTable += '<tr><td class="table-listings">';
		      			if (itemObj.description.length > 200){
		      				newItemTable += itemObj.description.substring(0,200) + '...<br>';	
		      			}
		      			else{
		      				newItemTable += itemObj.description + '<br>';
		      			}
		      			newItemTable += '<a>Read more...</a>';
		      		newItemTable += '</td></tr>';
		      	newItemTable += '</tbody>';
		      	
	      	newItemTable += '</table>';
      	newItemTable += '</button>';
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
	organisationsStr += '<input type="text" id="searchValue" onkeyup="searchOrgTables()" placeholder="Search for organisation..">';
	organisationsStr += '<ul id="tableList">';
	organisationsStr += '<div id="organisationPage' + currentPage + '" style="display: block">';

	createChangePageButtons('organisationPage',currentPage,maxPage, function(result){
		organisationsStr += result;
	});

	Object.keys(obj).forEach(function(k){
		var tempa = currentOrg / orgsPerPage;
		if (isInteger(tempa) && currentOrg != 0){			
			createChangePageButtons('organisationPage',currentPage,maxPage, function(result){
				organisationsStr += result;
				currentPage++;			
				organisationsStr += '<br></div><div id="organisationPage' + currentPage + '" style="display: none">';
				createChangePageButtons('organisationPage',currentPage,maxPage, function(result){
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
	createChangePageButtons('organisationPage',currentPage,maxPage, function(result){
		organisationsStr += result;
	});

	organisationsStr += '</div></ul>';
	callback(organisationsStr);
}


function createOrganisationTable(organisationObj, callback){
	var newOrganisationTable = "";
	newOrganisationTable += '<div class="table-responsive table-padding" >';
	newOrganisationTable += '<button type="button" class="table-button" onclick="getOrganisationModal(' + organisationObj.groupID + ')" data-toggle="modal" data-target="#modal-modalDetails">';
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
  	newOrganisationTable += '</button>';
  	newOrganisationTable += '</div>';
  	callback(newOrganisationTable);
}


function createChangePageButtons(pageType,currentPage,maxPage,callback){
	var pageButtons = "";
	//maxButtons Must be an odd number
	var maxButtons = 7;

	if (maxPage > 1){
		pageButtons += '<div id="organisationButton" class="listingButton testing">';
		pageButtons += '<ul class="pagination pagination-lg">';

		//If it is the first page then put up to the next 4 pages (If more than maxButtons pages then make the 5th page the last page)
		if (currentPage == 1){
			pageButtons += '<li><button disabled>1</button></li>';
			if (maxPage > maxButtons){
				for(var i = 2; i < maxButtons; i++){
					pageButtons += '<li><button onclick="changePageVisibility(' + (pageType + i) + ',' + (pageType + currentPage) + ')">' + i + '</button></li>';
				}
				pageButtons += '<li><button onclick="changePageVisibility(' + (pageType + maxPage) + ',' + (pageType + currentPage) + ')">' + maxPage + '</button></li>';
			} else {
				for(var i = 2; i <= maxPage; i++){
					pageButtons += '<li><button onclick="changePageVisibility(' + (pageType + i) + ',' + (pageType + currentPage) + ')">' + i + '</button></li>';
				}
			}
		
		//If it is the last page then put up to the previous 4 pages (If more than maxButtons pages then make the 1st page the first page)
		} else if(currentPage == maxPage) {
			pageButtons += '<li><button onclick="changePageVisibility(' + (pageType + '1') + ',' + (pageType + currentPage) + ')">1</button></li>';
			if (maxPage > maxButtons){
				for(var i = currentPage - (maxButtons-2); i < currentPage; i++){
					pageButtons += '<li><button onclick="changePageVisibility(' + (pageType + i) + ',' + (pageType + currentPage) + ')">' + i + '</button></li>';
				}
			} else {
				for(var i = 2; i < maxPage; i++){
					pageButtons += '<li><button onclick="changePageVisibility(' + (pageType + i) + ',' + (pageType + currentPage) + ')">' + i + '</button></li>';
				}
			}
			pageButtons += '<li><button disabled>' + currentPage + '</button>';

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

				pageButtons += '<li><button onclick="changePageVisibility(' + (pageType + '1') + ',' + (pageType + currentPage) + ')">1</button></li>';
				for(var i = currentPage - upperButtons; i < currentPage; i++){
					pageButtons += '<li><button onclick="changePageVisibility(' + (pageType + i) + ',' + (pageType + currentPage) + ')">' + i +  '</button></li>';
				}
				pageButtons += '<li><button disabled>' + currentPage + '</button>';
				for(var i = currentPage + 1; i <= currentPage + lowerButtons; i++){
					pageButtons += '<li><button onclick="changePageVisibility(' + (pageType + i) + ',' + (pageType + currentPage) + ')">' + i +  '</button></li>';
				}
				pageButtons += '<li><button onclick="changePageVisibility(' + (pageType + maxPage) + ',' + (pageType + currentPage) + ')">' + maxPage + '</button></li>';
			} else {
				for(var i = 1; i < currentPage; i++){
					pageButtons += '<li><button onclick="changePageVisibility(' + (pageType + i) + ',' + (pageType + currentPage) + ')">' + i + '</button></li>';
				}
				pageButtons += '<li><button disabled>' + currentPage + '</button>';
				for(var i = currentPage + 1; i <= maxPage; i++){
					pageButtons += '<li><button onclick="changePageVisibility(' + (pageType + i) + ',' + (pageType + currentPage) + ')">' + i + '</button></li>';
				}
			}
			
		}
		pageButtons += '</ul>';
		pageButtons += '</div>';
	}
	
	callback(pageButtons);
}


function changePageVisibility(newPage,previousPage){
	previousPage.style.display = "none";
	newPage.style.display = "block";
	activateLazyLoad();
	window.scrollTo(0, 0);
}