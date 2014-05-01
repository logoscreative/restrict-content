<?php

/*******************************************
* Restrict Content User Checks
*******************************************/

function rcCheckUser()
{

	$ipperms = pardot_validate_ip();

	if ($ipperms === true)
	{		
		if (current_user_can('edit_posts'))
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
				add_filter('the_content', 'rcMetaDisplayContributor');
			}
		}
		else
		{
			add_filter('the_content', 'rcMetaDisplaySubscriber');
			add_filter('the_title', 'rcMetaDisplayInternalTitle');
			add_filter('the_content', 'rcMetaDisplayInternalWarning', 9);
		}				
	}
	else
	{
		add_filter('the_content', 'rcMetaDisplayNone');
		add_filter('the_title', 'rcMetaDoNotDisplayInternalTitle');
	}

}
add_action('loop_start', 'rcCheckUser');
