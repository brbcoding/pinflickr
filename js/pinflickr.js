$(document).ready(function(){
	// get the json from our php file
	<?php echo "var urlsArray = " . $json . ";\n";?>

	
	console.log(urlsArray);
	// add each picture to the existing #container
	$.each(urlsArray, function(index, value){
		$('#container').append('<div class="item"><a class="fancybox" href="' + 
						value['url'] +'"><img class="pin" src="' + 
						value['url'] + '" alt="' + 
						value['title']+'" title="' +
						value['title'] +'"></a><br /><span class="image-title">' +
						// this is not how we actually want to handle overflow
						value['title'].substring(0, 33) + '...</span></div>');
		

	});
	// call freetile immediately
	$('#container').freetile();
	// call freetile on window resize
	$(window).resize(function(){
		$('#container').freetile({
		animate: true,
		elementDelay: 5
		});
	})

	// call fancybox on .pin
	$('.fancybox').fancybox();

	// invoke special hover functions upon hovering the .pin class
	// $('.pin').hover(function(){
	// 	// get the value of the checkbox -- just for demo
	// 	var sel = $('input:radio[name=selection]:checked').val();
	// 	if(sel == 'transform') {
	// 		transform();
	// 	} else if (sel == 'subtle-highlight'){
	// 		subtleHighlight();
	// 	} else if (sel == 'grow') {
	// 		grow();
	// 	} else if (sel == 'both') {
	// 		transform();
	// 		subtleHighlight();
	// 	} else {
	// 		return;
	// 	}
	// }); 

	// functions for animations
	// transform - rotate the image a couple of degrees
	// turn the img a couple of degrees
	// var transform = function(){
	// 	$('.item').toggleClass('rotate');
	// };

	// // add subtle shadow to the image
	// var subtleHighlight = function(){
	// 	$('.item').toggleClass('subtle');
	// };

	// // scale a bit and return to normal size
	// var grow = function(){
	// 	$('.item').toggleClass('grow-shrink');
	// };

});