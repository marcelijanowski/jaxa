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
add_action( 'widgets_init', 'tz_follow_us_widgets' );

/*
 * Register widget.
 */
function tz_follow_us_widgets() {
	register_widget( 'TZ_Follow_Us_Widget' );
}

/*
 * Widget class.
 */
class tz_follow_us_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function TZ_Follow_Us_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tz_follow_us_widget', 'description' => __('A widget that displays follow us links from theme options.', 'framework') );

		/* Create the widget. */
		$this->WP_Widget( 'tz_follow_us_widget', __('Follow Us Links', 'framework'), $widget_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );
        
        /* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

        ?>
			
			<div id="follow_us_wrapper" class="clearfix">
				
                <?php 
                    
                $follow_us_links = array();

                for ($i=1; $i<=5; $i++)
                {
                    if (($show = get_option('tz_follow_' . $i . '_active')))
                    {
                        $follow_us_links[get_option('tz_follow_' . $i . '_order')] = $i;   
                    }
                } 

                ksort($follow_us_links);
                ?>
                
                
                <?php foreach ($follow_us_links as $i) : ?>
                
                <?php
                    $follow_url = get_option( 'tz_follow_' . $i . '_url' );
                    $follow_image_url = get_option( 'tz_follow_' . $i . '_image_url' );
                ?>
                
                <?php if (filter_var($follow_url, FILTER_VALIDATE_URL) && filter_var($follow_image_url, FILTER_VALIDATE_URL)) : ?>

                <a href="<?php echo $follow_url; ?>" title="<?php _e('Follow Us', 'framework'); ?>" target="_blank">
                    <img src="<?php echo $follow_image_url; ?>" alt="" />
                </a>
                
                <?php endif; ?>
                
                <?php endforeach; ?>
                
			</div>
		
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
            'title' => 'Follow Us',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		
		
	<?php
	}
	
	
}
?>