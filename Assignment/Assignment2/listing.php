<?php
header("Content-type: text/xml "); //  have to set this for IE
$filePath = "./home/students/accounts/s4959353/cos80021/www/data/goods.xml";
if(!file_exists($filePath))
{
	//create new file and save to the path
	$newDoc = new DOMDocument("1.0");
	$root = $newDoc->createElement("items");
	$root = $newDoc->appendChild($root);		
	$newDoc->FormatOutput = true;
	$newDoc->saveXML();
	$newDoc->save($filePath);		

}
		
	$itemId= uniqid();
	$itemName = $_POST["itemName"];
	$itemPrice = $_POST["itemPrice"];
	$itemQty = $_POST["itemQty"];
	$itemDsc = $_POST["itemDsc"];
			
	

	//////////////================///////////////
	//Option1
	$xml=simplexml_load_file($filePath);
					
	$xml = $xml->asXML();
	$itemsNode = new SimpleXMLElement($xml);
	
	//add new node customer
	$itemNode = $itemsNode->addChild("item"); 		
	//add new node in customer
	$itemNode->addChild("itemNumber", $itemId); 
	$itemNode->addChild("itemName", $itemName);
	$itemNode->addChild("itemPrice", $itemPrice);
	$itemNode->addChild("itemQty", $itemQty);
	$itemNode->addChild("itemDescription", $itemDsc);
	$itemNode->addChild("itemHoldon", 0);
	$itemNode->addChild("itemSold", 0); 
	//save into file	
	$itemsNode->asXML($filePath);
	echo $itemId;
?>