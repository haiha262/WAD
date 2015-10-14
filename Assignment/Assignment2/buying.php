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
	/* load xsl*/

	$xslDoc = new DomDocument;
	$xslDoc->load($fileXSLPath);
	//combine xsl into xml
	$proc = new XSLTProcessor;
	$proc->importStyleSheet($xslDoc);
	echo $proc->transformToXML($xml);
	
	
    //echo  $xml->saveXML();
	//way 2
	//echo $xml->asXML();
  }
  else
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
        if (!isset($cart[$id]))
        {  
          $qty = 1; 							// increase no of books by 1
          $value = array();
          $value["price"] = $price;
          $value["qty"] = $qty;
                   
          $cart[$id] = $value;
          $_SESSION["cart"] = $cart;  		// save the adjusted cart to session variable 
          echo (toXml($cart));   				// send XML form of CART to client
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
          echo (toXml($cart));
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
        echo (toXml($cart)); 
        
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
      echo (toXml($cart));
    }                             
  }
  
}
function updateCart($xml)
{
  
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
function findItem($xml, $id)
{
  $itemList = $xml->getElementsByTagName("item");
  if($itemList->length > 0)
  {
	foreach($itemList as $item)
	{
	  $itemNumber = $item->getElementsByTagName("id")[0]->nodeValue;
	  if($itemNumber == $id)
	  {
		$price = $item->getElementsByTagName("price")->item(0)->nodeValue;
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