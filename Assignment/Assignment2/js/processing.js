var xHRObject = false;

if (window.XMLHttpRequest)
	xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

var filter = true;//remember edit on php file
load();
function load() {
	var bodyOfRequest = "request=load";
	xHRObject.open("POST", "processing.php", true);
	xHRObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xHRObject.send(bodyOfRequest);
	xHRObject.onreadystatechange = function() { //calback function

		loadTable("load");
	}

}

function Process() {
	var bodyOfRequest = "request=process";
	xHRObject.open("POST", "processing.php", true);
	xHRObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xHRObject.send(bodyOfRequest);
	xHRObject.onreadystatechange = function() { //calback function

		loadTable("process");
	}

}
function loadTable(action) {
	var table = "";
		if ((xHRObject.readyState == 4) && (xHRObject.status == 200)) {
			var errorLogin = xHRObject.responseText;
			if (errorLogin=="login") {
				window.location="buyonline.htm";
			}
			//if (filter) {
			//	var serverResponse = xHRObject.responseText;
			//	var spantag = document.getElementById("catalog");
			//	spantag.innerHTML = serverResponse;
			//} else
			{
				
			var serverResponse = xHRObject.responseXML;
			var header = serverResponse.getElementsByTagName("item");
			var spantag = document.getElementById("catalog");
			spantag.innerHTML = "";


			if (header.length > 0) {

				table += "<table class=\"tableCat\">";
				table += "<tr><th>Item Number</th><th>Item Name</th><th>Price</th><th>Quantity Available</th><th>Quantity on Hold</th><th>Quantity Sold</th></tr>";


				for (i = 0; i < header.length; i++) {
					var node = header[i];
					var itemNumber = node.getElementsByTagName("id")[0].firstChild.nodeValue;
					var itemName = node.getElementsByTagName("name")[0].firstChild.nodeValue;
					var itemPrice = node.getElementsByTagName("price")[0].firstChild.nodeValue;
					var itemQty = node.getElementsByTagName("quantity")[0].firstChild.nodeValue;
					var itemHoldon = node.getElementsByTagName("holdon")[0].firstChild.nodeValue;
					var itemSold = node.getElementsByTagName("sold")[0].firstChild.nodeValue;
					table += "<tr>";
					table += "<td>" + itemNumber + "</td>";
					table += "<td>" + itemName + "</td>";
					table += "<td>" + itemPrice + "</td>";
					table += "<td>" + itemQty + "</td>";
					table += "<td>" + itemHoldon + "</td>";
					table += "<td>" + itemSold + "</td>";

					table += "</tr>";
				}
				if (action=="load") {
				
					table += "<tr><td colspan=\"6\">";
					table += "<input type=\"button\" value=\"Process\" onclick=\"Process();\"/>";
	
					table += "</td></tr>";
				}
				table += "</table>";
				isloadProcess = true;
			}
			spantag.innerHTML = table;
			}
		}
}