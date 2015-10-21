<?php
header("Content-type: text/xml "); //  have to set this for IE
$filePath = "../../data/customers.xml";
//$filePath = "./data/customers.xml";
if(!file_exists($filePath))
{
	//create new file and save to the path
	$newDoc = new DOMDocument("1.0");
	$root = $newDoc->createElement("customers");
	$root = $newDoc->appendChild($root);		
	$newDoc->FormatOutput = true;
	$newDoc->saveXML();
	$newDoc->save($filePath);		

}
		
	$customerId= uniqid();
	$firstname = $_POST["fname"];
	$lastname = $_POST["lname"];
	$password = $_POST["password"];
	$phone = $_POST["phone"];
	$email = $_POST["email"];
	
	$way1 = false;
	if($way1)//way 1
	{
		//////////////================///////////////
		//Option1
		$xml=simplexml_load_file($filePath);
		if(!checkEmail($email,$xml))
		{
			echo "false";
		}
		else //insert new customer
		{
						
			$xml = $xml->asXML();
			$customersNode = new SimpleXMLElement($xml);
			
			//add new node customer
			$customerNode = $customersNode->addChild("customer"); 		
			//add new node in customer
			$customerNode->addChild("id", $customerId); 
			$customerNode->addChild("firstname", $firstname);
			$customerNode->addChild("lastname", $lastname);
			$customerNode->addChild("password", $password);
			$customerNode->addChild("email", $email);
			$customerNode->addChild("phone", $phone); 
			//save into file	
			$customersNode->asXML($filePath);
			echo "true";
		}
		//////////////================///////////////
	}
	else //way 2
	{

		$xml = new DOMDocument();
		$xml->load($filePath);
		
		if(!checkEmail($email,$xml))
		{
						echo "false";
		}
		else //insert new customer
		{
				//$customers = $xml->getElementsByTagName('Customers');
				//$customers = $customers->item(0);
				//OR
				$firstElement = $xml->firstChild;
				// add new node into root
				$customer = $xml->createElement('customer');
				$customer = $firstElement->appendChild($customer);
				
				addANodeValue('id',$customerId,$customer,$xml);
				addANodeValue('firstname',$firstname,$customer,$xml);
				addANodeValue('lastname',$lastname,$customer,$xml);
				addANodeValue('password',$password,$customer,$xml);
				addANodeValue('email',$email,$customer,$xml);
				addANodeValue('phone',$phone,$customer,$xml);
				
				$strXml = $xml->saveXML(); 
				$xml->save($filePath);
				
				
				echo "true";
		}
					
	}

function addANodeValue($nodeChildName,$value, $nodeParent, $root)
{
	$node = $root->createElement($nodeChildName);
	$node = $nodeParent->appendChild($node);
	$value_node = $root->createTextNode($value);
	$value_node = $node->appendChild($value_node);
}	
//check existing email
function checkEmail($email, $xml)
{
				if($GLOBALS["way1"])
				{
						if($xml->customer->count() > 0)
						{
								foreach($xml->customer as $customer)
								{
										if($customer->email == $email)
										{
										return false;
										}
								}
						}
						
						return true;
				}
				else
				{
						$emailTag = $xml->getElementsByTagName("email");
						for($i=0; $i<$emailTag->length ; $i++)
						{
								$str = $emailTag->item($i)->nodeValue;
								if( strcmp($str, $email)==0)
										return false;
						}
						return true;
								
				}
}
?>