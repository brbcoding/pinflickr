pinflickr
=========

This plugin uses the Flickr API to build a pinboard style gallery on an existing Wordpress site.

Examples:  
![Screenshot 1](http://i.imgur.com/DxAHfvp.jpg)
![Screenshot 2](http://i.imgur.com/vzB3ljs.jpg)

Installation
==  

- Move wp-pinflickr folder to the `plugins` directory of your Wordpress site.  
- Create a new API code and app secret on flickr [More Info](http://www.flickr.com/services/developer/api/)  
- Access *Pinflickr Settings* under the *Settings* menu inside the Wordpress Admin Menu.  
- Enter your API code and App Secret from Flickr. Save these changes. 
- Create a new page that will hold your gallery  
- The plugin works with a shortcode to display the gallery. The format is as follows:  

`[pinflickr user_id="66956608@N06" tags="tags,separated,by,commas"]`

The easiest way to find a user id is by using the site [idGettr](http://idgettr.com/).  

- Enter the shortcode with your `user_id` and desired `tags` and save this page.  
- That's it! You've created an awesome pinboard styled gallery! 

[Simple Working Demo](http://oh.lc/wordpress/pinflickr-gallery/)