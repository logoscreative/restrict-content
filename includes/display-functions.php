<?php

/*******************************************
* Restrict Content Display Functions
*******************************************/

function rcMetaDisplayEditor($content)
{
	global $rc_options;
	global $post;

	$rcUserLevel = get_post_meta($post->ID, 'rcUserLevel', true);

	if ($rcUserLevel == 'Administrator')
	{
		return do_shortcode( $rc_options['editor_message'] );
	}
	else
	{
		return $content;
	}
}
function rcMetaDisplayAuthor($content)
{
	global $rc_options;
	global $post;
	
	$rcUserLevel = get_post_meta($post->ID, 'rcUserLevel', true);

	if ($rcUserLevel == 'Administrator' || $rcUserLevel == 'Editor')
	{
		return do_shortcode( $rc_options['author_message'] );
	}
	else
	{
		// return the content unfilitered
		return $content;
	}
}
function rcMetaDisplayContributor($content)
{
	global $rc_options;
	global $post;
	
	$rcUserLevel = get_post_meta($post->ID, 'rcUserLevel', true);

	if ($rcUserLevel == 'Administrator' || $rcUserLevel == 'Editor' || $rcUserLevel == 'Author')
	{
		return do_shortcode( $rc_options['contributor_message'] );
	}
	else
	{
		// return the content unfilitered
		return $content;
	}
}
function rcMetaDisplaySubscriber($content)
{
	global $rc_options;
	global $post;
	
	$rcUserLevel = get_post_meta($post->ID, 'rcUserLevel', true);

	if ($rcUserLevel == 'Administrator' || $rcUserLevel == 'Editor' || $rcUserLevel == 'Author' || $rcUserLevel == 'Contributor')
	{
		return do_shortcode( $rc_options['subscriber_message'] );
	}
	else
	{
		// return the content unfilitered
		return $content;
	}
}

function rcMetaDisplayInternalTitle($title)
{
	global $rc_options;
	global $post;

	$rcUserLevel = get_post_meta($post->ID, 'rcUserLevel', true);

	$ipperms = pardot_validate_ip();

	if ($title == $post->post_title && in_the_loop() && ( !current_user_can('read') && !is_user_logged_in() && $ipperms === false ) && $rcUserLevel == 'Internal Only')
	{
		return 'INTERNAL ONLY';
	}
	elseif ($title == $post->post_title && in_the_loop() && $rcUserLevel == 'Internal Only')
	{
		// return the content unfilitered
		return 'INTERNAL ONLY: ' . $title;
	}
	else
	{
		return $title;
	}
}

function rcMetaDisplayInternalWarning($content)
{

	global $post;

	$rcUserLevel = get_post_meta($post->ID, 'rcUserLevel', true);

	if ( $rcUserLevel == 'Internal Only' && is_single() )
	{
		$content = '<style type="text/css">.post-header{background:orange;}</style><div class="alert alert-danger">This article is validated for internal use only; not to be shared directly with customers.</div>' . $content;

	}

	return $content;

}

function rcMetaDoNotDisplayInternalTitle($title)
{

	global $rc_options;
	global $post;

	$rcUserLevel = get_post_meta($post->ID, 'rcUserLevel', true);

	if ($title == $post->post_title && in_the_loop() && !current_user_can('read') && $rcUserLevel == 'Internal Only')
	{
		return 'INTERNAL ONLY';
	}
	elseif ($title == $post->post_title && in_the_loop() && $rcUserLevel == 'Internal Only')
	{
		// return the content unfilitered
		return 'INTERNAL ONLY: ' . $title;
	}
	else
	{
		return $title;
	}

}

// this is the function used to display the error message to non-logged in users
function rcMetaDisplayNoWay($content)
{
	global $rc_options;
	global $post;

	$rcUserLevel = get_post_meta($post->ID, 'rcUserLevel', true);

	if (!current_user_can('read') && $rcUserLevel == 'Internal Only')
	{
		$content = "This article covers such an advanced concept that it has been marked for internal Pardot use only. If you believe you should have access to this article (or wish to learn more about this concept that isn't covered in other help articles), please file a case with our Support team using the 'Contact Support' button to the right.";
		return $content;
	}
	else
	{
		// return the content unfilitered
		return $content;
	}
}

// this is the function used to display the error message to non-logged in users
function rcMetaDisplayNone($content)
{
	global $rc_options;
	global $post;
	
	$rcUserLevel = get_post_meta($post->ID, 'rcUserLevel', true);

	if (!current_user_can('read') && $rcUserLevel == 'Internal Only')
	{
		$userLevelMessage = strtolower($rcUserLevel);
		return do_shortcode( $rc_options[$userLevelMessage . '_message'] );
	} 
	else
	{
		// return the content unfilitered
		return $content;
	}
}

function rcMetaDisplayTotallyHide($query) {

	if ( is_single() || is_page() || is_admin() || is_front_page() ) {
		return;
	}

	$ipperms = pardot_validate_ip();

	if ( $ipperms === false && !is_user_logged_in() )
	{

		$query->set('meta_query', array(
			'relation' => 'OR',
			array(
				'key'     => 'rcUserLevel',
				'value'   => '',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'rcUserLevel',
				'value'   => 'None',
				'compare' => 'LIKE',
			),
		) );

	}

	return $query;

}

add_action('pre_get_posts', 'rcMetaDisplayTotallyHide');
