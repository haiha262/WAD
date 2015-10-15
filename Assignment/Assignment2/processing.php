<?php
session_start();
header("Content-Type:text/xml");
if(!isset($_SESSION["id"]))
{
  echo "login";
  return;
}

//access
  
$fileXMLPath = "./home/students/accounts/s4959353/cos80021/www/data/goods.xml";
$fileXSLPath = "./home/students/accounts/s4959353/cos80021/www/data/goods_noneZero.xsl";
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

  
  if($action == "load")
  {
    load($xml);	
  } 
}


function load($xml)
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

