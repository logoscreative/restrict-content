<?php
/*
Plugin Name: Restrict Content
Plugin URI: http://pippinspages.com/freebies/restricted-content-plugin-free/
Description: Restrict Content to registered users only. This is a simple plugin that will allow you to easily restrict complete posts / pages to logged in users only. Levels of restriction may also be set. For example, you can restrict content to only Administrators, Editors, Authors, and Subscribers.

This plugin will also allow you to restrict sections of content within a post or page.

Version: 1.2
Author: Pippin Williamson
Author URL: http://pippinspages.com
Tags: Restrict content, member only, registered, logged in
*/



function restrict_shortcode( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'userlevel' => 'none',
      ), $atts ) );
      if ($userlevel == 'admin' && current_user_can('switch_themes'))
      {
      	return do_shortcode($content);
      }
      if ($userlevel == 'editor' && current_user_can('moderate_comments'))
      {
      	return do_shortcode($content);
      }
      if ($userlevel == 'author' && current_user_can('upload_files'))
      {
      	return do_shortcode($content);
      }
      if ($userlevel == 'subscriber' && current_user_can('read'))
      {
	      	return do_shortcode($content);
	  }
	  if ($userlevel == 'none' && is_user_logged_in)
      {
	      	return do_shortcode($content);
	  }
      else return '<span style="color: red;">Some content is only viewable by ' . $userlevel . 's</span>';
}
add_shortcode('restrict', 'restrict_shortcode');



//custom meta boxes
$prefix = 'rc';

$meta_box = array(
    'id' => 'rcMetaBox',
    'title' => 'Restrict this content',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'User Level',
            'id' => $prefix . 'UserLevel',
            'type' => 'select',
            'desc' => 'Choose the user level that can see this page / post',
            'options' => array('None', 'Administrator', 'Editor', 'Author', 'Subscriber'),
            'std' => 'None'
        ),
        array(
        	'name' => 'Hide from Feed?',
        	'id' => $prefix . 'FeedHide',
        	'type' => 'checkbox',
        	'desc' => 'HIde the excerpt of this post / page from the Feed?',
        	'std' => ''
     	)
    )
);

// Add meta box


function rcAddMetaBoxes() {
    global $meta_box;
	foreach (array('post','page') as $type)     
    add_meta_box($meta_box['id'], $meta_box['title'], 'rcShowMetaBox', $type, $meta_box['context'], $meta_box['priority']);
}
add_action('admin_menu', 'rcAddMetaBoxes');


// Callback function to show fields in meta box
function rcShowMetaBox() {
    global $meta_box, $post;
    
    // Use nonce for verification
    echo '<input type="hidden" name="rcMetaNonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    
    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        
        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
        }
        echo     '<td>', $field['desc'], '</td><td>',
            '</tr>';
    }
    
    echo '</table>';
}

// Save data from meta box
function rcSaveData($post_id) {
    global $meta_box;
    
    // verify nonce
    if (!wp_verify_nonce($_POST['rcMetaNonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    
    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}
add_action('save_post', 'rcSaveData');


function rcMetaDisplayEditor($error = ' ')
{
	$custom_meta = get_post_custom($post->ID);
	$rcUserLevel = $custom_meta['rcUserLevel'][0];

	if ($rcUserLevel == 'Administrator')
	{
		echo 'This content is restricted to ' . $rcUserLevel;
	}
	else
	{
		$error .= "";
		return $error;
	}
}
function rcMetaDisplayAuthor($error = ' ')
{

	$custom_meta = get_post_custom($post->ID);
	$rcUserLevel = $custom_meta['rcUserLevel'][0];

	if ($rcUserLevel == 'Administrator' || $rcUserLevel == 'Editor')
	{
		echo 'This content is restricted to ' . $rcUserLevel;
	}
	else
	{
		$error .= "";
		return $error;
	}
}
function rcMetaDisplaySubscriber($error = ' ')
{
	$custom_meta = get_post_custom($post->ID);
	$rcUserLevel = $custom_meta['rcUserLevel'][0];

	if ($rcUserLevel == 'Administrator' || $rcUserLevel == 'Editor' || $rcUserLevel == 'Author')
	{
		echo 'This content is restricted to ' . $rcUserLevel;
	}
	else
	{
		$error .= "";
		return $error;
	}
}
function rcMetaDisplayNone($error = ' ')
{
	$custom_meta = get_post_custom($post->ID);
	$rcUserLevel = $custom_meta['rcUserLevel'][0];

	if (!current_user_can('read') && $rcUserLevel == 'Administrator' || $rcUserLevel == 'Editor' || $rcUserLevel == 'Author' || $rcUserLevel == 'Subscriber')
	{
		echo 'This content is restricted to ' . $rcUserLevel;
	}
	else
	{
		$error .= "";
		return $error;
	}
}
function checkUser()
{

	if (current_user_can('read'))
	{		
		if (current_user_can('upload_files'))
		{
			if (current_user_can('moderate_comments'))
			{
				if (current_user_can('switch_themes'))
				{
					//do nothing here for admin
				}
				else
				{
					add_filter('the_content', 'rcMetaDisplayEditor');
				}
			}
			else
			{
				add_filter('the_content', 'rcMetaDisplayAuthor');
			}
		}
		else
		{
			add_filter('the_content', 'rcMetaDisplaySubscriber');
		}
				
	}
	else
	{
		add_filter('the_content', 'rcMetaDisplayNone');
	}

}
add_action('loop_start', 'checkUser');

function rcCheckFeed()
{
	add_filter('the_content', 'rcIsFeed');
}
add_action('rss_head', 'rcCheckFeed');

function rcIsFeed($error = ' ')
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
		$error .= "";
		return $error;
	}
	
}


?>
