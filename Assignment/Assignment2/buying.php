<?php
session_start();
header("Content-Type:text/xml");

$fileXMLPath = "./home/students/accounts/s4959353/cos80021/www/data/goods.xml";
$fileXSLPath = "./home/students/accounts/s4959353/cos80021/www/data/goods.xsl";
//load category
$id ="";
$price ="";

if(isset($_POST["request"]))
{
  $action = $_POST["request"];
  
  
  //filter xml without hold on and qty >0
  $xml = new DOMDocument();
  $xml->load($fileXMLPath);  

  //way2
  //  $xml = simplexml_load_file($filePath);  

  
  if($action == "loadcategory")
  {
	loadcategory($xml);	
  }
  else if($action == "Add" || $action == "Remove")
  {
    AddRemoveItem($xml,$action);
  }
  else if($action == "Confirm" || $action == "Cancel")
  {
	PurchaseItem($xml,$action);
  }
}

function loadcategory($xml)
{
  /* load xsl*/
	$filter=true;//remember edit on js file
	if($filter)
	{
	  $fileXSLPath =$GLOBALS["fileXSLPath"];
	  $xslDoc = new DomDocument;
	  $xslDoc->load($fileXSLPath);
	  //combine xsl into xml
	  $proc = new XSLTProcessor;
	  $proc->importStyleSheet($xslDoc);
	  echo $proc->transformToXML($xml);
	}
	else
	{	
	  echo  $xml->saveXML();
	  //way 2
	  //echo $xml->asXML();
	}
}

function AddRemoveItem($xml,$action)
{
  //find detail of item with id
	
	$id = $_POST["id"];
    $price = findItem($xml,$id,"price");
    $curQty = findItem($xml,$id,"quantity");
    if ($_SESSION["cart"] != "") 					//check the cart
    {
      $cart = $_SESSION["cart"]; 					//read the cart session into local variable
      if ($action == "Add") 						//process add function
      {
		if($curQty>0)
		{
		  if (!isset($cart[$id]))
		  {  
			$qty = 1; 							// increase no of books by 1
			$value = array();
			$value["price"] = $price;
			$value["qty"] = $qty;
					 
			$cart[$id] = $value;
			$_SESSION["cart"] = $cart;  		// save the adjusted cart to session variable 
			//echo (toXml($cart));   				// send XML form of CART to client
		  }
		  else
		  {
			//if $value["qty"] > curQty
			//=> error
			$value = $cart[$id];
			$value["price"] = $price;
			$value["qty"] = $value["qty"] + 1;          
			$cart[$id] = $value;
			$_SESSION["cart"] = $cart;
			
			//subtracting 1 from the quantity available and adding 1 to the quantity on hold 
			//echo (toXml($cart));
		  }
		}
		else{
		 echo "sorry";  
	  	 return; 
		}
      }
      else 											//proccess remove function
      {
        $value = $cart[$id];
        $value["price"] = $price;
        $value["qty"] = $value["qty"] - 1;
		$cart[$id] = $value;
		if ($value["qty"]==0)
		{			
			unset($cart[$id]);
		}
        $_SESSION["cart"] = $cart;
        //echo (toXml($cart)); 
        
      }
    }
    elseif ($action == "Add")											//created a new cart session with the particular book
    {
      $value = array();
      $value["price"] = $price;
      $value["qty"] = "1";
      
      $cart = array();
      $cart[$id] = $value;
      $_SESSION["cart"] = $cart;
      //echo (toXml($cart));
    }
	updateCart($xml,$cart,$id,$action);
}
function updateCart($xml,$cart,$id,$action)
{
  ////update catalog
  $xpath = new DOMXPath($xml);
  //
  //// We starts from the root element
  $query = "//items/item[id='".$id."']";
  $entries =$xpath->query($query);

  foreach ($entries as $entrie) {
	$qtyGet = 1;
	if($action=="Add")
	  $qtyGet = 1;
	elseif($action=="Remove")
	  $qtyGet = -1;
	  
	$currentQty = $entrie->getElementsByTagName("quantity")[0]->nodeValue;
    $entrie->getElementsByTagName("quantity")[0]->nodeValue =$currentQty  - $qtyGet;
	
	$currentHoldon = $entrie->getElementsByTagName("holdon")[0]->nodeValue;	
	$entrie->getElementsByTagName("holdon")[0]->nodeValue = $currentHoldon + $qtyGet;
	
	$strXml = $xml->saveXML();
	$fileXMLPath = $GLOBALS['fileXMLPath'];
	$xml->save($fileXMLPath);
  }

  echo (toXml($cart));
}
function toXml($shop_cart)
{
  $newDoc = new DOMDocument("1.0");
  $root = $newDoc->createElement("items");
  $root = $newDoc->appendChild($root);		
  //$newDoc->FormatOutput = true;
  foreach ($shop_cart as $id => $ItemDetail)
  {
    $itemNode = $newDoc->createElement("item");
    $itemNode = $root->appendChild($itemNode); //add item tag inside items
		
    addANodeValue("id",$id, $itemNode, $newDoc);
  	addANodeValue("price",$ItemDetail["price"], $itemNode, $newDoc);
    addANodeValue("quantity",$ItemDetail["qty"], $itemNode, $newDoc);
	
  }
  $strXml = $newDoc->saveXML();
  return $strXml;
}

function addANodeValue($nodeChildName,$value, $nodeParent, $root)
{
	$node = $root->createElement($nodeChildName);
	$node = $nodeParent->appendChild($node);
	$value_node = $root->createTextNode($value);
	$value_node = $node->appendChild($value_node);
}	
function findItem($xml, $id,$lookNode)
{
  $itemList = $xml->getElementsByTagName("item");
  if($itemList->length > 0)
  {
	foreach($itemList as $item)
	{
	  $itemNumber = $item->getElementsByTagName("id")[0]->nodeValue;
	  if($itemNumber == $id)
	  {
		$price = $item->getElementsByTagName($lookNode)->item(0)->nodeValue;
		return $price;
	  }
	}
  }
  //way2
  /*
  if($xml->item->count() > 0)
	{
		foreach($xml->item as $item)
		{
			if($item->itemNumber == $id)
			{
				return $item->itemPrice;       
			}
		}
	}
	*/
}

function PurchaseItem($xml,$action)
{
  if($action == "Confirm")
  {
	$totalAmount = 0;
	$cart = $_SESSION["cart"];
	foreach($cart as $id=>$value)
	{
	  $price= $value["price"];
	  $qty = $value["qty"];
	  $totalAmount += (float)$price * $qty;
	 
	  $xpath = new DOMXPath($xml);
	  $query = "//items/item[id='".$id."']";
	  $entries =$xpath->query($query);
	  foreach ($entries as $entrie) {
		$currentHoldon = $entrie->getElementsByTagName("holdon")[0]->nodeValue;	
		$entrie->getElementsByTagName("holdon")[0]->nodeValue = 0;
		
		$entrie->getElementsByTagName("sold")[0]->nodeValue =$currentHoldon;
		
		//save to xml file
		$strXml = $xml->saveXML();
		$fileXMLPath = $GLOBALS['fileXMLPath'];
		$xml->save($fileXMLPath);
	  }
	  //remove this item
	  unset($cart[$id]);  
	  
	}
	$_SESSION["cart"]= $cart;
	echo $totalAmount;
  }
  else
  {
	$cart = $_SESSION["cart"];
	foreach($cart as $id=>$value)
	{
	  $xpath = new DOMXPath($xml);
	  $query = "//items/item[id='".$id."']";
	  $entries =$xpath->query($query);
	  foreach ($entries as $entrie) {
		$currentHoldon = $entrie->getElementsByTagName("holdon")[0]->nodeValue;	
		$entrie->getElementsByTagName("holdon")[0]->nodeValue = 0;
		
		$currentQty = $entrie->getElementsByTagName("quantity")[0]->nodeValue;
		$entrie->getElementsByTagName("quantity")[0]->nodeValue =$currentQty + $currentHoldon;
		
		//save to xml file
		$strXml = $xml->saveXML();
		$fileXMLPath = $GLOBALS['fileXMLPath'];
		$xml->save($fileXMLPath);
	  }
	  //remove this item
	  unset($cart[$id]);
	}
	$_SESSION["cart"]= $cart;
  }
}