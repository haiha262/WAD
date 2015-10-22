var xHRObject = false;

if (window.XMLHttpRequest)
	xHRObject = new XMLHttpRequest();
else if (window.ActiveXObject)
	xHRObject = new ActiveXObject("Microsoft.XMLHTTP");

//load catalog
var isloadCat = false;
//if (!isloadCat)
{
	setInterval("loadCat()", 5000);
	//loadCat();

}

var filter = true;//remember edit on php file

function loadCat() {
	var bodyOfRequest = "request=loadcategory";
	xHRObject.open("POST", "buying.php", true);
	xHRObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xHRObject.send(bodyOfRequest);
	xHRObject.onreadystatechange = function() { //calback function

		var table = "";
		if ((xHRObject.readyState == 4) && (xHRObject.status == 200)) {
			var errorLogin = xHRObject.responseText;
			if (errorLogin=="login") {
				window.location="buyonline.htm";
			}
			if (filter) {
				var serverResponse = xHRObject.responseText;
				var spantag = document.getElementById("catalog");
				spantag.innerHTML = serverResponse;
			} else {
				var serverResponse = xHRObject.responseXML;
				var header = serverResponse.getElementsByTagName("item");
				var spantag = document.getElementById("catalog");
				spantag.innerHTML = "";
				if (header.length > 0) {
					table += "<h3 id=\"lb\">Shopping Catalog</h3>"
					table += "<table class=\"tableCat\">";
					table += "<tr><th>Item Number</th><th>Name</th><th>Description</th><th>Price</th><th>Quantity</th><th>Add</th></tr>";
					for (i = 0; i < header.length; i++) {
						var node = header[i];
						var itemNumber = node.getElementsByTagName("id")[0].firstChild.nodeValue;
						var itemName = node.getElementsByTagName("name")[0].firstChild.nodeValue;
						var itemDsc = node.getElementsByTagName("description")[0].firstChild.nodeValue;
						var itemPrice = node.getElementsByTagName("price")[0].firstChild.nodeValue;
						var itemQty = node.getElementsByTagName("quantity")[0].firstChild.nodeValue;
						table += "<tr>";
						table += "<td>" + itemNumber + "</td>";
						table += "<td>" + itemName + "</td>";
						table += "<td>" + itemDsc + "</td>";
						table += "<td>" + itemPrice + "</td>";
						table += "<td>" + itemQty + "</td>";
						table += "<td><input type=\"button\" value=\"Add one to cart\" onclick=\"AddRemoveItem('Add','" + itemNumber + "');\"/></td>";
						table += "</tr>";
					}
					table += "</table>";
					isloadCat = true;
				}
				spantag.innerHTML = table;
				AddRemoveItem("getCart",0);
			}
		}
	}

}

function AddRemoveItem(action, id) {
	var divmsg = document.getElementById("msg");
	divmsg.innerHTML="";
	var bodyOfRequest = "request=" + action + "&id=" + id;
	xHRObject.open("POST", "buying.php", true);
	xHRObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xHRObject.send(bodyOfRequest);
	xHRObject.onreadystatechange = addNew; //calback function
}

function addNew() {
	if ((xHRObject.readyState == 4) && (xHRObject.status == 200)) {
		//var serverResponse = xHRObject.responseText;
		//alert(serverResponse);
		//return;
		//if (!filter)
		{
			var serverResponse = xHRObject.responseText;
			if (serverResponse == "sorry") {
				alert("Sorry, this item is not available for sale");
				return;
			}
		}
		var serverResponse = xHRObject.responseText;
		
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
				total += itemPrice * itemQty;
				table += "<tr>";
				table += "<td>" + itemNumber + "</td>";
				//table += "<td>" + itemName + "</td>";
				//table += "<td>" + itemDsc + "</td>";
				table += "<td>" + itemPrice + "</td>";
				table += "<td>" + itemQty + "</td>";
				table += "<td><input type=\"button\" value=\"Remove from cart\" onclick=\"AddRemoveItem('Remove','" + itemNumber + "');\"/></td>";
				table += "</tr>";
			}
			table += "<tr><td colspan=\"3\">Total:</td><td>$" + total.formatMoney(2, '.', ','); + "</td></tr>";
			table += "<tr><td colspan=\"4\">";
			table += "<input type=\"button\" value=\"Confirm Purchase\" onclick=\"Purchase('Confirm');\"/>";
			table += "<input type=\"button\" value=\"Cancel Purchase\" onclick=\"Purchase('Cancel');\"/>";
			table += "</td></tr>";
			table += "</table>";
		}
		spantag.innerHTML = table;
		//loadCat();   
	}
}
Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };
function Purchase(action) {
	var bodyOfRequest = "request=" + action;
	xHRObject.open("POST", "buying.php", true);
	xHRObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xHRObject.send(bodyOfRequest);
	xHRObject.onreadystatechange = function()
	{
		if ((xHRObject.readyState == 4) && (xHRObject.status == 200)) {
			var serverResponse = xHRObject.responseText;
			if (action=="Confirm") {
				
				var spantag = document.getElementById("cart");
				spantag.innerHTML = "";
				var spanmsg = document.getElementById("msg");
				var msg= "Your purchase has been confirmed and total amount due to pay is $"+serverResponse;
				spanmsg.innerHTML = ("<h1 class=\"title\">"+msg+"</h1>");
			}
			else
			{
				alert("Your purchase request has been cancelled, welcome to shop next time");
				window.location.reload();
			}
		}
	}
	
	
}