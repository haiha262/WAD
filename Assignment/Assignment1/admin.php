<?php
//session_start();
//if(isset($_SESSION['admin_number']))
//	{
//		$admin_number = $_SESSION['admin_number'];
//	}
//	else
//	{
//		header('Location:login.php');
//		$str = "<script> " ;
//		$str .= "window.location.replace('request.php') 
//		$str .= "<//script>";
//		//echo $str;
//	}
$debug = false;
$strClass = "";
$strErr ="";    
$strData="";
// constant for HTML layout
$year_ext = 2;
// Checking table is exist

	//if($debug)
//		require_once 'fb.php';
//	ob_start();
//		FB::log('Log message');

?>
<?php
if($_SERVER['REQUEST_METHOD']=="POST")
{
	
    
	$day= $_POST['day'];
	$month= $_POST['month'];
	$year= $_POST['year'];
	$dateTime =$day."-".$month."-".$year;
	$type_retrieve = $_POST['type_retrieve'];
	$date_check = date('Y-m-d',strtotime($dateTime));
	 
	if($debug)
	{
		 echo $date_check;
		 echo $type_retrieve;
	}
	//FB:log($date_check,"PHP");
	$sql_table = "request";
	$sql_table_join = "customer";
	$query = " SELECT * FROM `$sql_table` "; 
	if(strcmp($type_retrieve,"request")==0)
	{
		$query .= "Where request_date LIKE '" .$date_check ."%'";
	}
	elseif (strcmp($type_retrieve,"pickup")==0)
	{
		$query .= "INNER JOIN `$sql_table_join`
				ON $sql_table_join.customer_number = $sql_table.customer_number
			Where pickup_date LIKE '" .$date_check ."%' ";
		$query .= "ORDER BY ";
		$query .= "pickup_suburb ASC, state ASC, delivery_suburb ASC ";
	}
	if($debug) echo $query;
	
	require_once("setting.php");
	$conn = @mysqli_connect($host,$user,$pwd, $sql_db);
	if(!$conn)
	{
		$strClass = "class=\"error\"";
		$strErr = "Database Connect failure";
		die('Connect Error (' . mysqli_connect_errno() . ')'. mysqli_connect_error());
	}
	$result = mysqli_query($conn,$query);

	$totalRevenue =0;
	$totalWeight =0;
	if($result)	
	{
		if (mysqli_num_rows($result)>0)
		{	
			$strData = "<table border=\"1\">";
			$strData .="<tr>
					<th>Customer number</th>";
				if(strcmp($type_retrieve,"pickup")==0)
				{
					$strData .= "<th>Customer name</th>
								<th>Contact phone</th>";
				}
			$strData .="<th>Request number</th>
					<th>Item description</th>
					<th>Weight</th>";
				if(strcmp($type_retrieve,"pickup")==0)					
				{
					$strData .= "<th>Pickup address</th>";
				}
    		
			$strData .="<th>Pick-up suburb</th>
					<th>Preferred pick-up date</th>
					<th>Delivery suburb</th>
    				<th>State</th>
				  </tr>";
			while($row = mysqli_fetch_assoc($result)) 
			{	
				if(strcmp($type_retrieve,"request")==0)
				{	
					$totalRevenue+=calCost($row["weight"]);
					//if($debug) echo $totalRevenue . " ";
				}
				else
				{
					$totalWeight += $row["weight"];
				}
				$strData .="<tr>";				
 				
				$strData .="<td>". $row["customer_number"] ."</td>";
				
				if(strcmp($type_retrieve,"pickup")==0)
				{
					$strData .="<td>". $row["name"] ."</td>";
					$strData .="<td>". $row["phone"] ."</td>";
				}
				
				$strData .="</td>";
				
				$strData .="<td>". $row["request_number"] ."</td>
						<td>". $row["description"] ."</td>
						<td>". $row["weight"] ."</td>";
				if(strcmp($type_retrieve,"pickup")==0)
				{
					$strData .="<td>". $row["pickup_address"] ."</td>";
				}
				$strData .="<td>". $row["pickup_suburb"] ."</td>
						<td>". $row["pickup_date"] ."</td>
						<td>". $row["delivery_suburb"] ."</td>
						<td>". $row["state"] ."</td>
						
					  </tr>";
				
			}//end while
			
			$strData .="<tr>";
			if(strcmp($type_retrieve,"request")==0)
			{
					$strData .="<td colspan=\"7\">";
			}
			else
			{
				$strData .="<td colspan=\"10\">";
			}
			$strData .="<strong>The total number of requests</strong></td>
						<td>". mysqli_num_rows($result) ."</td>
						  </tr>";
			if(strcmp($type_retrieve,"request")==0)
			{
				$strData .="<tr>
						<td colspan=\"7\"><strong>The total Revenue</strong></td>
					    <td>". $totalRevenue ."</td>
					  </tr>";
			}
			else //pick up
			{
				$strData .="<tr>
						<td colspan=\"10\"><strong>The total weight</strong></td>
					    <td>". $totalWeight ."</td>
					  </tr>";
			}
			$strData .="</table>";
		}
		else
		{
		$strClass = "class=\"error\"";
		$strErr = "Empty result";
		}
		
	}
	else
	{
		$strErr ="<div class=\"error\">";
		$strErr .= "Something wrong";
		$strErr .="</div";
	}
		
}

function calCost($weight)
{
	$cost = 0;
	if($weight <= 2 && $weight > 0)
	{
		$cost = 10;
	}
	elseif ($weight > 2)
	{
		$extra = $weight - 2;
		$cost = 10 + $extra*2;
	}
	return $cost;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>ShipOnline Administration System</title>
<meta name="ShipOnline" />
<meta name="Tran Ha" />
<meta name="viewport" content="width=device-width, maximum-scale=1.0, user-scalable=2.0;" />
<link rel="stylesheet" href="styles/style.css" />
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/adminFrm.js"></script>
</head>
<body>
<h1>ShipOnline System Administration Page</h1>
<form  id="adminform" action="admin.php" method="post">
  <fieldset>
    <p>
      <label for="day">Date for Retrieve:</label>
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
            
            $curr_year = date("Y");
            $select = "";
            for ($year = $curr_year-100; $year <= $curr_year + $year_ext; $year++)
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
      <label for="hour">Select Date Item for Retrieve:</label>
      <input type="radio" name="type_retrieve" id="retrieve_request" class="chkbox" value="request" checked="checked"/>
      Request Date
      <input type="radio" name="type_retrieve" id="retrieve_pickup" class="chkbox" value="pickup" />
      Pick-up Date<br/>
    <div id="notification" <?php echo $strClass;?> >
      <?php	 echo $strErr; ?>
    </div>
    <p>
      <input type="submit" name="show" value="Show"/>
    </p>
  </fieldset>
</form>
<p>
  <?php
  //print out data table
  echo $strData;
?>
</p>
<p> <a href="shiponline.php">Home</a> </p>
</body>
</html>