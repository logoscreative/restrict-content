<?php

/*******************************************
* Restrict Content Feed Functions
*******************************************/

function rcCheckFeed()
{
	add_filter('the_content', 'rcIsFeed');
}
add_action('rss_head', 'rcCheckFeed');

function rcIsFeed($content)
{
	$custom_meta = get_post_custom($post->ID);
	$rcUserLevel = $custom_meta['rcUserLevel'][0];
	$rcFeedHide = $custom_meta['rcFeedHide'][0];
	if (is_feed && $rcFeedHide == 'on')
	{
		echo 'This content is restricted to ' . $rcUserLevel . 's';
	}
	else
	{
		return $content;
	}
	
}