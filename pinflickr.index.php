<?php 
include 'pinflickr.functions.php'; 
$urls = getFlickrData($SECRET, $API_KEY, "50453476@N08", "soccer");
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>pinflickr</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<div id="container">
		<?php
		foreach($urls as $url){
			echo '<div><img src="' . $url . '"/></div>';
		}
		?>
	</div>
</body>
</html>