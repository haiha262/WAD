<?php
session_start();
header("Content-Type:text/xml");
if(!isset($_SESSION["id"]))
{
  echo "login";
  return;
}

//access
  
$fileXMLPath = "../../data/goods.xml";
$fileXSLPath = "../../data/goods_noneZero_qty.xsl";
$fileXSL_process = "../../data/goods_process.xsl";
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
  else if($action == "process")
  {
    process($xml);	
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
      $xmlTrans = $proc->transformToXML($xml);
      $xmlTrans = simplexml_load_string($xmlTrans);
      $resultXml= $xmlTrans->saveXML();
      $_SESSION["process"] = $resultXml;
	  echo $resultXml;
	}
	else
	{	
	  echo  $xml->saveXML();
	  //way 2
	  //echo $xml->asXML();
	}
}

function process($xml)
{
  /* load xsl*/
	$filter=true;//remember edit on js file
	if($filter)
	{
	  $xmlSession = $_SESSION["process"];
      //$xmlSession = simplexml_load_string($xmlSession);      

      $xml=new DOMDocument;
      $xml->loadXML($xmlSession);

      $fileXSLPath =$GLOBALS["fileXSL_process"];
	  $xslDoc = new DomDocument;
	  $xslDoc->load($fileXSLPath);
	  //combine xsl into xml
	  $proc = new XSLTProcessor;
	  $proc->importStyleSheet($xslDoc);
      $xmlTrans = $proc->transformToXML($xml);
      $xmlTrans = simplexml_load_string($xmlTrans);
      $resultXml= $xmlTrans->saveXML();
      
	  processFile($xml);
	  echo $resultXml;
	}
	else
	{	
	  echo  $xml->saveXML();
	  //way 2
	  //echo $xml->asXML();
	}
}

