<?php
date_default_timezone_set('Asia/Kolkata');
#API access key from Google API's Console
    define( 'API_ACCESS_KEY', 'AAAAnUv_m2U:APA91bEIYpTRQoS5uJeM0gnWV1g6stUiOXT30v8hlUjmJUCK53G8P62CQDyQVUdTBnqODjeRkDeMBBP4P395RNLiqn7VGZwKi8MGs8dd8K9OpJ5rjvNzA4ygOwX1-U1Vsvff6wxRsBxF' );
	$To=$_GET["To"];
	$timestamp=(int)strtotime(date("h:i:sa"));
	$Heading=$_GET["Heading"];
	$Content=$_GET["Content"];
	$Clickable=$_GET["Clickable"];
	$Click_Type=$_GET["Click_Type"];
	$Click_Target=$_GET["Click_Target"];
	$sendBy=$_GET["sendBy"];
	$timestamp=(int)strtotime(date("h:ia"));
#prep the bundle
 $msg = array(
		'body' 	=> 'Hello There',
		'title'	=> 'ADMIN',
		'icon'	=> 'myicon',
		'sound' => 'mySound'/*Default sound*/
		);
          $data=array
           (
           	'Heading' => $Heading,
			'Content' => $Content,
           	'Date' => date("h:ia").' '.date("F",strtotime(date("Y-m-d"))).' '.date("d Y"),
           	'Clickable' => $Clickable,
           	'Click_Type' => $Click_Type,
           	'Click_Target' => $Click_Target,
			'Id' => $timestamp);
	$fields = array
			(
				'to'		=> '/topics/'.$To,
				//'notification'	=> $msg,
				'data'=>$data
			);
	
	
	$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);
#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

$con=mysqli_connect("localhost","user_college","astuteDB123@","AstuteDB");
if(mysqli_connect_errno($con))
{
	echo "A102";
}
else
{
$query="insert into notifications values('$sendBy','$Heading','$Content','$Click_Target','$To','$timestamp')";
$result=mysqli_query($con,$query);
echo "success";
$result = curl_exec($ch );
		curl_close( $ch );
#Echo Result Of FireBase Server
echo $result;
}
