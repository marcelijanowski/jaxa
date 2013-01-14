<?php
/* --
Theme Name: LOVE it
Theme URI: http://www.themeforest.net/user/themiac
Description: Premium Wordpress Magazine Theme
Author: Themiac
Author URI: http://www.themiac.com/
Version: 1

All files, unless otherwise stated, are released under the GNU General Public License version 3.0 (http://www.gnu.org/licenses/gpl-3.0.html)

-- */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'tz_social_counter_widgets' );

/*
 * Register widget.
 */
function tz_social_counter_widgets() {
	register_widget( 'TZ_Social_Counter_Widget' );
}

/*
 * Widget class.
 */
class tz_social_counter_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function TZ_Social_Counter_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tz_social_counter_widget', 'description' => __('A widget that displays a social counter.', 'framework') );

		/* Create the widget. */
		$this->WP_Widget( 'tz_social_counter_widget', __('Custom Social Counter','framework'), $widget_ops );
	}	

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		if (!extension_loaded('simplexml')) {
			echo "<strong>You need to enable the <a href='http://php.net/manual/en/book.simplexml.php'>SimpleXML extension</a> to be able to use this widget</strong>!";
		}

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$feedburner_title = $instance['feedburner_title'];
		$feedburner_username = $instance['feedburner_username'];
		$feedburner_url = $instance['feedburner_url'];
		$feedburner_subscribers = get_option('feedburner_subscribers');
		$feedburner_last_check = get_option('feedburner_last_check');

		$twitter_title = $instance['twitter_title'];
		$twitter_username = $instance['twitter_username'];
		$twitter_followers = get_option('twitter_followers');
		$twitter_last_check = get_option('twitter_last_check');

		$facebook_title = $instance['facebook_title'];
		$facebook_id = $instance['facebook_id'];
		$facebook_url = $instance['facebook_url'];

		$facebook_fans = get_option('facebook_fans');
		$facebook_last_check = get_option('facebook_last_check');

		$one_hour_ago = time() - 1800;
		
		/* FeedBurner */

		if(!empty($feedburner_username) && $feedburner_last_check < $one_hour_ago) { 

			try {
				$feedurl='https://feedburner.google.com/api/awareness/1.0/GetFeedData?uri='.$feedburner_username . '';
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_URL, $feedurl);
				$data = curl_exec($ch);
				curl_close($ch);
				$simplexml = new SimpleXMLElement($data);
				$subscribers = (string) $simplexml->feed->entry['circulation'];

				if($subscribers > 0) {
					$feedburner_subscribers = $subscribers;
					update_option("feedburner_subscribers",$feedburner_subscribers);
				}

				update_option("feedburner_last_check",time());
			}
			catch(Exception $e) { var_dump($e->getMessage()); } 
		}
		

		/* Twitter */
		if(!empty($twitter_username) && $twitter_last_check < $one_hour_ago) { 

			try {

				$twitter_url = 'http://twitter.com/users/show.xml?screen_name='.$twitter_username . '';

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_URL, $twitter_url);
				$data = curl_exec($ch);
				curl_close($ch);
				$simplexml = new SimpleXMLElement($data);

				$followers = (string) $simplexml->followers_count;

				if($followers > 0) {
					$twitter_followers = $followers;

					update_option("twitter_followers",$followers);
				}

				update_option("twitter_last_check",time());
			}
			catch(Exception $e) { var_dump($e->getMessage()); }
		}
					
		/* Facebook */
		if(!empty($facebook_id) && $facebook_last_check < $one_hour_ago) {

			try { 
				$page_id = $facebook_id;
				$facebook_url = "http://api.facebook.com/restserver.php?method=facebook.fql.query&query=SELECT%20fan_count%20FROM%20page%20WHERE%20page_id=".$page_id . "";
			
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_URL, $facebook_url);
				$data = curl_exec($ch);
				curl_close($ch);
				$simplexml = new SimpleXMLElement($data);

				$fans = (string) $simplexml->page->fan_count;

				if($fans > 0) {
					$facebook_fans = $fans;
					update_option("facebook_fans",$facebook_fans);
				}

				update_option("facebook_last_check",time());
			}
			catch(Exception $e) { var_dump($e->getMessage()); }

		}

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
	?> 
		
		
		<ul>
			<?php if(!empty($feedburner_url) && !empty($feedburner_username) && !empty($feedburner_title)) { ?>
			<li class="rss">
				<div class="img">
					<img src="<?php echo get_template_directory_uri(); ?>/images/social-rss.png" alt="RSS" />
				</div>
				<div class="txt">
					<p><a href="<?php echo $feedburner_url; ?>"><?php echo $feedburner_title; ?></a> <span><?php echo $feedburner_subscribers; ?> <?php _e('subscribers', 'framework'); ?></span></p>
				</div>
			</li>
			<?php } ?>
			<?php if(!empty($twitter_username) && !empty($twitter_title)) { ?>
			<li class="twitter">
				<div class="img">
					<img src="<?php echo get_template_directory_uri(); ?>/images/social-twitter.png" alt="Twitter" />
				</div>
				<div class="txt">
					<p><a href="http://twitter.com/<?php echo $twitter_username; ?>"><?php echo $twitter_title; ?></a> <span><?php echo $twitter_followers; ?> <?php _e('followers', 'framework'); ?></span></p>
				</div>
			</li>
			<?php } ?>
			<?php if(!empty($facebook_url) && !empty($facebook_id) && !empty($facebook_title)) { ?>
			<li class="facebook">
				
				<div class="img">
					<img src="<?php echo get_template_directory_uri(); ?>/images/social-facebook.png" alt="Facebook" />
				</div>
				<div class="txt">
					<p><a href="<?php echo $facebook_url; ?>"><?php echo $facebook_title; ?></a> <span><?php echo $facebook_fans; ?> <?php _e('fans', 'framework'); ?></span></p>
				</div>
			</li>
			<?php } ?>
		</ul>
		
		<?php 

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['feedburner_title'] = strip_tags( $new_instance['feedburner_title'] );
		$instance['feedburner_username'] = strip_tags( $new_instance['feedburner_username'] );
		$instance['feedburner_url'] = strip_tags( $new_instance['feedburner_url'] );
		$instance['twitter_title'] = strip_tags( $new_instance['twitter_title'] );
		$instance['twitter_username'] = strip_tags( $new_instance['twitter_username'] );
		$instance['facebook_title'] = strip_tags( $new_instance['facebook_title'] );
		$instance['facebook_id'] = strip_tags( $new_instance['facebook_id'] );
		$instance['facebook_url'] = strip_tags( $new_instance['facebook_url'] );

		/* No need to strip tags for.. */

		return $instance;
	}
	
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	 
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
		'title' => '',
		'feedburner_title' => 'Subscribe RSS Feed',
		'feedburner_username' => 'awesem',
		'feedburner_url' => 'http://feeds.feedburner.com/awesem',
		'twitter_title' => 'Follow us on Twitter',
		'twitter_username' => 'awesemthemes',
		'facebook_title' => 'Connect on Facebook',
		'facebook_id' => '80655071208',
		'facebook_url' => 'http://www.facebook.com/envato'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<!-- FeedBurner -->
		<p><img src="<?php echo get_template_directory_uri(); ?>/images/social-rss.png" alt="" style="vertical-align: middle; margin-right: 10px;" /><strong>FeedBurner</strong></p>

		<!-- FeedBurner Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'feedburner_title' ); ?>"><?php _e('Title e.g. Subscribe RSS Feed', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'feedburner_title' ); ?>" name="<?php echo $this->get_field_name( 'feedburner_title' ); ?>" value="<?php echo $instance['feedburner_title']; ?>" />
		</p>

		<!-- FeedBurner Username: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'feedburner_username' ); ?>"><?php _e('Username e.g. awesem', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'feedburner_username' ); ?>" name="<?php echo $this->get_field_name( 'feedburner_username' ); ?>" value="<?php echo $instance['feedburner_username']; ?>" />
		</p>
		
		<!-- FeedBurner URL: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'feedburner_url' ); ?>"><?php _e('URL e.g. http://feeds.feedburner.com/awesem', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'feedburner_url' ); ?>" name="<?php echo $this->get_field_name( 'feedburner_url' ); ?>" value="<?php echo $instance['feedburner_url']; ?>" />
		</p>
		
		<!-- Twitter -->
		<p><img src="<?php echo get_template_directory_uri(); ?>/images/social-twitter.png" alt="" style="vertical-align: middle; margin-right: 10px;" /><strong>Twitter</strong></p>
		
		<!-- Twitter Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_title' ); ?>"><?php _e('Title e.g. Follow us on Twitter', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_title' ); ?>" name="<?php echo $this->get_field_name( 'twitter_title' ); ?>" value="<?php echo $instance['twitter_title']; ?>" />
		</p>
		
		<!-- Twitter Username: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_username' ); ?>"><?php _e('Username e.g. awesemthemes', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_username' ); ?>" name="<?php echo $this->get_field_name( 'twitter_username' ); ?>" value="<?php echo $instance['twitter_username']; ?>" />
		</p>
		
		<!-- Facebook -->
		<p><img src="<?php echo get_template_directory_uri(); ?>/images/social-facebook.png" alt="" style="vertical-align: middle; margin-right: 10px;" /><strong>Facebook</strong></p>
		
		<!-- Facebook Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'facebook_title' ); ?>"><?php _e('Title e.g. Connect on Facebook', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook_title' ); ?>" name="<?php echo $this->get_field_name( 'facebook_title' ); ?>" value="<?php echo $instance['facebook_title']; ?>" />
		</p>
		
		<!-- Facebook ID: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'facebook_id' ); ?>"><?php _e('Page ID e.g. 80655071208', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook_id' ); ?>" name="<?php echo $this->get_field_name( 'facebook_id' ); ?>" value="<?php echo $instance['facebook_id']; ?>" />
		</p>
		
		<!-- Facebook URL: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e('Page URL e.g. http://www.facebook.com/envato', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" value="<?php echo $instance['facebook_url']; ?>" />
		</p>
		
	<?php
	}
}
?>