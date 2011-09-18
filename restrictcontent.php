<?php
/*
Plugin Name: Restrict Content
Plugin URL: http://pippinsplugins.com/restricted-content-plugin-free/
Description: Restrict Content to registered users only. This is a simple plugin that will allow you to easily restrict complete posts / pages to logged in users only. Levels of restriction may also be set. For example, you can restrict content to only Administrators, Editors, Authors, and Subscribers.

This plugin will also allow you to restrict sections of content within a post or page.

Version: 2.0
Author: Pippin Williamson
Author URI: http://pippinsplugins.com
Contributors: Pippin Williamson, Dave Kuhar
Tags: Restrict content, member only, registered, logged in, restricted access, restrict access, limiit access, read-only, read only
*/


/*******************************************
* global variables
*******************************************/

// load the plugin options
$rc_options = get_option( 'rc_settings' );

/*******************************************
* file includes
*******************************************/

include('includes/settings.php');
include('includes/shortcodes.php');
include('includes/metabox.php');
include('includes/display-functions.php');
include('includes/feed-functions.php');
include('includes/user-checks.php');

