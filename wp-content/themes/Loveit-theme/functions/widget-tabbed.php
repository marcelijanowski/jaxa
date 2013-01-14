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
 * tabd function to widgets_init that'll lotab our widget.
 */
add_action( 'widgets_init', 'tz_tab_widgets' );

/*
 * Register widget.
 */
 
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
 
function tz_tab_widgets() {
	register_widget( 'TZ_Tab_Widget' );
}

function enqueue(){
	if (is_active_widget(false, false, 'tz_tab_widget')){ 
		wp_enqueue_script('jquery-ui-core');		
		wp_enqueue_script('jquery-ui-tabs');
		wp_register_script('tabbed', get_template_directory_uri().'/js/tabbed-widget.js', array('jquery-ui-tabs'));
		wp_enqueue_script('tabbed');
	}
}

add_action('init', 'enqueue');

/*
 * Widget class.
 */
class tz_tab_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function TZ_tab_Widget() {
	
		/* Widget settings */
		$widget_ops = array( 'classname' => 'tz_tab_widget', 'description' => __('A tabbed widget that display popular posts, recent posts, commented posts.', 'framework') );

		/* Widget control settings */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'tz_tab_widget' );

		/* Create the widget */
		$this->WP_Widget( 'tz_tab_widget', __('Custom Tabbed Widget', 'framework'), $widget_ops, $control_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		global $wpdb;
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
	

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		//Randomize tab order in a new array
		$tab = array();
			
		/* Display a containing div */
		echo '<div id="tabs">';
			echo '<ul id="tab-items">';
				echo '<li><a href="#tabs-1"><span>' . __('Popular', 'framework') .'</span></a></li>';
				echo '<li><a href="#tabs-2"><span>' . __('Recent', 'framework') . '</span></a></li>';
				echo '<li><a href="#tabs-3"><span>' . __('Commented', 'framework') . '</span></a></li>';
			echo '</ul>';
			
			echo '<div class="tabs-inner">';
		
			// Popular posts tab
			echo '<div id="tabs-1" class="tab tab-popular">';
				echo '<ul>';
				
                $popPosts = new WP_Query();
                $popPosts->query('showposts=' . $instance['post_count'] . '&orderby=comment_count');
                while ($popPosts->have_posts()) : $popPosts->the_post(); ?>

                    <li class="clearfix">
                        <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
                        <div class="tab-thumb">
                            <a href="<?php the_permalink();?>" class="thumb"><?php the_post_thumbnail(); ?></a>
                        </div>
                        <?php } ?>
                        <h3 class="entry-title">
                            <div class="entry-categories">
                                <?php the_category(', ') ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="title"><?php the_title();?></a>
                        </h3>
                        <div class="entry-meta entry-header">
                            <span class="views-count"><a title="Views on <?php the_title(); ?>" href="<?php the_permalink();  ?>"><?php echo number_format(get_post_total_previews()); ?></a></span>
                            <span class="author-simple"><?php _e('by', 'framework') ?>  <?php the_author_posts_link(); ?></span>
                        </div>
                    </li>

                <?php endwhile; 
                wp_reset_query();
	
				echo '</ul>';
			echo '</div><!-- #tabs-1 -->';

			//Recent posts tabs
			echo '<div id="tabs-2" class="tab tab-recent">';
				echo '<ul>';
					
						$recentPosts = new WP_Query();
						$recentPosts->query('showposts=' . $instance['post_count']);
						while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
							<li class="clearfix">
								<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
								<div class="tab-thumb">
									<a href="<?php the_permalink();?>" class="thumb"><?php the_post_thumbnail(); ?></a>
								</div>
								<?php } ?>
								<h3 class="entry-title">
                                    <div class="entry-categories">
                                        <?php the_category(', ') ?>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="title"><?php the_title();?></a>
                                </h3>
								<div class="entry-meta entry-header">
									<span class="published"><?php the_time( get_option('date_format') ); ?></span>
                                    <span class="author-simple"><?php _e('by', 'framework') ?>  <?php the_author_posts_link(); ?></span>
                                </div>
							</li>
						<?php endwhile;
						
				echo '</ul>';
			echo '</div><!-- #tabs-2 -->';

			//Recent comments tabs
			echo '<div id="tabs-3" class="tab tab-comments">';
				
				echo '<ul>';
				
                $popPosts = new WP_Query();
                $popPosts->query('showposts=' . $instance['post_count'] . '&orderby=comment_count');
                while ($popPosts->have_posts()) : $popPosts->the_post(); ?>

                    <li class="clearfix">
                        <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
                        <div class="tab-thumb">
                            <a href="<?php the_permalink();?>" class="thumb"><?php the_post_thumbnail(); ?></a>
                        </div>
                        <?php } ?>
                        <h3 class="entry-title">
                            <div class="entry-categories">
                                <?php the_category(', ') ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="title"><?php the_title();?></a>
                        </h3>
                        <div class="entry-meta entry-header">
                            <span class="comment-count"><?php comments_popup_link(__('No comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span>
                            <span class="author-simple"><?php _e('by', 'framework') ?>  <?php the_author_posts_link(); ?></span>
                        </div>
                    </li>

                <?php endwhile; 
                wp_reset_query();
                
				echo '</ul>';
                
			echo '</div><!-- #tabs-3 -->';

			//Tags tab
			echo '<div id="tabs-4" class="tab tab-tags">';
			wp_tag_cloud('largest=12&smallest=12&unit=px');
			echo '</div><!-- #tabs-4 -->';

		echo '</div><!-- .tabs-inner -->';
		
		echo '</div><!-- #tabs -->';

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* No need to strip tags */
		$instance['post_count'] = $new_instance['post_count'];
		
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
            'post_count' => 3,
		);
        
        $post_count_options = range(1, 10);
        
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- tab 1 title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab1' ); ?>"><?php _e('Post count:', 'framework') ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name('post_count'); ?>" id="<?php echo $this->get_field_id('post_count'); ?>">';
		

            <?php
            foreach ($post_count_options as $option){
                if ($option == $instance['post_count'])
                {
                    echo "<option selected=\"selected\">" . $option . "</option>";
                }
                else
                {
                    echo "<option>" . $option . "</option>";
                }
            }
            ?>

            </select>
            
		</p>
		
		
		
	
	<?php
	}
}
?>