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
 * Category list widget class
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'tz_category_list_load_widgets' );

/**
 * Register our widget.
 */
function tz_category_list_load_widgets() {
	register_widget( 'Tz_Widget_Category_List' );
}



class Tz_Widget_Category_List extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_categories', 'description' => __( "A list of categories using blog category as parent (set in theme options)", 'framework' ) );
		parent::__construct('category_list', __('Category List', 'framework'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Categories', 'framework' ) : $instance['title'], $instance, $this->id_base);
		$c = ! empty( $instance['count'] ) ? '1' : '0';
		$h = ! empty( $instance['hierarchical'] ) ? '1' : '0';

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		$cat_args = array('orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h, 'title_li' => '');
        
        $blog_category_id = get_option('tz_blog_category');
        
        if (!empty($blog_category_id))
        {
            $cat_args['child_of'] = $blog_category_id;
            
        }
        
        
?>
		<ul>
            
            
        <?php if (!empty($blog_category_id)) : ?>
            
            <li <?php if (is_category($blog_category_id)) : ?>class="current-cat"<?php endif; ?>><a href="<?php echo get_category_link( $blog_category_id ); ?>" title="<?php _e('All Categories', 'framework'); ?>"><?php _e('All Categories', 'framework'); ?></a></li>
            
        <?php endif; ?>
            
<?php
		wp_list_categories(apply_filters('widget_categories_args', $cat_args));
?>
		</ul>
<?php

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = !empty($new_instance['count']) ? 1 : 0;
		$instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = esc_attr( $instance['title'] );
		$count = isset($instance['count']) ? (bool) $instance['count'] :false;
		$hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
		$dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'framework' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts', 'framework' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
		<label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy', 'framework' ); ?></label></p>
<?php
	}

}
?>
