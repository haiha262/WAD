<?php
$error="";
session_start();
require_once("setting.php");
if ($_SERVER['REQUEST_METHOD']== "POST") 
{
	if(isset($_POST['customer_number'])  && isset($_POST['password']))
	{		
	  $customerNo= test_input($_POST["customer_number"]);
	  $password	= test_input($_POST["password"]);
	  $conn = @mysqli_connect($host,$user,$pwd,$sql_db);
	  if(!$conn)
	  {
		  $error = "<div class=\"error\">Error connection</div>";
	  }
	  else
	  {
		  $query = "SELECT * FROM customer WHERE 
					  customer_number='". $customerNo.
					  "' And password='". $password."'";
		  $result= mysqli_query($conn,$query);
		  if(mysqli_num_rows($result)>0)
		  {
			 header('Location:request.php');//NOT WORK ???
			  //$row = mysqli_fetch_assoc($result);
			  //mysqli_free_result($result);
			  //echo "login success"; 
			  
			  $_SESSION['customer_number'] = $customerNo; 
			  //echo $_SESSION['customer_number'] ;
			// $str = "<script> window.location.replace('request.php') <\/script>";
			 
			//echo $str;
            
		  }
		  else
		  {
			  $error = "<div class=\"error\">Customer number or password are incorrect</div>";
		  }
		  mysqli_close($conn);
	  }
	}
}
else
{
	unset($_SESSION['customer_number']);
}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>ShipOnline Login System</title>
<meta name="ShipOnline" />
<meta name="Tran Ha" />
<meta name="viewport" content="width=device-width, maximum-scale=1.0, user-scalable=2.0;" />
<link rel="stylesheet" href="styles/style.css" />
<script src="script.js"></script>
</head>

<body>
<header>
  <h1> ShipOnline System Login Page </h1>
</header>
<form id="loginform" method="post" action="login.php">
  <fieldset>
    <p><label for="customer_number">Customer Number: </label>
    <input id="name" type="text" name="customer_number" required="required" value="<?php if(isset($_POST['customer_number']) )echo $_POST["customer_number"];?>"/></p>
    
    <p><label for="password">Password: </label>
    <input id="password" type="password" name="password" required="required"/></p>
       <?php
echo $error;
	?>
    <input id="login" type="submit" name="login" value="Log in" />
  </fieldset>
</form>

<p> <a href="shiponline.php">Home</a> </p>
</body>
</html>