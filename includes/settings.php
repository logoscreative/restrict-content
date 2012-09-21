<?php

/*******************************************
* Restrict Content Settings Page
*******************************************/


function rc_settings_page()
{
	global $rc_options;
		
	?>
	<div class="wrap">
		<div id="upb-wrap" class="upb-help">
			<h2><?php _e('Restrict Content Settings', 'restrict-content'); ?></h2>
			<?php
			if ( ! isset( $_REQUEST['updated'] ) )
				$_REQUEST['updated'] = false;
			?>
			<?php if ( false !== $_REQUEST['updated'] ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Options saved', 'restrict-content'); ?> ); ?></strong></p></div>
			<?php endif; ?>
			<form method="post" action="options.php">

				<?php settings_fields( 'rc_settings_group' ); ?>
								
				<table class="form-table">
					<tr valign="top">
						<th colspan="2"><strong><?php _e('Short Code Messages', 'restrict-content'); ?></strong></th>
					</tr>
					<tr valign="top">	
						<th><?php _e('Restricted Message', 'restrict-content'); ?></th>
						<td>
							<input id="rc_settings[shortcode_message]" class="large-text" name="rc_settings[shortcode_message]" type="text" value="<?php echo isset( $rc_options['shortcode_message'] ) ? esc_html( $rc_options['shortcode_message'] ) : ''; ?>" /><br/>
							<label class="description" for="rc_settings[shortcode_message]"><?php _e( 'When using the [restrict ... ] .... [/restrict] Short Code, this is the message displayed when a user does not have the appropriate permissions.', 'restrict-content'); ?></label><br/>
							<small style="color: #666;"><?php _e('The <strong>{userlevel}</strong> tag will be automatically replaced with the permission level needed.', 'restrict-content'); ?></small>
						</td>
					</tr>
					<tr>
						<th colspan="2"><strong><?php _e('User Level Restriction Messages', 'restrict-content'); ?></strong></th>
					</tr>
					<tr valign="top">
						<th><?php _e('Adminstrators', 'restrict-content'); ?></th>
						<td>
							<input id="rc_settings[administrator_message]" class="large-text" name="rc_settings[administrator_message]" type="text" value="<?php echo isset( $rc_options['administrator_message'] ) ? esc_html( $rc_options['administrator_message'] ) : '';?>" /><br/>
							<label class="description" for="rc_settings[administrator_message]"><?php _e( 'Message displayed when a user does not have permission to view Adminstrator restricted content', 'restrict-content' ); ?></label><br/>
						</td>
					</tr>
					<tr valign="top">
						<th><?php _e('Editors', 'restrict-content'); ?></th>
						<td>
							<input id="rc_settings[editor_message]" class="large-text" name="rc_settings[editor_message]" type="text" value="<?php echo isset( $rc_options['editor_message'] ) ? esc_html( $rc_options['editor_message'] ) : '';?>" /><br/>
							<label class="description" for="rc_settings[editor_message]"><?php _e( 'Message displayed when a user does not have permission to view Editor restricted content', 'restrict-content' ); ?></label><br/>
						</td>
					</tr>
					<tr valign="top">
						<th><?php _e('Authors', 'restrict-content'); ?></th>
						<td>
							<input id="rc_settings[author_message]" class="large-text" name="rc_settings[author_message]" type="text" value="<?php echo isset( $rc_options['author_message'] ) ? esc_html( $rc_options['author_message'] ) : '';?>" /><br/>
							<label class="description" for="rc_settings[author_message]"><?php _e( 'Message displayed when a user does not have permission to view Author restricted content', 'restrict-content' ); ?></label><br/>
						</td>
					</tr>
					<tr valign="top">
						<th><?php _e('Contributors', 'restrict-content'); ?></th>
						<td>
							<input id="rc_settings[contributor_message]" class="large-text" name="rc_settings[contributor_message]" type="text" value="<?php echo isset( $rc_options['contributor_message'] ) ? esc_html( $rc_options['contributor_message'] ) : '';?>" /><br/>
							<label class="description" for="rc_settings[contributor_message]"><?php _e( 'Message displayed when a user does not have permission to view Contributor restricted content', 'restrict-content' ); ?></label><br/>
						</td>
					</tr>
					<tr valign="top">
						<th><?php _e('Subscribers', 'restrict-content'); ?></th>
						<td>
							<input id="rc_settings[subscriber_message]" class="large-text" name="rc_settings[subscriber_message]" type="text" value="<?php echo isset( $rc_options['subscriber_message'] ) ? esc_html( $rc_options['subscriber_message'] ) : '';?>" /><br/>
							<label class="description" for="rc_settings[subscriber_message]"><?php _e( 'Message displayed when a user does not have permission to view Subscriber restricted content', 'restrict-content' ); ?></label><br/>
						</td>
					</tr>
				</table>
				
				<!-- save the options -->
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'restrict-content' ); ?>" />
				</p>
								
				
			</form>
		</div><!--end sf-wrap-->
	</div><!--end wrap-->
		
	<?php
}

// register the plugin settings
function rc_register_settings() {

	// create whitelist of options
	register_setting( 'rc_settings_group', 'rc_settings' );
}
//call register settings function
add_action( 'admin_init', 'rc_register_settings' );


function rc_settings_menu() {

	// add settings page
	add_submenu_page('options-general.php', __('Restrict Content Settings', 'restrict-content'), __('Restrict Content', 'restrict-content'), 'manage_options', 'restrict-content-settings', 'rc_settings_page');
}
add_action('admin_menu', 'rc_settings_menu');


function rc_contextual_help($contextual_help, $screen_id, $screen) {
 
	ob_start(); ?>
 
	<h3>HTML Class Names</h3>
	<p>The selectors below can be used in your CSS to customize the look of your bookmark links, the add / remove bookmark links, and more.</p>
	<p><strong>User Bookmark List Selectors</strong></p>
	<ul>
		<li><em>ul.upb-bookmarks-list</em> - this is the unordered list wrapper that contains a user's bookmark links</li>
		<li><em>li.rc_bookmark</em> - this wraps each bookmark link</li>
		<li><em>a.rc_bookmark_link</em> - this is the bookmark's anchor link</li>
		<li><em>a.rc_del_bookmark</em> - this is the delete link next to each bookmark in the user's list</li>
	</ul>
	
	<p><strong>Add / Remove Bookmark Controls</strong></p>
	<ul>
		<li><em>div.rc_add_remove_links</em> - this is the DIV tag that wraps the add / remove links, if enabled</li>
		<li><em>a.rc_bookmark_control</em> - this is the generic class given to both add and remove bookmark links</li>
		<li><em>a.rc_del_bookmark</em> - this is the remove bookmark link class</li>
		<li><em>a.rc_add_bookmark</em> - this is the add bookmark link class</li>
	</ul>
	
	<p><strong>Most Popular Bookmarks List</strong></p>
	<ul>
		<li><em>ul.rc_most_popular_bookmarks</em> - this is the UL that wraps the most popular bookmarks list</li>
		<li><em>li.popular_bookmark</em> - this is LI tag that wraps each popular bookmark link</li>
		<li><em>a.popular_bookmark_link</em> - this is anchor tag for each popular bookmark link</li>
	</ul>
 
	<?php
	return ob_get_clean();
}
if (isset($_GET['page']) && $_GET['page'] == 'bookmarks-settings')
{
	add_action('contextual_help', 'rc_contextual_help', 10, 3);
}