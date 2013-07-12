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
	<!--// get jquery //-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script src="js/jquery.freetile.js"></script>
	<script>
	$(document).ready(function(){
		$('#container').freetile({
			animate: true,
			elementDelay: 30
		});
	});
	</script>

</head>
<body>
	<?php
	echo '<div id="container">';
		
		foreach($urls as $url){
			echo '<div class="item"><img class="pin" src="' . $url . '"/></div>';
		}
		

	echo '</div>';
	?>

</body>
</html>