<?php
session_start();
header('Content-Type: text/plan');

//check session
if(isset($_POST["request"]))
{
	$request = trim($_POST["request"]);
	if(strcmp($request,"check")==0)
	{
		if(isset($_SESSION["admin_name"]))
		{			
			echo "true";
		}
		else
		{			
			echo "false";
		}
	}
	else
	{
		if(strcmp($request,"destroy")==0)
		{
			$id = $_SESSION["admin_name"];
			//session_destroy();			
			echo $id;
		}
	}
}
?>