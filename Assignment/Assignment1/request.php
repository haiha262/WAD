<?php
	session_start();
	
$debug   = false;
$strClass = "";
$strErr = "";
	if($debug) echo $_SESSION['customer_number']. "<br/>" ; 
	if(isset($_SESSION['customer_number']))
	{
		//echo "111";
		$customer_number = $_SESSION['customer_number'];
	}
	else
	{
		header('Location:login.php');
		//$str = "<script> window.location.replace('login.php') <\/script>";
		//echo $str;
	}
// Checking table is exist
	require_once("setting.php");

	$conn = @mysqli_connect($host,$user,$pwd, $sql_db);
	if(!$conn)
	{
		echo"<p>Database Connect failure";
		die('Connect Error (' . mysqli_connect_errno() . ')'. mysqli_connect_error());
	}
	else
	{
				checkExistTable($conn);
	}

function checkExistTable($conn)
{
	$sql_table='customer';
	
	if ($conn) 
	{
		
		$query = "create table IF NOT EXISTS request (
			request_number varchar(13) NOT NULL,
			customer_number	varchar(13) NOT NULL,	
			description varchar(50) NOT NULL,
			weight varchar(50) NOT NULL,
			pickup_address varchar(50) NOT NULL ,
			pickup_suburb 	varchar(4) NOT NULL,
			pickup_date	datetime,
			receiver_name	varchar(20) NOT NULL,
			delivery_address	varchar(50) NOT NULL,
			delivery_suburb	varchar(4) NOT NULL,
			state	int(11) NOT NULL,
            request_date` DATE NOT NULL ,
			PRIMARY KEY (request_number),
			FOREIGN KEY (customer_number) REFERENCES customer(customer_number)
			)";
	
		$results = mysqli_query ($conn, $query);				
	}
	else 
	{
		$strClass = "class=\"error\"";
		$strErr= "Database Connection Error";
	}
}

function sendMail($customer_number)
{
	$sql_table = "customer";
	$query = "SELECT * FROM `$sql_table` WHERE customer_number = '$customer_number'";
	if($debug) echo $query;
	$result = mysqli_query($conn,$query);
	if($result)	
	{
		//send email
		$to = $email;
		$subject = "Shipping request with ShipOnline";
		$message = "Dear <$name>, Thank you for using ShipOnline! ";
		$message .="Your request number is " . $_SESSION['request_number'].". The cost is " .$_SESSION['cost'].". ";
		$message .="We will pick-up the item at ". $_POST['pickupTime']. " on " .$_POST['pickupDate'].".";
		$headers = "From: ShipOnline <shiponline@swin.edu.au>";
		
		if($debug) echo ($to ." ". $subject." ". $message." ". $headers." ". "-r 4959353@student.swin.edu.au");
		mail($to, $subject, $message, $headers, "-r 4959353@student.swin.edu.au");

		
	}
}
if($_SERVER['REQUEST_METHOD']=="POST")
{
	
	$request_number = uniqid();
	$desc = $_POST['desc'];
	$weight = $_POST['weight'];
	$pickup_address = $_POST['pickup_address'];
	$pickup_suburb = $_POST['pickup_suburb'];
	$pickupDate= $_POST['pickupDate'];
	$pickupTime= $_POST['pickupTime'];
	$dateTime = $pickupDate . " " . $pickupTime;
	
	$receiver_name = $_POST['receiver_name'];
	$receiver_address = $_POST['receiver_address'];
	$receiver_suburb = $_POST['receiver_suburb'];
	$state = $_POST['state'];
	$cost = $_POST['cost'];
	if($debug)
	{
		echo $cost ," " , $dateTime. "<br/>";
		//$customer_number = "55cd777452ff6";
	}
    $current_date = date('Y/m/d');
    
	$sql_table = "request";
	$query = " INSERT INTO `$sql_table` (
			request_number,
			customer_number,	
			description ,
			weight ,
			pickup_address,
			pickup_suburb ,
			pickup_date,
			receiver_name	,
			delivery_address,
			delivery_suburb	,
			state,
            request_date )
			VALUES (
			'$request_number',
			'$customer_number',
			'$desc',
			'$weight',
			'$pickup_address',
			'$pickup_suburb',
			'$dateTime',
			'$receiver_name',
			'$receiver_address',
			'$receiver_suburb'	,
			'$state',
            '$current_date'			)";
		if($debug) echo $query. "<br/>";
		$result = mysqli_query($conn,$query);
		if($result)	
		{
			//echo "OK"; 
			$_SESSION['cost'] = $cost;
			$_SESSION['request_number'] = $request_number;
			$strClass = "class=\"success\"";
			$strErr .="Thank you! <br/>Your request number is <strong>$request_number</strong>.<br/>";
			$strErr .= "The cost is <strong>$cost</strong>.<br/> ";
			$strErr .= "We will pick-up the item at $pickupTime on $pickupDate";
	
			//sendMail($customer_number);
			
			$sql_table = "customer";
			$query = "SELECT * FROM `$sql_table` WHERE customer_number = '$customer_number'";
			if($debug) echo $query . "<br/>";
			$result = mysqli_query($conn,$query);
			if($result)	
			{
				$row = mysqli_fetch_assoc($result);
				//send email
				$to = $row['email'];
				if($debug) $to = "haiha262@gmail.com";
				$subject = "Shipping request with ShipOnline";
				$message = "Dear ".$row['name'].", Thank you for using ShipOnline! ";
				$message .="Your request number is " . $_SESSION['request_number'].". The cost is " .$_SESSION['cost'].". ";
				$message .="We will pick-up the item at ". $_POST['pickupTime']. " on " .$_POST['pickupDate'].".";
				$headers = "From: ShipOnline <shiponline@swin.edu.au>";
				
				if($debug) echo ($to ." ". $subject." ". $message." ". $headers." ". "-r 4959353@student.swin.edu.au<br/>");
				$success = mail($to, $subject, $message, $headers, "-r 4959353@student.swin.edu.au");
				if($debug) echo "send success " . $success;
		
				
			}
		}
		else
		{
			$strClass = "class=\"error\"";
			$strErr .= "Something wrong";
	
		}
			
}

?>
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
<script src="js/requestFrm.js"></script>
</head>

<body>
<form  id="requestform" action="request.php" method="post">
  <fieldset>
    <p>Item Information</p>
    <fieldset>
      <p>
        <label for="desc">Description:</label>
        <input name="desc" id="desc" type="text" required placeholder="Your description" <?php if($debug) echo "value=\"Your description\"" ?>/>
      </p>
      <p>
        <label for="weight">Weight:</label>
        <select name="weight" id="weight">
          <option value="0">Select Weight</option>
          <?php
		  for($i = 1;$i<=20;$i++)
		  echo" <option value=\"$i\">$i</option>";
		  ?>
        </select>
      </p>
    </fieldset>
    <p>Pick up Information</p>
    <fieldset>
      <p>
        <label for="pickup_address">Address:</label>
        <input name="pickup_address" id="pickup_address" type="text" required ="required" placeholder="pickup address" <?php if($debug) echo "value=\"pickup address\"" ?>/>
      </p>
      <p>
        <label for="pickup_suburb">Suburb:</label>
        <input name="pickup_suburb" id="pickup_suburb" type="text" required ="required" pattern="[0-9]{4}" placeholder="Your suburb code" title="It is a 4 digit number "  <?php if($debug) echo "value=\"1234\"" ?>/>
      </p>
      <p>
        <label for="day">Preferred date:</label>
        <select name="day" id="day">
          <option value="0">Day</option>
          <?php
		  $curr_day = date("d");
	 	  for($i = 1;$i<=31;$i++)
	 	  {
			   $select .= "<option value=\"$i\"";
			 if ($i == $curr_day) {
				 $select .= " selected=\"selected\">";
			 } else {
				 
			 $select .= ">";
			 }
			 $select .=	 $i . "</option>\n";
         }
		 echo $select;
		
	  ?>
        </select>
        <select name="month" id="month">
          <option value="0">Month</option>
          <?php
$curr_month = date("m");
$month = array (1=>"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
$select = "";
foreach ($month as $key => $val) {
    $select .= "\t<option value=\"".$key."\"";
    if ($key == $curr_month) {
        $select .= " selected=\"selected\">".$val."</option>\n";
    } else {
        $select .= ">".$val."</option>\n";
    }
}
echo $select;
?>
        </select>
        <select name="year" id="year">
          <option value="0">Year</option>
			<?php 
            $year_ext = 2;
            $curr_year = date("Y");
            $select = "";
            for ($year = $curr_year; $year <= $curr_year + $year_ext; $year++)
            {
				$select .= "<option value=\"$year\"";
				if ($year == $curr_year) {
				 	$select .= " selected=\"selected\">";
				} else {
					$select .= ">";
				}
				$select .=	 $year . "</option>\n";
            }
                echo $select;
            ?>
        </select>
      </p>
      <p>
        <label for="hour">Preferred time:</label>
        <select name="hour" id="hour">
          <option value="0">Hour</option>
          <?php
		  $startHour = 7;
			$endHour = 20;
	  for($i = $startHour;$i<=$endHour	;$i++)
	  echo" <option value=\"$i\">$i</option>";
	  ?>
        </select>
        <label for="minute">Minute:</label>
        <input name="minute" id="minute" type="text" pattern="[0-9]{1,2}" required = "required" placeholder="minutes" <?php if($debug) echo "value=\"34\"" ?>/>
      </p>
    </fieldset>
    <p>Delivery Information</p>
    <fieldset>
      <p>
        <label for="receiver_name">Receiver name:</label>
        <input name="receiver_name" id="receiver_name" type="text" required ="required" placeholder="receiver name" <?php if($debug) echo "value=\"receiver name\"" ?>/>
      </p>
      <p>
        <label for="receiver_address">Address:</label>
        <input name="receiver_address" id="receiver_address" type="text" required ="required" placeholder="receiver address" <?php if($debug) echo "value=\"receiver address\"" ?>/>
      </p>
      <p>
        <label for="receiver_suburb">Suburb:</label>
        <input name="receiver_suburb" id="receiver_suburb" type="text" required ="required" pattern="[0-9]{4}" placeholder="Your receiver suburb code" title="It is a 4 digit number " <?php if($debug) echo "value=\"4567\"" ?>/>
      </p>
      <p>
        <label for="state">State:</label>
        <select name="state" id="state">
          <option value="0">Select State</option>
          <?php
		  $state = array (1=>"VIC", "NSW", "QLD", "TAS", "WA", "SA", "NT", "ACT", "Outside Australia");
		  foreach($state as $key=>$val)
		  {
			  echo "<option value=\"$key\">$val</option>";
		  }
		  ?>
        </select>
      </p>
    </fieldset>
    <input type="hidden" name="cost" id="cost"/>
    <input type="hidden" name="pickupTime" id="pickupTime"/>
    <input type="hidden" name="pickupDate" id="pickupDate"/>
         <div id="notification" <?php echo $strClass;?>><?php	 echo $strErr;	 ?></div>
         
    <p>
      <input type="submit" name="request" value="Request"/>
    </p>
  </fieldset>
 
</form>
<p> <a href="shiponline.php">Home</a> </p>
</body>
</html>