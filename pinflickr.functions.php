<?php

$API_KEY = "ffdc6e7cef69d201a7c79bc80477a0ec"; // change this when in prod
$SECRET	 = "a48a5c5114b7ec99"; // change this in prod too

function getFlickrData($SECRET, $API_KEY, $user_id, $tags) {
	$url = "http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=" . $API_KEY . "&user_id=" . $user_id;
	
	// tags should be passed as a comma separated list
	if($tags != ""){
		$url .= "&tags=" . $tags;
	}
	$url .= "&format=json";
	$res = file_get_contents($url);
	print_r($res);
}

getFlickrData($SECRET, $API_KEY, "50453476@N08", "soccer");

?>
