// JavaScript Document

$day = $month = $year = "";

$(document).ready(function(){
	

	$("#adminform").submit(function(e) {
		return validateFrm();
    });
});

function validateFrm()
{
	
	$day = $("#day option:selected").val();
	$month = $("#month option:selected").val();
	$year = $("#year option:selected").val();
	
	
	$status = true;
	$error = "";

//CHECK DATE
	if( $day == 0 || $month == 0 || $year == 0 )
	{
		$status = false;
		$error += "Please select date <br/>"; 
	}
	
	
	if($status == false)
	{
		$("#notification").addClass("error");
		$("#notification").html($error); 
	}
	
	//return false;
	return $status;
}