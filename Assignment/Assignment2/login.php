<?php
//AnhQuan 4984153
session_start();
header('Content-Type: text/xml, text/plan');
//xmlfile
$xmlCustomerFilePath = "/home/students/accounts/s4984153/cos80021/www/data/customer.xml";
//load xml


if(file_exists($xmlCustomerFilePath))
{
	$customerXML = simplexml_load_file($xmlCustomerFilePath);
	
	if(isset($_POST["email"]) && isset($_POST["password"]))
	{		
		$email = $_POST["email"];
		$password = $_POST["password"];
		$result ="";		
		foreach($customerXML->customer as $customer)
		{
			if($customer->email == $email && $customer->password == $password)
			{
				$result = "true";
				$aCustomer["customer"] = array(
						"id" => (int)$customer->id,
						"firstname" => (string)$customer->firstname,
						"surname" => (string)$customer->surname,
						"email" => (string)$customer->email
						);
						$_SESSION["customer"] = $aCustomer["customer"];			
			}
			
		}
		echo $result; 		
	}

	else
	{
		echo "Sending request problem";
	}
	
}
else
{
	echo "File not found";
}




?> 