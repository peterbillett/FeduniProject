//Setup page on load
$(function () {

	//navBar for all pages
	document.getElementById("navBar").innerHTML = '';
	var xmlhttpTEST = new XMLHttpRequest();
	xmlhttpTEST.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("navBar").innerHTML = this.responseText;
		}
	};
	xmlhttpTEST.open("GET", "./php/navBar.php", true);
	xmlhttpTEST.send();

	//Individual page inital load elements
	var currentPage = GetFilename(window.location.href);

	var dtp = document.getElementById('datetimepicker');
	//if (dtp != null){
	//}
		$('#myModal').on('show.bs.modal', function () {
		  $('#datetimepicker1').datetimepicker({
					defaultDate: new Date(),
					minDate: new Date()
				});
		})

	if(currentPage == 'createListing'){
		//Initalize datetimepicker with todays date as the min and selected
		$('#datetimepicker1').datetimepicker({
			defaultDate: new Date(),
			minDate: new Date()
		});

		//Initalize Tags
		document.getElementById("tagType").innerHTML = '<img class="loading" src="img/loading.gif" alt="Loading tags...">';
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("tagType").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET", "./php/get_all_tags.php", true);
		xmlhttp.send();
	};

	if(currentPage == 'allListings'){
		//Initalize tables of listings
		document.getElementById("listingList").innerHTML = '<img class="loading" src="img/loading.gif" alt="Loading items...">';
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("listingList").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET", "./php/getListings.php" + window.location.search, true);
		xmlhttp.send();
	}

	if(currentPage == 'allRequests'){
		//Initalize tables of listings
		document.getElementById("listingList").innerHTML = '<img class="loading" src="img/loading.gif" alt="Loading items...">';
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("listingList").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET", "./php/getListings.php?type=Request&" + window.location.search, true);
		xmlhttp.send();
	}

	if(currentPage == 'allSupplying'){
		//Initalize tables of listings
		document.getElementById("listingList").innerHTML = '<img class="loading" src="img/loading.gif" alt="Loading items...">';
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("listingList").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET", "./php/getListings.php?type=Supplying&" + window.location.search, true);
		xmlhttp.send();
	}

	if(currentPage == 'joinVolOrg'){
		//Initalize tables of listings
		document.getElementById("volOrgList").innerHTML = '<img class="loading" src="img/loading.gif" alt="Loading items...">';
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("volOrgList").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET", "./php/linkClientVolOrg.php", true);
		xmlhttp.send();
	}	

	if(currentPage == 'organisation'){
		//Initalize organisation info
		document.getElementById("organisationDetails").innerHTML = '<img class="loading" src="img/loading.gif" alt="Loading items...">';
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("organisationDetails").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET", "./php/organisationInfo.php" + window.location.search, true);
		xmlhttp.send();
	}

	if(currentPage == 'item'){
		//Initalize tables of listings
		document.getElementById("itemDetails").innerHTML = '<img class="loading" src="img/loading.gif" alt="Loading items...">';
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("itemDetails").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET", "./php/itemInfo.php" + window.location.search, true);
		xmlhttp.send();
	}

	if(currentPage == 'allOrgs'){
		//Initalize tables of listings
		document.getElementById("orgsList").innerHTML = '<img class="loading" src="img/loading.gif" alt="Loading items...">';
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("orgsList").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET", "./php/get_all_orgs.php" + window.location.search, true);
		xmlhttp.send();
	}

});

function GetFilename(url){
   if (url)
   {
      var m = url.toString().match(/.*\/(.+?)\./);
      if (m && m.length > 1)
      {
         return m[1];
      }
   }
   return "";
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