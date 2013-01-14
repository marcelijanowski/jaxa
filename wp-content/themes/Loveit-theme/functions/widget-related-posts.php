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

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'tz_related_posts_load_widgets' );

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function tz_related_posts_load_widgets() {
	register_widget( 'Tz_Related_Posts_Widget' );
}

/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Tz_Related_Posts_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Tz_Related_Posts_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tz_related_posts_widget', 'description' => __('A widget that displays related posts.', 'framework') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'tz-related-posts-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'tz-related-posts-widget', __('AWESEM Related Posts Widget', 'framework'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		
		?>

	<!-- BEGIN #related-posts -->
							<div id="related-posts">
							
								<?php
								 wp_reset_query();
								$tz_related_posts_title = $instance['tz_related_posts_title'];
								$tz_number_of_related_posts = $instance['tz_number_of_related_posts'];
								
								global $post;
								

								$backup = $post;  // backup the current object
								$tz_categories = get_the_category($post->ID);

								if ($tz_categories) {
									$tz_category_ids = array();
									foreach($tz_categories as $tz_individual_category) $tz_category_ids[] = $tz_individual_category->term_id;
								
									$args=array(
										'category__in' => $tz_category_ids,
										'post__not_in' => array($post->ID),
										'ignore_sticky_posts'=>1,
										'posts_per_page'=>$tz_number_of_related_posts
									);
									$tz_related_posts = new wp_query($args);
									if( $tz_related_posts->have_posts() ) {
										if(!empty($tz_related_posts_title)) { echo '<h3 class="widget-title">'.$tz_related_posts_title.'</h3>'; }
										while ($tz_related_posts->have_posts()) {
											$tz_related_posts->the_post();
										?>
											<!-- BEGIN .post-container -->
											<div class="post-container clearfix">
											
												<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has post thumbnail */ ?>
												<div class="post-thumb">
													<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"><?php the_post_thumbnail('thumbnail-large'); /* post thumbnail settings configured in functions.php */ ?></a>
												</div>
												<?php } ?>
												
												<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"> <?php the_title(); ?></a></h2>
												
												<!--BEGIN .entry-meta .entry-header-->
												<div class="entry-meta entry-header">
													<span class="published"><?php the_time( get_option('date_format') ); ?></span>
													<span class="meta-sep">&middot;</span>
													<span class="comment-count"><?php comments_popup_link(__('No comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span>
												<!--END .entry-meta entry-header -->
												</div>
												
												<!--BEGIN .entry-summary -->
												<div class="entry-summary">
													<p><?php content(10); ?></p>
												<!--END .entry-summary -->
												</div>
											
											<!-- END .post-container -->
											</div>
										<?php
										}
									}
								}
								$post = $backup;  // copy it back
 								 wp_reset_query(); // to use the original query again
								?>
							
							<!-- END #related-posts -->
							</div>



<?php







		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['tz_related_posts_title'] = strip_tags( $new_instance['tz_related_posts_title'] );
		$instance['tz_number_of_related_posts'] = strip_tags( $new_instance['tz_number_of_related_posts'] );


		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'tz_related_posts_title' => __('Related Posts', 'framework'), 'tz_number_of_related_posts' => 3 );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tz_related_posts_title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'tz_related_posts_title' ); ?>" name="<?php echo $this->get_field_name( 'tz_related_posts_title' ); ?>" value="<?php echo $instance['tz_related_posts_title']; ?>" style="width:100%;" />
		</p>

		<!-- Your Name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tz_number_of_related_posts' ); ?>"><?php _e('# Related Posts:', 'framework'); ?></label>
			<input id="<?php echo $this->get_field_id( 'tz_number_of_related_posts' ); ?>" name="<?php echo $this->get_field_name( 'tz_number_of_related_posts' ); ?>" value="<?php echo $instance['tz_number_of_related_posts']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>