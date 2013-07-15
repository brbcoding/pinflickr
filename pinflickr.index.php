<?php 
include 'pinflickr.functions.php'; 
$urls = getFlickrData($SECRET, $API_KEY, "50453476@N08", "soccer");
$json = json_encode($urls);
// echo '<pre>';
// print_r($json);
// echo '</pre>';
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>pinflickr</title>
	<link rel="stylesheet" href="css/styles.css" type="text/css">
	<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Fauna+One' type='text/css'>
	<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css" type="text/css" media="screen" />
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
</div>
	<!--// get jquery //-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script src="js/jquery.freetile.js"></script>
	<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js"></script>
	<script>
	$(document).ready(function(){
		// get the json from our php file
		<?php echo "var urlsArray = " . $json . ";\n";?>
		
		console.log(urlsArray);
		// add each picture to the existing #container
		$.each(urlsArray, function(index, value){
			$('#container').append('<div class="item"><a class="fancybox" href="' + 
							value['url'] +'"><img class="pin" src="' + 
							value['url'] + '" alt="' + 
							value['title']+'"></a><br /><span class="image-title">' +
							value['title'] + '</span></div>');
		
		});

		// call freetile on the container
		$('#container').freetile({
			animate: true,
			elementDelay: 30
		});
		
		// call fancybox on .pin
		$('.fancybox').fancybox();


		// invoke special hover functions upon hovering the .pin class
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
		// transform - rotate the image a couple of degrees
		// turn the img a couple of degrees
		var transform = function(){
			$('.item').toggleClass('rotate');
		};

		// add subtle shadow to the image
		// put a simple subtle shadow around the image
		var subtleHighlight = function(){
			$('.item').toggleClass('subtle');
		};



	});
	</script>
</body>
</html>