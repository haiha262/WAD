<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>ShipOnline Registration System</title>
<meta name="ShipOnline" />
<meta name="Tran Ha" />
<meta name="viewport" content="width=device-width, maximum-scale=1.0, user-scalable=2.0;" />
<link rel="stylesheet" href="styles/style.css" />
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/script.js"></script>

</head>

<body>
<header>
  <h1> ShipOnline System Registration Page </h1>
</header>

<?php

$success = false;
$strClass = "";
$strErr = "";
// Checking table is exist
	require_once("setting.php");
	$conn = @mysqli_connect($host,$user,$pwd, $sql_db);
	if(!$conn)
	{
		echo"<p>Database Connect failure\n";
		die('Connect Error (' . mysqli_connect_errno() . ')'. mysqli_connect_error());
	}
	else
	{
				// Upon successful connection
				
				checkExistTable($conn);
	}

function checkExistTable($conn)
{
	$sql_table='customer';
	
	if ($conn) 
	{
		
		$query = "create table IF NOT EXISTS customer (
			customer_number	varchar(50) NOT NULL,	
			name varchar(50) NOT NULL,
			password varchar(50) NOT NULL,
			email varchar(50)  NOT NULL,
			phone varchar(12) NOT NULL,
    PRIMARY KEY(customer_number,email)  
)";
	
		$results = mysqli_query ($conn, $query);				
	}
	else 
	{
		echo "<div class=\"error\">Database Connection Error</div>";
	}
}

if ($_SERVER['REQUEST_METHOD']== "POST") 
{
	$name = $_POST["name"];
	$email = $_POST["email"];
	
	$password = $_POST["password"];
	$confirm_password = $_POST["confirm_password"];
	$phone = $_POST["phone"];
	
	
		
	//check password
	if($password != $confirm_password)
	{
		$GLOBALS['success']=false;
		echo "<div class=\"error\">Password does not match!</div>";
	}
	else
	{
		addNewRecord($conn,$name,$password,$email,$phone);
	}
}

function addNewRecord($conn,$name,$password,$email,$phone)
{

	$sql_table = "customer";
	$query = "SELECT * FROM $sql_table WHERE email = '$email'";
	$result = mysqli_query($conn,$query);
	if(!$result)
	{
		echo "<div class=\"error\"> The query error</div>";
	}
	else
	{	
		//echo "query : ", $query , "<br/>";
		//echo 'mysqli_num_rows($result): ' , mysqli_num_rows($result);
		if(mysqli_num_rows($result)==0)
		{
		  $customerNo= uniqid();
		  $query = "INSERT INTO `$sql_table` (`customer_number`,`name`,`password`,`email`,`phone`)
		  VALUES(
		  '$customerNo',
		  '$name',
		  '$password',
		  '$email',
		  '$phone'
		  )";
		  //echo "query: ", $query;
		  $result2 = mysqli_query($conn,$query);
		  if($result2)
		  {
			  $GLOBALS['success']=true;
			  $GLOBALS['strClass'] = "class=\"success\"";
			  $GLOBALS['strErr'] .="<p>Dear ".$name.", you are successfully registered into ShipOnline</p>";
			  $GLOBALS['strErr'] .= "<p>Your customer number is ". $customerNo. "</p>";
			 
			  session_start();
			  //set _session here
			  //$_SESSION['customer_number'] = $customerNo;
		  }
	  }
	  else
	  {
			$GLOBALS['strClass'] = "class=\"error\"";
			$GLOBALS['strErr'] .="This email exists ";			
	  }
	}
	
}	

?>
<fieldset>
<form id="registeration" method="post" action="register.php">
 <p> <label for="name">Name: </label>
  <input id="name" type="text" name="name" required/></p>
  
  <p><label for="password">Password: </label>
  <input id="password" type="password" name="password" required="required"/></p>
  
  <p><label for="confirm_password">Confirm Password: </label>
  <input id="confirm_password" type="password" name="confirm_password" required="required"/></p>
  
  <p><label for="email">Email Address: </label>
  <input id="email" type="email" name="email" size="" required="required"/></p>
  
 <p> <label for="phone">Contact Phone: </label>
  <input id="phone" type="tel" name="phone" required="required" /></p>
  
  <input id="register" type="submit" name="register" value="Register" />
</form>
</fieldset>
<div id="notification" <?php echo $strClass;?>><?php	 echo $strErr;	 ?></div>
<p> <a href="shiponline.php">Home</a> </p>
<?php
mysqli_close ($conn);
?>
</body>
</html>