<?php


include 'db_connect.php';
extract($_POST);

$data = ' schedule_id = ' . $sid . ' ';
$data .= ', name = "' . $name . '" ';
$data .= ', qty ="' . $qty . '" ';
$data .= ', email_address ="' . $email_address . '" ';
if (!empty($bid)) {
	$data .= ', status ="' . $status . '" ';
	$update = $conn->query("UPDATE booked set " . $data . " where id =" . $bid);
	if ($update) {
		echo json_encode(array('status' => 1));
	}
	exit;
}
$i = 1;
$ref = '';
while ($i == 1) {
	$ref = date('Ymd') . mt_rand(1, 9999);
	$data .= ', ref_no = "' . $ref . '" ';
	$chk = $conn->query("SELECT * FROM booked where ref_no=" . $ref)->num_rows;
	if ($chk <= 0)
		$i = 0;
}

// echo "INSERT INTO booked set ".$data;
$insert = $conn->query("INSERT INTO booked set " . $data);
if ($insert) {
	$to = $email_address;
	$subject = "Bus Booking Reference Number";	

	$message = "";
	$message .= "Welcome <b>".$name."</b> on Bus Seat Booking Website.<br>";
	$message .= "Your Reference Number is here <b>".$ref."</b><br>";
	$message .= "Do not share this number with anyone else.<br><b>Thank you.</b>";
	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: <jacobhaddad1221@live.com>' . "\r\n";

	mail($to, $subject, $message, $headers);
	echo json_encode(array('status' => 1, 'ref' => $ref));
}
