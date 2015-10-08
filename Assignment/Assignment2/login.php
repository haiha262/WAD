<?php
session_start();
header('Content-Type: text/xml, text/plan');

$filePath = "./home/students/accounts/s4959353/cos80021/www/data/customers.xml";
$email ="";
$password ="";
$result ="false";

if(isset($_POST["email"]) && isset($_POST["password"]))
{
	$email=trim($_POST["email"]);
	$password=trim($_POST["password"]);
	if(file_exists($filePath))
	{
		$xml = new DomDocument('1.0');
		$xml->load($filePath); 
		//way2
		//$xml=simplexml_load_file($filePath);
		
		if(checkUser($email,$password,$xml))
		{
			$result = "true";
		}
	}
	else
	{
		echo "Unable to open file!";
	}

	//user&pass doest found
	//echo "Name or password are incorrect!";
	echo $result;

	
}
function checkUser($email,$password, $xml)
{
	$customerList = $xml->getElementsByTagName('customer');
	if($customerList->length>0)
	{

		foreach($customerList as $customer)
		{
			$curEmail =$customer->getElementsByTagName('email')->item(0)->nodeValue;
			$curPass = $customer->getElementsByTagName('password')->item(0)->nodeValue;
			if($curEmail == $email && $curPass == $password)
			{
				$_SESSION["id"] = $customer->getElementsByTagName('id')->item(0)->nodeValue;
				//$_SESSION["id"] = 123456;//$customer->id;
				return true;	
			}
		}
	}
	
	//way2
	/*
	if($xml->customer->count() > 0)
	{
			foreach($xml->customer as $customer)
			{
					$curEmail =$customer->email;
					$curPass = $customer->password;
					if($customer->email == $email && $customer->password == $password)
					{
						$_SESSION["id"] = $customer->id; ??not save the value
						//$_SESSION["id"] = 123456;//$customer->id;
						return true;
					}
			}
	}
	*/
	return false;
	
}
?> 