var xHRObject = false;


if (window.XMLHttpRequest)
	xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

//declare global variable



//adminLogin called on click log in button

function userLogin() {
	//declare variable
	var result = true;
	var errorMess = "";
	var email = document.getElementById("email");
	var password = document.getElementById("password");

	email = email.value.trim();
	password = password.value.trim();
	
	if (email == "") {
		errorMess += "Please enter Email.<br/>";
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
		var bodyOfRequest = "email=" + encodeURIComponent(email) + "&password=" + encodeURIComponent(password);
		//send log in request
		xHRObject.open("POST", "login.php", true);
		xHRObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xHRObject.onreadystatechange = login; //callback function	
		xHRObject.send(bodyOfRequest);
	}
}
//call back function

function login() {
	if ((xHRObject.readyState == 4) && (xHRObject.status == 200)) //if the resource was found, request success and 
	{
		var result = true;
		var errorMess = "";
		var responseText = xHRObject.responseText;
		//errorDisplay.innerHTML = responseText; debug
		if (responseText.trim() == "true") {			
			window.location.href = "buying.htm";
		} else if (responseText.trim() == "Unable to open file!") {
			errorMess += "<p> Unable to open file! </p>";
			result = false;
		} else {
			errorMess += "<p> Invalid email address or password </p>";
			result = false;
		}

		if (!result) {
			notification.className = "error";
			notification.innerHTML = errorMess;
		}
	}
}
