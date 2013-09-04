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
?>


<?
/***************************************************************************************/
/* SETTINGS AND ADMINISTRATION PAGE
****************************************************************************************/
class PinflickrSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Pinflickr Admin', 
            'Pinflickr Settings', 
            'manage_options', 
            'pinflickr-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'pinflickr_options_name' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Pinflickr Settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'pinflickr_options_group' );   
                do_settings_sections( 'pinflickr-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'pinflickr_options_group', 
            'pinflickr_options_name', 
            array( $this, 'sanitize' ) 
        );

        add_settings_section(
            'setting_section_id', 
            'My Custom Settings', 
            array( $this, 'print_section_info' ), // Callback
            'pinflickr-admin' 
        );  

        add_settings_field(
            'api_key', 
            'API Key', 
            array( $this, 'api_key_callback' ), // Callback
            'pinflickr-admin', 
            'setting_section_id'          
        );      

        add_settings_field(
            'app_secret', 
            'App Secret', 
            array( $this, 'app_secret_callback' ), 
            'pinflickr-admin', 
            'setting_section_id'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {

        if( !empty( $input['app_secret'] ) )
            $input['app_secret'] = sanitize_text_field( $input['app_secret'] );

        return $input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function api_key_callback()
    {
        printf(
            '<input type="text" id="api_key" name="pinflickr_options_name[api_key]" value="%s" />',
            esc_attr( $this->options['api_key'])
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function app_secret_callback()
    {
        printf(
            '<input type="text" id="app_secret" name="pinflickr_options_name[app_secret]" value="%s" />',
            esc_attr( $this->options['app_secret'])
        );
    }
}

if( is_admin() ) {
    $my_settings_page = new PinflickrSettingsPage();
}

/***************************************************************************************/
/* DEPENDENCIES
****************************************************************************************/
// load the required scripts
function pinflickr_includes() {
  // register the scripts first, then we will enqueue them
  wp_register_script('jquery-1.10.2', plugin_dir_url(__FILE__) . 'js/jquery-1.10.2.min.js');
  wp_register_script('freetile_js', plugin_dir_url(__FILE__) . 'js/jquery.freetile.js');
  wp_register_script('fancybox_js', plugin_dir_url(__FILE__) . 'js/fancybox/source/jquery.fancybox.js');
  wp_register_script('fancybox_pack', plugin_dir_url(__FILE__) . 'js/fancybox/source/jquery.fancybox.pack.js');
  wp_register_script('pinflickr_js', plugin_dir_url(__FILE__) . 'js/pinflickr.js');
  wp_enqueue_script('jquery-1.10.2');
  wp_enqueue_script('freetile_js');
  wp_enqueue_script('fancybox_js');
  wp_enqueue_script('fancybox_pack');
  wp_enqueue_script('pinflickr_js');

  wp_register_style('pinflickr_styles', plugin_dir_url(__FILE__) . 'css/styles.css');
  wp_enqueue_style('pinflickr_styles');


  wp_register_style('fancybox_styles', plugin_dir_url(__FILE__) . 'js/fancybox/source/jquery.fancybox.css');
  wp_enqueue_style('fancybox_styles');
}
// add the scripts to an action
add_action('wp_enqueue_scripts', 'pinflickr_includes');
/***************************************************************************************/
/* SHORTCODES
****************************************************************************************/
/**
 * Create shortcodes for adding the gallery to a page
 *
 * @param array $attrs contains array of flickr username and tags to be used
 */
function pinflickr_shortcode( $attrs ) {

  // get the options from our options page
  $opts    = get_option('pinflickr_options_name');
  $API_KEY = $opts['api_key']; // change this when in prod
  $SECRET  = $opts['app_secret']; // change this in prod too
  $user    = $attrs['user_id'];
  $tags    = $attrs['tags'];

  // store our output for error checking
  $output  = getFlickrData($SECRET, $API_KEY, $user, $tags);
  if($output) {
    echo $output;
  } else {
    echo 'No Data Available';
  }
}

add_shortcode('pinflickr', 'pinflickr_shortcode');
/***************************************************************************************/
/* FUNCTIONS
****************************************************************************************/
function pinflickr_init() {
  // do stuff
}
add_action('init', 'pinflickr_init');
// if we need to do anything special on the install, do it here
function pinflickr_install() {
  // do stuff
}
/** 
 * Handles the request and response to and from flickr
 *
 * @param string $SECRET contains string of app secret (from admin page)
 * @param string $API_KEY contains string of api key (from admin page)
 * @param string $user_id contains string of user id (from shortcode)
 * @param string $tags contains string of comma separated tags (from shortcode)
 */
function getFlickrData($SECRET, $API_KEY, $user_id, $tags) {
  // build the request url
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

/** 
 * Builds the list of urls and associated titles
 *
 * @param array $dat contains the urls and titles from json response in getFlickrData()
 */
function getFlickrUrls($dat){
  $urls = array();
  $nums = 0;
  if($dat){
    foreach($dat['photos']['photo'] as $pic){  
      $photo_url    = 'http://farm' . $pic['farm'] . '.staticflickr.com/' . $pic['server'] . 
              '/' . $pic['id'] . '_' . $pic['secret'] . ".jpg";
      // create a temporary array with the title and the photo's url
      $urls[$nums]['title'] = $pic['title'];    
      $urls[$nums]['url'] = $photo_url;
      $nums++;
    }
  } else {
    echo "Flickr Was Unreachable.";
  }
  return buildPinflickrHtml($urls);
}

/** 
 * Builds the html to be displayed and returns it as a string
 */
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
/** 
 * Debug
 */
// define('WP_DEBUG', true);

?>