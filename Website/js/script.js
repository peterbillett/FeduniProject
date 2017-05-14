//Setup page on load
$(function () {
	//Initalize datetimepicker with todays date as the min and selected

	//navBar
	document.getElementById("navBar").innerHTML = "Loading...";
	var xmlhttpTEST = new XMLHttpRequest();
	xmlhttpTEST.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("navBar").innerHTML = this.responseText;
		}
	};
	xmlhttpTEST.open("GET", "./php/navBar.php", true);
	xmlhttpTEST.send();

	if(window.location.pathname == '/website/createListing.html'){
		$('#datetimepicker1').datetimepicker({
			defaultDate: new Date(),
			minDate: new Date()
		});

		//Initalize Tags
		document.getElementById("tagType").innerHTML = "Loading tags...";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("tagType").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET", "./php/get_all_tags.php", true);
		xmlhttp.send();
	};

	if(window.location.pathname == '/website/allListings.html'){
		document.getElementById("listingList").innerHTML = "Loading...";
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("listingList").innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET", "./php/get_all_listings.php", true);
		xmlhttp.send();
	}

});