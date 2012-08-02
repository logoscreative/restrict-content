<?php
/*
Plugin Name: Restrict Content
Plugin URL: http://pippinsplugins.com/restricted-content-plugin-free/
Description: Restrict Content to registered users only. This is a simple plugin that will allow you to easily restrict complete posts / pages to logged in users only.
Version: 2.0.3
Author: Pippin Williamson
Author URI: http://pippinsplugins.com
Contributors: mordauk
Tags: Restrict content, member only, registered, logged in, restricted access, restrict access, limiit access, read-only, read only
*/


/*******************************************
* global variables
*******************************************/

// load the plugin options
$rc_options = get_option( 'rc_settings' );

if(!defined('RC_PLUGIN_DIR'))
	define('RC_PLUGIN_DIR', dirname(__FILE__));

/*******************************************
* file includes
*******************************************/

include(RC_PLUGIN_DIR . '/includes/settings.php');
include(RC_PLUGIN_DIR . '/includes/shortcodes.php');
include(RC_PLUGIN_DIR . '/includes/metabox.php');
include(RC_PLUGIN_DIR . '/includes/display-functions.php');
include(RC_PLUGIN_DIR . '/includes/feed-functions.php');
include(RC_PLUGIN_DIR . '/includes/user-checks.php');

