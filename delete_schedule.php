<?php

include('db_connect.php');
extract($_POST);

$booked_user = $conn->query("Select * from booked where schedule_id =".$id);
if($booked_user->num_rows > 0)
{
    while($row = $booked_user->fetch_assoc())
    {
        $to =  $row['email_address'];
    	if($to !='')
    	{
    	    $subject = "Trip Cancelled";	
    
    	$message = "";
    	$message .= "Welcome <b>".$row['name']."</b>, on Bus Seat Booking Website.<br>";
    	$message .= "Your Reference Number was <b>".$row['ref_no']."</b><br>";
    	$message .= "We apologize that this trip has been cancelled.<br>Your Fare will be refund if you already Paid.<br>";
    	$message .= "<b>Sorry for inconvenicene</b><br>Have a Good Day :)";
    	// Always set content-type when sending HTML email
    	$headers = "MIME-Version: 1.0" . "\r\n";
    	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    	// More headers
    	$headers .= 'From: <jacobhaddad1221@live.com>' . "\r\n";
    
    	mail($to, $subject, $message, $headers);
    	}
    }
    $remove = $conn->query("UPDATE schedule_list set status = 0 where id =".$id);

if($remove){ echo 1; }
	
}
else
{
    echo "0";
}
