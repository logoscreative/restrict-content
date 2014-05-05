<?php

/*******************************************
* Restrict Content User Checks
*******************************************/

function rcCheckUser()
{

	$ipperms = pardot_validate_ip();

	if ( $ipperms === true || is_user_logged_in() )
	{
		add_filter('the_content', 'rcMetaDisplayInternalWarning', 9);
		add_filter('the_content', 'rcMetaDisplaySubscriber');
		add_filter('the_title', 'rcMetaDisplayInternalTitle');
	}
	else
	{
		add_filter('the_content', 'rcMetaDisplayNoWay');
		add_filter('the_title', 'rcMetaDoNotDisplayInternalTitle');
	}

}
add_action('loop_start', 'rcCheckUser');
