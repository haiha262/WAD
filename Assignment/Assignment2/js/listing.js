var xHRObject = false;

if (window.XMLHttpRequest)
	xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

checkAccess();
function checkAccess() {	
	xHRObject.open("POST", "listing.php", true);
	xHRObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xHRObject.send(null);
	xHRObject.onreadystatechange = function() {
		if ((xHRObject.readyState == 4) && (xHRObject.status == 200)) {
			var errorLogin = xHRObject.responseText;
			if (errorLogin=="login") {
				window.location="buyonline.htm";
			}
		}
	}
}

function addItem() {
	var itemName = (document.getElementById("itemName").value).trim();
	var itemPrice = (document.getElementById("itemPrice").value).trim();
	var itemQty = (document.getElementById("itemQty").value).trim();
	var itemDsc = (document.getElementById("itemDsc").value).trim();

	var result = true;
	var errorMess = "";
	if (false) {
		//email = "testing@test.com";
		itemName = "Item1";
		itemPrice = "456";
		itemQty = "134";
		itemDsc = "Description ";

	}
	if (itemName.length == 0) {
		errorMess += "Please enter item name. <br/>";
		result = false;
	}
	if (itemPrice.length == 0) {
		errorMess += "Please enter the price. <br/>";
		result = false;
	} else { //validate format
		if (!validateCurrency(itemPrice)) {
			errorMess += "Please enter number only in price field. <br/>";
			result = false;
		}
	}

	if (itemQty.length == 0) {
		errorMess += "Please enter the quantity. <br/>";
		result = false;
	}
	else if (itemQty.length >8) {
		errorMess += "The quantity is too long. <br/>";
		result = false;
	} 
	else { //validate format
		if (!validateNumber(itemQty)) {
			errorMess += "Please enter number only in quantity field. <br/>";
			result = false;
		}
	}
	if (itemDsc.length == 0) {
		errorMess += "Please enter the description. <br/>";
		result = false;
	}


	var notification = document.getElementById("notification");
	if (!result) {
		notification.className = "error";
		notification.innerHTML = errorMess;
	} else {
		//check exist email form server
		//body of post request
		var bodyOfRequest = "";
		// bodyOfRequest += "register.php?"
		bodyOfRequest += "itemName=" + encodeURIComponent(itemName);
		bodyOfRequest += "&itemPrice=" + encodeURIComponent(itemPrice);
		bodyOfRequest += "&itemQty=" + encodeURIComponent(itemQty);
		bodyOfRequest += "&itemDsc=" + encodeURIComponent(itemDsc);

		//send log in request
		//Post method
		xHRObject.open("POST", "listing.php", true);
		xHRObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


		xHRObject.onreadystatechange = addNew;
		xHRObject.send(bodyOfRequest);

		//GET method
		//xHRObject.open("GET", bodyOfRequest, true);
		//        xHRObject.onreadystatechange = register;
		//        xHRObject.send(null);   

	}

}


function addNew() {
	var serverResponse = "";
	var errorMess = "";
	if (xHRObject.readyState == 4 && xHRObject.status == 200) {
		serverResponse = xHRObject.responseText;

		errorMess += "The item has been listed in the system, and the item number is:<" + serverResponse + ">";
		notification.className = "success";

		notification.innerHTML = errorMess;
	}
} //callback function

function reset() {
	(document.getElementById("itemName")).value = "";
	(document.getElementById("itemPrice")).value = "";
	(document.getElementById("itemQty")).value = "";
	(document.getElementById("itemDsc")).value = "";
}

function validateEmail(email) {
	var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	return regex.test(email);
}

function validatePhone(phone) {
	//check 
	var regex = /^[(]\d{0}\d{1}[)]\d{8}$/;
	return regex.test(phone);
}

function validateNumber(input) {
	//check 
	var regex = /^[0-9]{1,8}$/;
	return regex.test(input);
}
function validateCurrency(input) {
	//check 
	var regex = /^\$?[\d,]+(\.\d*)?$/;
	return regex.test(input);
}
