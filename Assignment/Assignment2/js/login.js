var xHRObject = false;

if (window.XMLHttpRequest)
	xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

//declare global variable
var result = true;
var errorMess = "";


//userlogin called on click log in button

function userlogin() {
	//declare variable
	var adminName = document.getElementById("adminName");
	var password = document.getElementById("password");

	adminName = adminName.value.trim();

	password = password.value.trim();
	if (adminName == "") {
		errorMess += "Please enter Admin Name.<br/>";
		result = false;
	}

	if (password == "") {
		errorMess += "Please enter password.<br/>";
		result = false;
	}

	if (!result) {
		notification.className = "error";
		notification.innerHTML = errorMess;
	} else {
		//body of post request
		var bodyOfRequest = "adminName=" + encodeURIComponent(adminName) + "&password=" + encodeURIComponent(password);
		//send log in request
		xhr.open("POST", "login.php", true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = login; //callback function	
		xhr.send(bodyOfRequest);
	}
}
//call back function

function login() {
	if ((xhr.readyState == 4) && (xhr.status == 200)) //if the resource was found, request success and 
	{
		var responseText = xhr.responseText;
		//errorDisplay.innerHTML = responseText; debug
		if (responseText.trim() == "true") {
			window.location.href = "listing.htm";
		} else if (responseText.trim() == "File not found") {
			errorMess += "<p> Database error </p>";
			result = false;
		} else {
			errorMess += "<p> Your log in information is not correct! </p>";
			result = false;
		}

		if (result == false && errorMess.length > 0) {
			notification.className = "error";
			notification.innerHTML = errorMess;
		}
	}
}

//clear text

function emptyText() {
	document.getElementById("email").value = "";
	document.getElementById("password").value = "";
	document.getElementById("errorDisplay").innerHTML = "";
}