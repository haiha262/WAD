var xHRObject = false;

if (window.XMLHttpRequest)
	xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

var isloadProcess = false;
checkAccess();
function checkAccess() {
	var bodyOfRequest = "request=" + encodeURIComponent("check");;
	xHRObject.open("POST", "session.php", true);
	xHRObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xHRObject.send(bodyOfRequest);
	xHRObject.onreadystatechange = function() {
		if ((xHRObject.readyState == 4) && (xHRObject.status == 200)) {
			var serverResponse = xHRObject.responseText;
			if (serverResponse == "false") {
				//Login again
				window.location = "buyonline.htm";
			} else {
				//load catalog
				if (!isloadProcess) {
					loadProcess();
				}
			}
		}
	}
}
	function loadProcess() {
		var bodyOfRequest = "request=load";
		xHRObject.open("POST", "processing.php", true);
		xHRObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xHRObject.send(bodyOfRequest);
		xHRObject.onreadystatechange = function() { //calback function

			var table = "";
			if ((xHRObject.readyState == 4) && (xHRObject.status == 200)) {
				var serverResponse = xHRObject.responseXML;
				var header = serverResponse.getElementsByTagName("item");
				var spantag = document.getElementById("catalog");
				spantag.innerHTML = "";


				if (header.length > 0) {

					table += "<table class=\"tableCat\">";
					table += "<tr><th>Item Number</th><th>Item Name</th><th>Price</th><th>Quantity Available</th><th>Quantity on Hold</th><th>Quantity Sold</th></tr>";


					for (i = 0; i < header.length; i++) {
						var node = header[i];
						var itemNumber = node.getElementsByTagName("itemNumber")[0].firstChild.nodeValue;
						var itemName = node.getElementsByTagName("itemName")[0].firstChild.nodeValue;
						var itemPrice = node.getElementsByTagName("itemPrice")[0].firstChild.nodeValue;
						var itemQty = node.getElementsByTagName("itemQty")[0].firstChild.nodeValue;
						var itemHoldon = node.getElementsByTagName("itemHoldon")[0].firstChild.nodeValue;
						var itemSold = node.getElementsByTagName("itemSold")[0].firstChild.nodeValue;
						table += "<tr>";
						table += "<td>" + itemNumber + "</td>";
						table += "<td>" + itemName + "</td>";
						table += "<td>" + itemPrice + "</td>";
						table += "<td>" + itemQty + "</td>";
						table += "<td>" + itemHoldon + "</td>";
						table += "<td>" + itemSold + "</td>";

						table += "</tr>";
					}
					table += "<tr><td colspan=\"6\">";
					table += "<input type=\"button\" value=\"Process\" onclick=\"process();\"/>";

					table += "</td></tr>";

					table += "</table>";
					isloadProcess = true;
				}
				spantag.innerHTML = table;
			}
		}

	}