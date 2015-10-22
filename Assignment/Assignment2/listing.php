<?php
session_start();
header("Content-type: text/xml "); //  have to set this for IE

if(!isset($_SESSION["id_admin"]))
{
  echo "login";
  return;
}

//access
$filePath = "../../data/goods.xml";
if(!file_exists($filePath))
{
	//create new file and save to the path
	$newDoc = new DOMDocument("1.0");
    $newDoc->preserveWhiteSpace = false;
    $newDoc->formatOutput = true;
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
	$itemNode->addChild("id", $itemId); 
	$itemNode->addChild("name", $itemName);
	$itemNode->addChild("price", $itemPrice);
	$itemNode->addChild("quantity", $itemQty);
	$itemNode->addChild("description", $itemDsc);
	$itemNode->addChild("holdon", 0);
	$itemNode->addChild("sold", 0); 
	//save into file	
	$itemsNode->asXML($filePath);
	echo $itemId;
?>