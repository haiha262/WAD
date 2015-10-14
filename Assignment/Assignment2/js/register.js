var xHRObject = false;

if (window.XMLHttpRequest)
	xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

var debug = true;
var notification;
function validate() {
	var email = (document.getElementById("email").value).trim();
	var fname = (document.getElementById("fname").value).trim();
	var lname = (document.getElementById("lname").value).trim();
	var password = (document.getElementById("password").value).trim();
	var confirm_password = (document.getElementById("confirm_password").value).trim();
	var phone = document.getElementById("phone").value.trim();
	var result = true;
	var errorMess = "";
	if (debug) {
		//email = "testing@test.com";
		fname = "Name";
		lname = "Last Name";
		password = "123456789";
		confirm_password = password;
		phone = "01 23456789";
	}
	if (fname.length == 0) {
		errorMess += "Please enter First name. <br/>";
		result = false;
	}
	if (lname.length == 0) {
		errorMess += "Please enter Last name. <br/>";
		result = false;
	}
	if (password.length == 0) {
		errorMess += "Please enter password. <br/>";
		result = false;
	}
	if (confirm_password.length == 0) {
		errorMess += "Please enter confirm password. <br/>";
		result = false;
	} else {
		if (password.length != 0 && confirm_password.length != 0) {
			if (password.localeCompare(confirm_password) != 0) {
				errorMess += "Password doesn't match. <br/>";
				result = false;
			}
		}
	}

	if (email.length == 0) {
		errorMess += "Please enter Email. <br/>";
		result = false;
	} else { //validate format
		if (!validateEmail(email)) {
			errorMess += "Please check your email. <br/>";
			result = false;
		}
	}

	if (phone.length > 0) {
		if (!validatePhone(phone)) {
			errorMess += "Format phone number must be (01)12345678 or 01 23456789.<br/>";
			result = false;
		}
	}

	notification = document.getElementById("notification");
	if (!result) {
		notification.className = "error";
		notification.innerHTML = errorMess;
	} else {
		//check exist email form server
		//body of post request
		var bodyOfRequest = "";
		// bodyOfRequest += "register.php?"
		bodyOfRequest += "email=" + encodeURIComponent(email);
		bodyOfRequest += "&fname=" + encodeURIComponent(fname);
		bodyOfRequest += "&lname=" + encodeURIComponent(lname);
		bodyOfRequest += "&password=" + encodeURIComponent(password);
		bodyOfRequest += "&phone=" + encodeURIComponent(phone);
		//send log in request
		//Post method
		xHRObject.open("POST", "register.php", true);
		xHRObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


		xHRObject.onreadystatechange = register;
		xHRObject.send(bodyOfRequest);

		//GET method
		//xHRObject.open("GET", bodyOfRequest, true);
		//        xHRObject.onreadystatechange = register;
		//        xHRObject.send(null);   

	}

}


function register() {
	var serverResponse = "";
	var errorMess = "";
	if (xHRObject.readyState == 4 && xHRObject.status == 200) {
		serverResponse = xHRObject.responseText;
		if (debug) {
			alert(serverResponse);
		}
		if (serverResponse == "false") {
			errorMess += "This email has been exist!!";
			notification.className = "error";
		} else if (serverResponse == "true") {
			//errorMess += "Successful registration";
			//notification.className = "success";
			//var homeLink = document.getElementById("homeLink");
			//homeLink.innerHTML = "<a href=\"buyonline.htm\">Back</a>";
			var mess = "<h1>Registration successful</h1>";
			mess += "Thank you. The registration has been completed successfully."
			mess += "<p><a href=\"buyonline.htm\">Back</a></p>";
			
			document.write(mess);
		}
		notification.innerHTML = errorMess;
	}
} //callback function


function validateEmail(email) {
	var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	return regex.test(email);
}

function validatePhone(phone) {
	//check 
	var regex = /^([(][0-9]{2}[)][0-9]{8}|[0-9]{2} [0-9]{8})$/;
	return regex.test(phone);
}