<?php 
include 'pinflickr.functions.php'; 
$urls = getFlickrData($SECRET, $API_KEY, "50453476@N08", "soccer");
$json = json_encode($urls);
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
	</div>
	<!--// get jquery //-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script src="js/jquery.freetile.js"></script>
	<script>
	$(document).ready(function(){
		// get the json from our php file
		<?php echo "var urlsArray = " . $json . ";\n";?>

		// add each picture to the existing #container
		$.each(urlsArray, function(index, value, n){
			$('#container').append('<div class="item"><img class="pin" src="' + value + '"></div>');
		});

		// call freetile on the container
		$('#container').freetile({
			animate: true,
			elementDelay: 30
		});
	});
	</script>
</body>
</html>