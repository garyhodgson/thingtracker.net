<?php
	$trackerURL = isset($_GET['trackerURL'])?$_GET['trackerURL']:false;
	if (!$trackerURL) {
	   header("HTTP/1.0 400 Bad Request");
	   exit();
	}

	if (!filter_var($trackerURL, FILTER_VALIDATE_URL)) {
		header("HTTP/1.0 400 Bad Request");
		exit();
	}

	if ( strtolower($_SERVER['REQUEST_METHOD']) != 'get' ) {
	   header("HTTP/1.0 400 Bad Request");
	   exit();
	} 


	$ch = curl_init($trackerURL);
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, false );
	curl_setopt( $ch, CURLOPT_HEADER, true );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

	list( $header, $output ) = preg_split( '/([\r\n][\r\n])\\1/', curl_exec( $ch ), 2 );
	curl_close($ch);


	$ary_headers = explode("\n", $header);
	foreach($ary_headers as $hdr) {
		if ((strpos($hdr, "Content-Type", 0) === 0) || strpos($hdr, "HTTP", 0) === 0){
			error_log($hdr);
		}
	}

	echo $output;
?>