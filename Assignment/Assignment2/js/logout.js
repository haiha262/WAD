var xHRObject = false;

if (window.XMLHttpRequest)
	xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	xHRObject = new ActiveXObject("Microsoft.XMLHTTP");


var url = window.location.href;
var params = url.split('?');

var bodyOfRequest = params[1];
xHRObject.open("POST", "logout.php", true);
xHRObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xHRObject.send(bodyOfRequest);
xHRObject.onreadystatechange = function() {

	if ((xHRObject.readyState == 4) && (xHRObject.status == 200)) {
		var responseText = xHRObject.responseText;
		if (responseText != null) {

			var tksMes = document.getElementById("tksMes");
			tksMes.innerHTML = "Thanks " + responseText;
			
		}
	}
};