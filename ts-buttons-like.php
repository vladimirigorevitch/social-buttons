<?php

/*
Plugin Name: TS Buttons Like
Description: my first test plugin
Version: 1.0
Author: V.Rybnikov
Author URI: http://
Plugin URI: http://
License:
*/

define ('TS_BUTTONS_LIKE_DIR', plugin_dir_path(__FILE__));
define ('TS_BUTTONS_LIKE_URL', plugin_dir_url(__FILE__));

function ts_buttons_like_load () 
{
	require_once (TS_BUTTONS_LIKE_DIR.'includes/likes-block.php');	// --> html with block of buttons (look at the source)  
    if (is_admin())
        require_once (TS_BUTTONS_LIKE_DIR.'includes/admin.php');
    require_once (TS_BUTTONS_LIKE_DIR.'includes/core.php');
    require_once (TS_BUTTONS_LIKE_DIR.'includes/shortcode.php');
}

ts_buttons_like_load();

register_activation_hook(__FILE__, 'ts_buttons_like_activation');
register_deactivation_hook(__FILE__, 'ts_buttons_like_deactivation');

function ts_buttons_like_activation () 
{
    register_uninstall_hook(__FILE__, 'ts_buttons_like_uninstal');
}

function ts_buttons_like_deactivation () {}

function ts_buttons_like_uninstal () 
{
	delete_option ('ts_buttons_like_opt');
}

?>