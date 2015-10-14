<?php
session_start();
header("Content-Type:text/xml");
if(isset($_SESSION["id"]))
{
  $filePath = "./home/students/accounts/s4959353/cos80021/www/data/goods.xml";
  //load category
  $id ="";
  $price ="";
  
  if(isset($_POST["request"]))
  {
    $action = $_POST["request"];
    
    
    //filter xml without hold on and qty >0
    $xml = new DomDocument('1.0');
    $xml->load($filePath);
    
    //way2
    //  $xml = simplexml_load_file($filePath);  
  
    if($action == "load")
    {
      echo  $xml->saveXML(); ;
    //way 2
    //echo $xml->asXML();
    }
  }
}
else
{
  echo "login";
}