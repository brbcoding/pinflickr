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
	<link href='http://fonts.googleapis.com/css?family=Fauna+One' rel='stylesheet' type='text/css'>
	<style>
	* { font-family: 'Fauna One', serif; }
	</style>
</head>
<body>
	<div id="hover-effects">
	<input type="radio" name="selection" value="transform"> Rotate slightly on hover
	<input type="radio" name="selection" value="subtle-highlight"> Subtle added shadow on hover
	<input type="radio" name="selection" value="both"> Rotate + Shadow
	</div>
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


		$('.pin').hover(function(){
			// get the value of the checkbox -- just for demo
			var sel = $('input:radio[name=selection]:checked').val();
			if(sel == 'transform') {
				transform();
			} else if (sel == 'subtle-highlight'){
				subtleHighlight();
			} else if (sel == 'both') {
				transform();
				subtleHighlight();
			} else {
				return;
			}
		}); 
		// functions for animations
		// turn the img a couple of degrees
		var transform = function(){
			$('.pin').toggleClass('rotate');
		};

		// put a simple subtle shadow around the image
		var subtleHighlight = function(){
			$('.pin').toggleClass('subtle');
		};

	});
	</script>
</body>
</html>