<?php

/*******************************************
* Restrict Content Meta Box
*******************************************/

//custom meta boxes
$prefix = 'rc';

$rc_meta_box = array(
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
            'options' => array('None', 'Administrator', 'Editor', 'Author', 'Contributor', 'Subscriber'),
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
    global $rc_meta_box;
	$post_types = get_post_types(array('public' => true, 'show_ui' => true), 'objects');
	foreach ($post_types as $page)     
    add_meta_box($rc_meta_box['id'], $rc_meta_box['title'], 'rcShowMetaBox', $page->name, $rc_meta_box['context'], $rc_meta_box['priority']);
}
add_action('admin_menu', 'rcAddMetaBoxes');


// Callback function to show fields in meta box
function rcShowMetaBox() {
    global $rc_meta_box, $post;
    
    // Use nonce for verification
    echo '<input type="hidden" name="rcMetaNonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    
    echo '<table class="form-table">';

	echo '<tr><td colspan="3">Use these options to restrict this entire entry, or the [restrict ...] ... [/restrict] short code to restrict partial content.</td></tr>';
	
    foreach ($rc_meta_box['fields'] as $field) {
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
    global $rc_meta_box;
    
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
    
    foreach ($rc_meta_box['fields'] as $field) {
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