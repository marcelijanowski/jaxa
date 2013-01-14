<?php get_header(); ?>
<?php include( get_template_directory() . '/functions/get-options.php' ); /* include theme options */ ?>
			
<!--BEGIN #primary .hfeed-->
	<div id="primary" class="hfeed full-width category-portfolio">
        
        <?php if( function_exists('bcn_display')) : echo '<p class="breadcrumb">'; bcn_display(); echo '</p>'; endif; ?>
        
        
        <?php
        
        $cat_args = array('orderby' => 'name', 'show_count' => false, 'hierarchical' => true, 'title_li' => '');
        $portoflio_category_id = get_option('tz_portfolio_category');
        
        if (!empty($portoflio_category_id))
        {
            $cat_args['child_of'] = $portoflio_category_id;
        } 
        
        ?>
        
		<ul id="porfolio_categories">
            
        <?php if (!empty($portoflio_category_id)) : ?>
            
            <li <?php if (is_category($portoflio_category_id)) : ?>class="current-cat"<?php endif; ?>><a href="<?php echo get_category_link( $portoflio_category_id ); ?>" title="<?php _e('All Categories', 'framework'); ?>"><?php _e('All Categories', 'framework'); ?></a></li>
            
        <?php endif; ?>
            
        <?php wp_list_categories($cat_args); ?>
            
        </ul>
        
        
        
        <h1 class="mainTitle"><?php echo single_cat_title(); ?></h1>
        
    <?php
    
    global $query_string;
    query_posts($query_string . "&posts_per_page=6");
    
    ?>
	
	<?php if (have_posts()) : ?>

        <div class="post-wrapper">
            
		<?php while (have_posts()) : the_post(); ?>
        
		<?php get_template_part( 'content', 'portfolio' ); ?>

		<?php endwhile; ?>
        
            
        </div>

		<!--BEGIN .navigation .page-navigation -->
		<div class="navigation page-navigation">
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
			<div class="nav-next"><?php next_posts_link(__('&larr; Older Entries', 'framework')) ?></div>
			<div class="nav-previous"><?php previous_posts_link(__('Newer Entries &rarr;', 'framework')) ?></div>
			<?php } ?>
		<!--END .navigation ,page-navigation -->
		</div>
		
	<?php endif; ?>
	
	<!--END #primary .hfeed-->
	</div>

<?php get_footer(); ?>