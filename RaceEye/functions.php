<?php
$name=$_GET["name"];
switch($name)
{
	case "saveIp":	createServerAddressFile();
					break;
    case "deleteCamera":deleteCamera();
    				break;
    case "changeState":changeState();
    				break;
}
function createServerAddressFile()
{
	$ip=$_GET['ip'];
	$myfile = fopen("media_server_address.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $ip);
	fclose($myfile);
}

function deleteCamera()
{
	$id=$_GET['id'];
	
	$myfile = fopen("media_server_address.txt", "r") or print("Unable to open file!");
	$mediaServerIp=fread($myfile,filesize("media_server_address.txt"));
	fclose($myfile);
	
	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, "$mediaServerIp/api/monitors/$id.json" );
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); 
	$result = curl_exec($ch );
	curl_close( $ch );
}
function changeState()
{
	$id=$_GET['id'];
	$Enabled=$_GET['enabled'];

	$myfile = fopen("media_server_address.txt", "r") or print("Unable to open file!");
	$mediaServerIp=fread($myfile,filesize("media_server_address.txt"));
	fclose($myfile);

 	$data="&Monitor[Function]=Monitor&Monitor[Enabled]=$Enabled";

 	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, "$mediaServerIp/api/monitors/$id.json" );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, $data );
	$result = curl_exec($ch );
	curl_close( $ch );
}
?>