$(document).ready(function(){
	// call freetile immediately
	$('#container').freetile();
	// call freetile on window resize
	$(window).resize(function(){
		$('#container').freetile({
		animate: true,
		elementDelay: 5
		});
	});

	// call fancybox on .pin
	$('.fancybox').fancybox();


});