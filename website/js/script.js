//Setup pagedson load
$(function () {

	//Load navBar on all pages
	document.getElementById("navBar").innerHTML = '';
	var xmlhttpTEST = new XMLHttpRequest();
	xmlhttpTEST.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("navBar").innerHTML = this.responseText;
		}
	};
	xmlhttpTEST.open("GET", "/php/navBar.php", true);
	xmlhttpTEST.send();

	//Individual page inital load elements
	//Initalize tables of listings
	if(document.getElementById('listAllItems') != undefined){
		sendOffPHP("listAllItems", "/php/getListings.php" + window.location.search);
	}

	//Initalize tables of listings
	if(document.getElementById('listRequestItems') != undefined){
		sendOffPHP("listRequestItems", "/php/getListings.php?type=Request&" + window.location.search);
	}

	//Initalize tables of listings
	if(document.getElementById('listSupplyItems') != undefined){
		sendOffPHP("listSupplyItems", "/php/getListings.php?type=Supplying&" + window.location.search);
	}

	//Initalize list of organisations
	if(document.getElementById('volOrgList') != undefined){
		sendOffPHP("volOrgList", "/php/linkClientVolOrg.php");
	}	

	//Initalize organisation info
	if(document.getElementById('organisationDetails') != undefined){
		sendOffPHP("organisationDetails", "/php/organisationInfo.php" + window.location.search);
	}

	//Initalize tables of organisations
	if(document.getElementById('orgsList') != undefined){
		sendOffPHP("orgsList", "/php/get_all_orgs.php" + window.location.search);
	}

});


function sendOffPHP(elementID, phpDetails){
	document.getElementById(elementID).innerHTML = '<img class="loading" src="/img/loading.gif" alt="Loading items...">';
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById(elementID).innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", phpDetails, true);
	xmlhttp.send();
}


function searchTables(){
    var input, filter, ul, li, a, i;
    input = document.getElementById('searchValue');
    filter = input.value.toUpperCase();
    ul = document.getElementById("tableList");
    li = ul.getElementsByTagName('li');

    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}


function checkLoginSuccess(){

	document.getElementById("loginMessage").innerHTML = "";
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

	//Check if login is successful
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == "success"){
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


function checkAccountCreationSuccess(){
	console.log("fired");
	document.getElementById("accountCreationMessage").innerHTML = "";
	email = document.getElementById("newEmail").value;
	password = document.getElementById("newPassword").value;
	confirmPassword = document.getElementById("newConfirm").value;
	firstName = document.getElementById("newFirstName").value;
	lastName = document.getElementById("newLastName").value;
	//SHA256(document.getElementById("password").value)

	//Validation
	if (validateEmail(email) == false){
		document.getElementById("accountCreationMessage").innerHTML = "Invalid email address.";
		return false;
	}
	
	if (validatePassword(password) == false || validatePassword(confirmPassword) == false){
		document.getElementById("accountCreationMessage").innerHTML = "Invalid passwords.";
		return false;
	}

	if (password != confirmPassword){
		document.getElementById("accountCreationMessage").innerHTML = "Your passwords do not match.";
		return false;
	}

	if (validateName(firstName) == false){
		document.getElementById("accountCreationMessage").innerHTML = "Invalid first name.";
		return false;
	}

	if (validateName(lastName) == false){
		document.getElementById("accountCreationMessage").innerHTML = "Invalid last name.";
		return false;
	}

	//Check if login is successful
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == "success"){
				window.location.reload(false);
			} else {
				document.getElementById("accountCreationMessage").innerHTML = this.responseText;
				return false;
			}			
		}
	};
	xmlhttp.open("GET", "/php/createUser.php?email="+email+"&password="+password+"&firstName="+firstName+"&lastName="+lastName, true);
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

function getItemDetails(itemID) {

	document.getElementById("itemDetails").innerHTML = '<img class="loading" src="/img/loading.gif" alt="Loading items...">';
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == ""){
				document.getElementById("itemDetails").innerHTML = "There was an error getting the details for this item";
			} else {
				document.getElementById("itemDetails").innerHTML = this.responseText;
			}			
		}
	};
	xmlhttp.open("GET", "/php/itemInfo.php?id="+itemID, true);
	xmlhttp.send();
}

function createNewListing() {
	var createNewListingButton = document.getElementById("createNewListingButton");
	createNewListingButton.disabled = true;
	document.getElementById("createListingMessage").innerHTML = "";
	var createTitle = document.getElementById("createTitle");
	var createDescription = document.getElementById("createDescription");
	var createTagID = document.getElementById("createTagID");
	var createCategory = document.getElementById("createCategory");
	var createEndtime = document.getElementById("createEndtime");

	if (createTitle.value != "" & createDescription.value != "" & createTagID.value != "" & createCategory.value != "" & createEndtime.value != ""){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == "failed") {
					document.getElementById("createListingMessage").innerHTML = "Failed to create listing";
					createNewListingButton.disabled = false;
				} else {
					var count=5;
					var counter=setInterval(timer, 1000);
					function timer() {
					  	count=count-1;
					  	if (count <= 0) {
					     	clearInterval(counter);
					     	document.location.href = "/allListings";
					     	return;
					  	}
					  	document.getElementById("createListingMessage").innerHTML = "Listing created. Redirecting you to all listings in " + count + " seconds...";
					}	
					getItemDetails(this.responseText);
				}			
			}
		};
		xmlhttp.open("GET", "/php/createListing.php?title="+createTitle.value+"&tagID="+createTagID.value+"&description="+createDescription.value+"&category="+createCategory.value+"&endtime="+createEndtime.value, true);
		xmlhttp.send();
	} else {
		document.getElementById("createListingMessage").innerHTML = "All fields must be filled out";
		document.getElementById("createNewListingButton").disabled = false;
	}
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


function changeStatus(itemID, newItemStatus) {
	document.getElementById("itemInfoMessage").innerHTML = "";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == "success") {
				getItemDetails(itemID);
				updateItemTable(itemID);
			} else {
				document.getElementById("itemInfoMessage").innerHTML = this.responseText;
			}			
		}
	};
	xmlhttp.open("GET", "/php/changeItemStatus.php?id="+itemID+"&status="+newItemStatus, true);
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
					var count=5;
					var counter=setInterval(timer, 1000);
					function timer() {
					  	count=count-1;
					  	if (count <= 0) {
					     	clearInterval(counter);
					     	location.reload();
					     	return;
					  	}
					  	document.getElementById("itemEditMessage").innerHTML = "Listing removed. The page will refresh in " + count + " seconds...";
					}			
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
					getItemDetails(itemID);
					updateItemTable(itemID);
					document.getElementById("itemEditMessage").innerHTML = "";
				} else {
					document.getElementById("itemEditMessage").innerHTML = this.responseText;
				}			
			}
		};
		xmlhttp.open("GET", "/php/editListing.php?id="+itemID+"&title="+newTitle.value+"&description="+newDescription.value+"&category="+newCategory.value, true);
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
				getItemDetails(itemID);
				document.getElementById("itemTableID"+itemID).innerHTML = this.responseText;
			} else {
				location.reload();
			}			
		}
	};
	xmlhttp.open("GET", "/php/getSingleItemTable.php?id="+itemID, true);
	xmlhttp.send();
}







/**
*
*  Secure Hash Algorithm (SHA256)
*  http://www.webtoolkit.info/
*
*  Original code by Angel Marin, Paul Johnston.
*
**/
 
function SHA256(s){
 
	var chrsz   = 8;
	var hexcase = 0;
 
	function safe_add (x, y) {
		var lsw = (x & 0xFFFF) + (y & 0xFFFF);
		var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
		return (msw << 16) | (lsw & 0xFFFF);
	}
 
	function S (X, n) { return ( X >>> n ) | (X << (32 - n)); }
	function R (X, n) { return ( X >>> n ); }
	function Ch(x, y, z) { return ((x & y) ^ ((~x) & z)); }
	function Maj(x, y, z) { return ((x & y) ^ (x & z) ^ (y & z)); }
	function Sigma0256(x) { return (S(x, 2) ^ S(x, 13) ^ S(x, 22)); }
	function Sigma1256(x) { return (S(x, 6) ^ S(x, 11) ^ S(x, 25)); }
	function Gamma0256(x) { return (S(x, 7) ^ S(x, 18) ^ R(x, 3)); }
	function Gamma1256(x) { return (S(x, 17) ^ S(x, 19) ^ R(x, 10)); }
 
	function core_sha256 (m, l) {
		var K = new Array(0x428A2F98, 0x71374491, 0xB5C0FBCF, 0xE9B5DBA5, 0x3956C25B, 0x59F111F1, 0x923F82A4, 0xAB1C5ED5, 0xD807AA98, 0x12835B01, 0x243185BE, 0x550C7DC3, 0x72BE5D74, 0x80DEB1FE, 0x9BDC06A7, 0xC19BF174, 0xE49B69C1, 0xEFBE4786, 0xFC19DC6, 0x240CA1CC, 0x2DE92C6F, 0x4A7484AA, 0x5CB0A9DC, 0x76F988DA, 0x983E5152, 0xA831C66D, 0xB00327C8, 0xBF597FC7, 0xC6E00BF3, 0xD5A79147, 0x6CA6351, 0x14292967, 0x27B70A85, 0x2E1B2138, 0x4D2C6DFC, 0x53380D13, 0x650A7354, 0x766A0ABB, 0x81C2C92E, 0x92722C85, 0xA2BFE8A1, 0xA81A664B, 0xC24B8B70, 0xC76C51A3, 0xD192E819, 0xD6990624, 0xF40E3585, 0x106AA070, 0x19A4C116, 0x1E376C08, 0x2748774C, 0x34B0BCB5, 0x391C0CB3, 0x4ED8AA4A, 0x5B9CCA4F, 0x682E6FF3, 0x748F82EE, 0x78A5636F, 0x84C87814, 0x8CC70208, 0x90BEFFFA, 0xA4506CEB, 0xBEF9A3F7, 0xC67178F2);
		var HASH = new Array(0x6A09E667, 0xBB67AE85, 0x3C6EF372, 0xA54FF53A, 0x510E527F, 0x9B05688C, 0x1F83D9AB, 0x5BE0CD19);
		var W = new Array(64);
		var a, b, c, d, e, f, g, h, i, j;
		var T1, T2;
 
		m[l >> 5] |= 0x80 << (24 - l % 32);
		m[((l + 64 >> 9) << 4) + 15] = l;
 
		for ( var i = 0; i<m.length; i+=16 ) {
			a = HASH[0];
			b = HASH[1];
			c = HASH[2];
			d = HASH[3];
			e = HASH[4];
			f = HASH[5];
			g = HASH[6];
			h = HASH[7];
 
			for ( var j = 0; j<64; j++) {
				if (j < 16) W[j] = m[j + i];
				else W[j] = safe_add(safe_add(safe_add(Gamma1256(W[j - 2]), W[j - 7]), Gamma0256(W[j - 15])), W[j - 16]);
 
				T1 = safe_add(safe_add(safe_add(safe_add(h, Sigma1256(e)), Ch(e, f, g)), K[j]), W[j]);
				T2 = safe_add(Sigma0256(a), Maj(a, b, c));
 
				h = g;
				g = f;
				f = e;
				e = safe_add(d, T1);
				d = c;
				c = b;
				b = a;
				a = safe_add(T1, T2);
			}
 
			HASH[0] = safe_add(a, HASH[0]);
			HASH[1] = safe_add(b, HASH[1]);
			HASH[2] = safe_add(c, HASH[2]);
			HASH[3] = safe_add(d, HASH[3]);
			HASH[4] = safe_add(e, HASH[4]);
			HASH[5] = safe_add(f, HASH[5]);
			HASH[6] = safe_add(g, HASH[6]);
			HASH[7] = safe_add(h, HASH[7]);
		}
		return HASH;
	}
 
	function str2binb (str) {
		var bin = Array();
		var mask = (1 << chrsz) - 1;
		for(var i = 0; i < str.length * chrsz; i += chrsz) {
			bin[i>>5] |= (str.charCodeAt(i / chrsz) & mask) << (24 - i%32);
		}
		return bin;
	}
 
	function Utf8Encode(string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
 
		for (var n = 0; n < string.length; n++) {
 
			var c = string.charCodeAt(n);
 
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
 
		}
 
		return utftext;
	}
 
	function binb2hex (binarray) {
		var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";
		var str = "";
		for(var i = 0; i < binarray.length * 4; i++) {
			str += hex_tab.charAt((binarray[i>>2] >> ((3 - i%4)*8+4)) & 0xF) +
			hex_tab.charAt((binarray[i>>2] >> ((3 - i%4)*8  )) & 0xF);
		}
		return str;
	}
 
	s = Utf8Encode(s);
	return binb2hex(core_sha256(str2binb(s), s.length * chrsz));
 
}