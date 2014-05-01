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
	return 'INTERNAL ONLY: ' . $title;

}

function rcMetaDisplayInternalWarning($content)
{
	$content = '<style type="text/css">.post-header{background:orange;}</style><div class="alert alert-danger">This article is validated for internal use only; not to be shared directly with customers.</div>' . $content;

	return $content;

}

function rcMetaDoNotDisplayInternalTitle($title)
{
	return 'INTERNAL ONLY';
}

// this is the function used to display the error message to non-logged in users
function rcMetaDisplayNone($content)
{
	global $rc_options;
	global $post;
	
	$rcUserLevel = get_post_meta($post->ID, 'rcUserLevel', true);

	if (!current_user_can('read') && ($rcUserLevel == 'Administrator' || $rcUserLevel == 'Editor' || $rcUserLevel == 'Author' || $rcUserLevel == 'Contributor' || $rcUserLevel == 'Subscriber'))
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
