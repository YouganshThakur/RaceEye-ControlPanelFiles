<?php

$MonitorName=$_POST['monitorName'];
$HostName=$_POST['hostName'];
$PortNumber=$_POST['portNumber'];
$Path=$_POST['path'];
$Width=$_POST['width'];
$Height=$_POST['height'];

$myfile = fopen("media_server_address.txt", "r") or print("Unable to open file!");
	$mediaServerIp=fread($myfile,filesize("media_server_address.txt"));
	fclose($myfile);

 $data='"&Monitor[Name]='.$MonitorName.'&Monitor[Type]=Remote&Monitor[MaxFPS]=50&Monitor[Function]=Monitor&Monitor[Protocol]=http&Monitor[Method]=simple&Monitor[Host]='.$HostName.'&Monitor[Port]='.$PortNumber.'&Monitor[Path]='.$Path.'&Monitor[Width]='.$Width.'&Monitor[Height]='.$Height.'&Monitor[Colours]=4"';

 $ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, "$mediaServerIp/api/monitors.json" );
		
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_POSTFIELDS, $data );
$result = curl_exec($ch );
curl_close( $ch );

header("Location:list.php");


?>

