=== Restrict Content ===
Author URI: http://pippinsplugins.com
Author: Pippin Williamson
Contributors: mordauk
Donate link: http://pippinsplugins.com/support-the-site
Tags: Restrict content, member only, registered, logged in, restricted access, restrict access, limiit access, read-only, read only
Requires at least 2.8
Tested up to 3.4.2
Stable tag: 2.1

Restrict Content to registered users only. This is a simple plugin that will allow you to easily restrict complete posts / pages to logged in users only. Levels of restriction may also be set. For example, you can restrict content to only Administrators, Editors, Authors, and Subscribers.

== Description ==

Restrict Content to registered users only. This is a simple plugin that will allow you to easily restrict complete posts / pages to logged in users only. Levels of restriction may also be set. 
For example, you can restrict content to only Administrators, Editors, Authors, and Subscribers.

Content restriction works both with shortcodes and drop-down menu of access levels for complete posts / pages.

v2.0 is also now completely compatible with custom post types.

Want to offer premium content to paid subscribers? Restrict Content Pro offers everything you need:

* Unlimited subscription levels
* Comlete member management
* Discount codes
* Payment tracking
* PayPal integration
* Top notch tech support

Check out Restrict Content Pro: http://pippinsplugins.com/restrict-content-pro-premium-content-plugin/

== Installation ==

1. Upload restrict-content to wp-content/plugins
2. Click "Activate" in the WordPress plugins menu
3. Go to Settings > Restrict Content and customize the Message settings
4. Follow instructions below to restrict content

To restrict an entire post or page, simply select the user level you’d like to restrict the post or page to from the drop down menu added just below the post/page editor.

To restrict just a section of content within a post or page, you may use shortcodes like this:

[restrict userlevel="editor"] . . . your restricted content goes here . . . [/restrict]

Accepted userlevel values are:
 * admin
 * editor
 * author
 * subscriber
 * contributor

There is also a short code for showing content only to users that are not logged in.

[not_logged_in]This content is only shown to non-logged-in users.[/not_logged_in]

 == Screenshots ==
 
 Go to the demo page to see examples:
 
http://pippinsplugins.com/restricted-content-plugin-free/

== Changelog ==

= 2.1 =

* Improved settings page to match core WordPress UI
* Fixed problem with unescaped HTML in restricted messages options
* Added complete internationalization on default language files

= 2.0.4 =

* Added do_shortcode() to the not logged in short code

= 2.0.3 =

* Fixed a problem with the not logged in short code.

= 2.0.2 = 

* Added new [not_logged_in] short code.

= 2.0 =

* Added settings page with options to configure each of the messages displayed to users who do not have permission to view a page.
* Improved the performance of several functions.
* Better organization of the plugin files and improved infrastructure for soon-to-come new features.

== Upgrade Notice ==

= 2.1 =

* Improved settings page to match core WordPress UI
* Fixed problem with unescaped HTML in restricted messages options
* Added complete internationalization on default language files

= 2.0.4 =

* Added do_shortcode() to the not logged in short code

= 2.0.3 =

* Fixed a problem with the not logged in short code.

= 2.0.2 = 

* Added new [not_logged_in] short code.

= 2.0 =

Added message configuration, custom post type support, and improved plugin infrastructure.