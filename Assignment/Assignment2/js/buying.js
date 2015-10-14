var xHRObject = false;

if (window.XMLHttpRequest)
	xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

//load catalog
var isloadCat = false;
if (!isloadCat) {
	loadCat();
	
}

function loadCat() {
	var bodyOfRequest = "request=loadcategory";
	xHRObject.open("POST", "buying.php", true);
	xHRObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xHRObject.send(bodyOfRequest);
	xHRObject.onreadystatechange = function() { //calback function

		var table = "";
		if ((xHRObject.readyState == 4) && (xHRObject.status == 200)) {
			
			var serverResponse = xHRObject.responseText;
			var spantag = document.getElementById("catalog");
			spantag.innerHTML = serverResponse;
						
			//var serverResponse = xHRObject.responseXML;			
			//var header = serverResponse.getElementsByTagName("item");
			//var spantag = document.getElementById("catalog");
			//spantag.innerHTML = "";
			//
			//
			//if (header.length > 0) {
			//	table += "<h3 id=\"lb\">Shopping Catalog</h3>"
			//	table += "<table class=\"tableCat\">";
			//	table += "<tr><th>Item Number</th><th>Name</th><th>Description</th><th>Price</th><th>Quantity</th><th>Add</th></tr>";
			//
			//
			//	for (i = 0; i < header.length; i++) {
			//		var node = header[i];
			//		var itemNumber = node.getElementsByTagName("id")[0].firstChild.nodeValue;
			//		var itemName = node.getElementsByTagName("name")[0].firstChild.nodeValue;
			//		var itemDsc = node.getElementsByTagName("description")[0].firstChild.nodeValue;
			//		var itemPrice = node.getElementsByTagName("price")[0].firstChild.nodeValue;
			//		var itemQty = node.getElementsByTagName("quantity")[0].firstChild.nodeValue;
			//		table += "<tr>";
			//		table += "<td>" + itemNumber + "</td>";
			//		table += "<td>" + itemName + "</td>";
			//		table += "<td>" + itemDsc + "</td>";
			//		table += "<td>" + itemPrice + "</td>";
			//		table += "<td>" + itemQty + "</td>";
			//		table += "<td><input type=\"button\" value=\"Add one to cart\" onclick=\"AddRemoveItem('Add','" + itemNumber + "');\"/></td>";
			//		table += "</tr>";
			//	}
			//	table += "</table>";
			//	isloadCat = true;
			//}
			//spantag.innerHTML = table;
		}
	}

}

function AddRemoveItem(action, id) {
	var bodyOfRequest = "request=" + action + "&id=" + id;
	xHRObject.open("POST", "buying.php", true);
	xHRObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xHRObject.send(bodyOfRequest);
	xHRObject.onreadystatechange = addNew; //calback function
}

function addNew() {
	if ((xHRObject.readyState == 4) && (xHRObject.status == 200)) {
		var serverResponse = xHRObject.responseXML;
		var header = serverResponse.getElementsByTagName("item");
		var spantag = document.getElementById("cart");

		spantag.innerHTML = "";
		var table = "";
		if (header.length > 0) {
			table += "<h3 id=\"lb\">Shopping Cart</h3>"
			table += "<table class=\"tableCat\">";
			table += "<tr><th>Item Number</th><th>Price</th><th>Quantity</th><th>Remove</th></tr>";

			var total = 0;
			for (i = 0; i < header.length; i++) {
				var node = header[i];
				var itemNumber = node.getElementsByTagName("id")[0].firstChild.nodeValue;
				//var itemName = node.getElementsByTagName("itemName")[0].firstChild.nodeValue;
				//var itemDsc = node.getElementsByTagName("itemDescription")[0].firstChild.nodeValue;
				var itemPrice = node.getElementsByTagName("price")[0].firstChild.nodeValue;
				var itemQty = node.getElementsByTagName("quantity")[0].firstChild.nodeValue;
				total += itemPrice*itemQty;
				table += "<tr>";
				table += "<td>" + itemNumber + "</td>";
				//table += "<td>" + itemName + "</td>";
				//table += "<td>" + itemDsc + "</td>";
				table += "<td>" + itemPrice + "</td>";
				table += "<td>" + itemQty + "</td>";
				table += "<td><input type=\"button\" value=\"Remove from cart\" onclick=\"AddRemoveItem('remove','" + itemNumber + "');\"/></td>";
				table += "</tr>";
			}
			table += "<tr><td colspan=\"3\">Total:</td><td>"+total+"</td></tr>";
			table += "<tr><td colspan=\"4\">";
			table += "<input type=\"button\" value=\"Confirm Purchase\" onclick=\"purchase('confirm');\"/>";
			table += "<input type=\"button\" value=\"Cancel Purchase\" onclick=\"purchase('cancel');\"/>";
			table += "</td></tr>";
			table += "</table>";
		}
		spantag.innerHTML = table;
	}
}