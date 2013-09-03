<?php
/*
Plugin Name: Pinflickr
Plugin URI: https://github.com/brbcoding/pinflickr
Description: flickr api + pinterest-like layout
Version: 0.01Beta
Author: Cody G. Henshaw
Author URI: http://codyhenshaw.com
License: WTFPL
*/

// setup

function pinflickr_install() {
	// do some installation work
}

register_activation_hook(__FILE__, 'pinflickr_install');

// load the required scripts
function pinflickr_javascripts() {
	// register the scripts first, then we will enqueue them
	wp_register_script('jquery-1.10.2', plugin_dir_url(__FILE__) . 'js/jquery-1.10.2.min.js');
	wp_register_script('freetile_js', plugin_dir_url(__FILE__) . 'js/jquery.freetile.js');
	wp_register_script('fancybox', plugin_dir_url(__FILE__) . 'js/fancybox/source/jquery.fancybox.pack.js');
	wp_register_script('pinflickr_js', plugin_dir_url(__FILE__) . 'js/pinflickr.js');
	wp_enqueue_script('jquery-1.10.2');
	wp_enqueue_script('pinflickr_js');
	wp_enqueue_script('freetile_js');

	wp_register_style('pinflickr_styles', plugin_dir_url(__FILE__) . 'css/styles.css');
	wp_enqueue_style('pinflickr_styles');
}

add_action('wp_enqueue_scripts', 'pinflickr_javascripts');


// hooks
add_action('init', 'pinflickr_init');
/***************************************************************************************/
/* SHORTCODES
****************************************************************************************/
function pinflickr_shortcode() {
	$API_KEY = "ffdc6e7cef69d201a7c79bc80477a0ec"; // change this when in prod
	$SECRET	 = "a48a5c5114b7ec99"; // change this in prod too
  	echo getFlickrData($SECRET, $API_KEY, "50453476@N08", "football");
}

add_shortcode('pinflickr', 'pinflickr_shortcode');
/***************************************************************************************/
/* FUNCTIONS
****************************************************************************************/
function pinflickr_init() {
  // do stuff
  // get my secret and API key from the database
//	$API_KEY = "ffdc6e7cef69d201a7c79bc80477a0ec"; // change this when in prod
//	$SECRET	 = "a48a5c5114b7ec99"; // change this in prod too
  //	getFlickrData($SECRET, $API_KEY);
  	// print_r('init function called');
}

function getFlickrData($SECRET, $API_KEY, $user_id, $tags) {
	// built the request url
	$url = "http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=" . $API_KEY . "&user_id=" . $user_id;
	
	// tags should be passed as a comma separated list
	if($tags != ""){
		$url .= "&tags=" . $tags;
	}
	// format it as json
	$url .= "&format=json";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_URL, $url);
	$res = curl_exec($curl);
	curl_close($curl);
	// need to strip this invalid json callback crap
	$dat = str_replace( 'jsonFlickrApi(', '', $res );
	$dat = substr( $dat, 0, strlen( $dat ) - 1 ); //strip out last paren
	$dat = json_decode($dat, TRUE);
	// return the decoded json response
	return getFlickrUrls($dat);
}

// title is stored in $pic['title']
function getFlickrUrls($dat){
	$urls = array();
	$nums = 0;
	if($dat){
		foreach($dat['photos']['photo'] as $pic){  
			// build the url
			$photo_url	  = 'http://farm' . $pic['farm'] . '.staticflickr.com/' . $pic['server'] . 
							'/' . $pic['id'] . '_' . $pic['secret'] . ".jpg";
			// create a temporary array with the title and the photo's url
            // it should contain the title and the photo's url
			$urls[$nums]['title'] = $pic['title'];		
			$urls[$nums]['url'] = $photo_url;
			$nums++;
		}
	} else {
		echo "Flickr Was Unreachable.";
	}
	return buildPinflickrHtml($urls);
}


// build an html string to output to the page
// it should contain the title of the image as
// well as the url in image form
function buildPinflickrHtml($urls) {
	$html = "<div id='container'>";
	if($urls){
		foreach($urls as $url) {
			// t_html for temporary string builder
			// set to "" after each iteration
			$t_html = "";
			$t_html .= '<div class="item subtle rotate"><a class="fancybox" href="' . 
				$url['url']   .'"><img class="pin" src="' .
				$url['url']   . '" alt="' .
				$url['title'] .'" title="' .
				$url['title'] .'"></a><br /><span class="image-title">' .
				$url['title'] . '...</span></div>';
			$html .= $t_html;
		}

		// close the #container
		$html .= "</div>";
		return $html;		
	}

}
?>