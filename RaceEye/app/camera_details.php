<?php
$myfile = fopen("../media_server_address.txt", "r") or print("Unable to find media server address");
$media_server=fread($myfile,filesize("../media_server_address.txt"));
fclose($myfile);

$all_monitors=file_get_contents($media_server.'/api/monitors.json');
$data=json_decode($all_monitors,true);
$data=$data["monitors"];
$camera=array();
$camera["count"]=count($data);
$camera["details"]=array();
for($i=0;$i<count($data);$i++)
{
	$camera["details"][$i]["width"]=$data[$i]["Monitor"]["Width"];
	$camera["details"][$i]["address"]=$media_server.'/index.php?view=watch&mid='.$data[$i]["Monitor"]["Id"];
}
echo json_encode($camera);
?>