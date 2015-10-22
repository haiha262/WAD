<?php
session_start();
header('Content-Type: text/plan');

//check session
if(isset($_POST["request"]))
{
	$request = trim($_POST["request"]);
	if(strcmp($request,"admin")==0)
	{
		if(isset($_SESSION["id_admin"]))
		{			
			$id = $_SESSION["id_admin"];
			//session_destroy();
			unset($_SESSION["id_admin"]);
			echo $id;
		}
	}
	else
	{
		if(strcmp($request,"user")==0)
		{
			if(isset($_SESSION["id"]))
			{
			$id = $_SESSION["id"];
			unset($_SESSION["id"]);	
			echo $id;
			}
		}
	}
}
?>