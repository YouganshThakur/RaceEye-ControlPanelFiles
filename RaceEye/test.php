<?php

 $data='"&Monitor[Name]=Test&Monitor[Type]=Remote&Monitor[MaxFPS]=50&Monitor[Function]=Monitor&Monitor[Protocol]=http&Monitor[Method]=simple&Monitor[Host]=192.168.11.20&Monitor[Port]=8080&Monitor[Path]=/mjpg/videoccccc.mjpg&Monitor[Width]=704&Monitor[Height]=480&Monitor[Colours]=4"';

	$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'http://localhost:5555/zm/api/monitors.json' );
		
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_POSTFIELDS, $data );
$result = curl_exec($ch );
curl_close( $ch );
echo $result;



?>