<?php
session_start();

header('Content-Type: text/xml, text/plan');
//txtfile
$filePath = "../../data/managers.txt";
if(isset($_POST["admin_name"]) && isset($_POST["password"]))
{
	$admin_name = trim($_POST["admin_name"]);
	$password = trim($_POST["password"]);
	$result ="false";
	
	$file = fopen($filePath, "r") or die("Unable to open file!");

	while(!feof($file)) {
		$line = fgets($file);
		$arr = explode(",",$line);
		$name = trim($arr[0]);
		$pass = trim($arr[1]);
		/*$token = trim(strtok($line, ","));
		
		$name = $token;
		$pass = trim(strtok(","));
		*/
		
		if(strcmp($name, $admin_name)==0 && strcmp($pass, $password)==0)
		{ 
			$_SESSION["id_admin"] = $admin_name;
			$result = "true";
		}		
	}
	
	//user&pass doest found
	//echo "Name or password are incorrect!";
	echo $result;

	fclose($file);
}
?> 