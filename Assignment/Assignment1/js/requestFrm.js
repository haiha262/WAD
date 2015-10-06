// JavaScript Document
$desc = $weight = "";
$pickup_address =$pickup_suburb = "";
$day = $month = $year = "";
$hour = $min = "";
$receiver_name = $receiver_address = $receiver_suburb = $state = "";
$cost = 0;

$pickAfter = 24;//hour
$startHour = "7:30";
$endHour = "20:30";
$(document).ready(function(){
	
	loadOldValue();
	//testing(); 
	$("#requestform").submit(function(e) {
		return validateFrm();
    });
});

function loadOldValue()
{
}

function testing()
{
	$dateString = "2015-08-22T14:21:01";
	$checkDate =  new Date($dateString)
	$now = new Date();
	$result = compareTime($checkDate,$now);
    //$dateParts = $dateString.split(' ');
//    $timeParts = $dateParts[1].split(':');
//
//
//    $dateParts = $dateParts[0].split('-');
//
//	$date = new Date($dateParts[2], parseInt($dateParts[1], 10) - 1, $dateParts[0], $timeParts[0], $timeParts[1]);
//	
//	console.log($date.getTime()); //1379426880000
//	console.log($date); //Tue Sep 17 2013 10:08:00 GMT-0400
	}

function compareTime($pickupTime, $checkTime)
{ 
	$afterTime = $pickAfter * 60 * 60000;//miliseconds
	
	$timePick =$pickupTime.getTime();
	$timeCheck = $checkTime.getTime();
	
	$realCheck =  $checkTime.getTime() + $afterTime
	$date = new Date($realCheck);
	$distDay = $pickupTime- $date;
	
	
	$dist = $pickupTime.getTime()- $realCheck;
	
	return $dist>0? true : false;
}

function calCost()
{

	if($weight <= 2 && $weight > 0)
	{
		$cost = 10;
	}
	else if($weight > 2)
	{
		$extra = $weight - 2;
		$cost = 10 + $extra*2;
	}
}

function validateFrm()
{
	$desc = $("#desc").val();
	$weight = $("#weight option:selected").val();
	
	$pickup_address = $("#pickup_address").val();
	$pickup_suburb = $("#pickup_suburb").val();
	$day = $("#day option:selected").val();
	$month = $("#month option:selected").val();
	$year = $("#year option:selected").val();
	
	$hour = $("#hour option:selected").val();
	$min = $("#minute").val();
	
	
	$receiver_name = $("#receiver_name").val();
	$receiver_address = $("#receiver_address").val();
	$receiver_suburb = $("#receiver_suburb").val();
	$state = $("#state option:selected").val();
/*
	$string = ""
	$string += $desc + " ";
	$string += $weight + " ";
	alert($string);
*/
	$status = true;
	$error = "";
//CHECK WIEGHT
	if($weight==0)
	{
		$status = false;
		$error += "Please select weight <br/>";
	} 

//CHECK DATE
	if( $day == 0 || $month == 0 || $year == 0 )
	{
		$status = false;
		$error += "Please select date <br/>"; 
	}
	else
	{

		$time=new Date($year+"/"+$month+"/"+$day +  " " + $hour +":" +$min);
		$now = new Date();
		if(!compareTime($time,$now))
		{
			$status = false;
			$error += "Please select date after 24h form now.<br/>"; 
		}
			
	}
	//check HOUR
	
	$timeStart = $startHour.split(":");
	$timeEnd = $endHour.split(":");
	if(parseInt($hour) == 0 
	|| parseInt($timeStart[0]) > parseInt($hour) 
	|| parseInt($hour) > parseInt($timeEnd[0])
	)
	{
		$status = false;
		$error += "Please check hour. Time to pick up from " + $startHour + " to " + $endHour +"<br/>"; 
	}
	else
	{
		if(
		(parseInt($min) > 60 && parseInt($min) < 0)
		|| ( parseInt($timeStart[0])==parseInt($hour) && parseInt($min) < parseInt($timeStart[1]) )
		|| (parseInt($hour)==parseInt($timeEnd[0]) && parseInt($min) > parseInt($timeEnd[1]) )
		)
		{
			$status = false;
			$error += "Please check minutes. Time to pick up from " + $startHour + " to " + $endHour +"<br/>"; 
	
		}
	}
	
	
	if($state == 0)
	{  
		$status = false;
		$error +="Please select your state <br/>";
	}

	if($status == false)
	{
		$("#notification").addClass("error");
		$("#notification").html($error); 
	}
	else
	{
		calCost();
		$("#pickupTime").val($hour+":"+$min);
		$("#pickupDate").val($year+"/"+$month+"/"+$day);
		$("#cost").val($cost);
	}
	//return false;
	return $status;
}