<?php

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'framework') ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

    <?php if ( comments_open() ||  have_comments()) : ?>

        <h2 id="comments"><?php _e('Comments', 'framework') ?></h2>

    <?php endif; ?>


	<?php if ( have_comments() ) : // if there are comments ?>
        
        <?php if ( ! empty($comments_by_type['comment']) ) : // if there are normal comments ?>
		
		<ol class="commentlist">
        <?php wp_list_comments('type=comment&avatar_size=50&callback=tz_comment'); ?>
        </ol>

        <?php endif; ?>

        <?php if ( ! empty($comments_by_type['pings']) ) : // if there are pings ?>
		
		<h2 id="pings"><?php _e('Trackbacks for this post', 'framework') ?></h2>
		
		<ol class="pinglist">
        <?php wp_list_comments('type=pings&callback=tz_list_pings'); ?>
        </ol>

        <?php endif; ?>
		
		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link(); ?></div>
			<div class="alignright"><?php next_comments_link(); ?></div>
		</div>
		
		<?php if ('closed' == $post->comment_status ) : // if the post has comments but comments are now closed ?>
		<p class="nocomments"><?php _e('Comments are now closed for this article.', 'framework') ?></p>
		<?php endif; ?>

 		<?php else :  ?>
		
        <?php if ('open' == $post->comment_status) : // if comments are open but no comments so far ?>
        <!-- If comments are open, but there are no comments. -->

        <?php else : // if comments are closed ?>
		
		<?php if (is_single()) { ?><p class="nocomments"><?php _e('Comments are closed.', 'framework') ?></p><?php } ?>

        <?php endif; ?>
        
        
<?php endif; ?>


	<?php if ( comments_open() ) : ?>

	<div id="respond">

		<div class="cancel-comment-reply">
			<?php cancel_comment_reply_link(); ?>
		</div>
        
        
        <?php 
        
        comment_form(array(
            'comment_field'         => '<div class="wrapBig"><div class="textarea-container"><textarea name="comment" id="comment" cols="58" rows="10" tabindex="4" class="required" placeholder="' . __('Your comment', 'framework') . '"></textarea></div></div>',
            'must_log_in'           => '<p class="must-log-in">...',
            'logged_in_as'          => '<p>' . sprintf(__('Logged in as %1$s. %2$sLog out &raquo;%3$s', 'framework'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>', '<a href="'.(function_exists('wp_logout_url') ? wp_logout_url(get_permalink()) : get_option('siteurl').'/wp-login.php?action=logout" title="').'" title="'.__('Log out of this account', 'framework').'">', '</a>') . '</p>',
            'comment_notes_before'  => '',
            'comment_notes_after'   => '',
            'title_reply'           => '',
            'title_reply_to'        => '',
            'cancel_reply_link'     => __( 'Cancel reply' ),
            'label_submit'          => __('Send', 'framework')
        )); 
        
        ?>
	

	</div>

	<?php endif; // if you delete this the sky will fall on your head ?>
