<?php
// pinboard shortcode
// include 'pinflickr.functions.php';
function pinflickr() {
	// need to get js files
	// return div container to later
	// be appended to
	
	return '<div id="container"></div>';
}
add_shortcode( 'pinboard', 'pinflickr' );
// dont need the closing brace