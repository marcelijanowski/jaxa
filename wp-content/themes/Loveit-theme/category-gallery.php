<?php get_header(); ?>
<?php include( get_template_directory() . '/functions/get-options.php' ); /* include theme options */ ?>
			
<!--BEGIN #primary .hfeed-->
	<div id="primary" class="hfeed full-width category-portfolio category-gallery">
        
        <?php if( function_exists('bcn_display')) : echo '<p class="breadcrumb">'; bcn_display(); echo '</p>'; endif; ?>
        
        <?php $category = get_the_category(); ?>
        
		<ul id="porfolio_categories">
            <li <?php if (!isset($_GET['v_sortby'])) : ?>class="current-cat"<?php endif; ?>><a href="<?php echo get_category_link( $category[0]->cat_ID ); ?>" title="<?php _e('Newest', 'framework'); ?>"><?php _e('Newest', 'framework'); ?></a></li>
            <li <?php if (isset($_GET['v_sortby'])) : ?>class="current-cat"<?php endif; ?>><a href="<?php echo get_category_link( $category[0]->cat_ID ); ?>?v_sortby=views&v_orderby=dsc" title="<?php _e('Popular', 'framework'); ?>"><?php _e('Popular', 'framework'); ?></a></li>
        </ul>
        
        
        <h1 class="mainTitle"><?php echo single_cat_title(); ?></h1>
        
    <?php
    
    global $query_string;
    query_posts($query_string . "&posts_per_page=6");
    
    ?>
	
	<?php if (have_posts()) : ?>

        <div class="post-wrapper">
            
		<?php while (have_posts()) : the_post(); ?>
        
		<?php get_template_part( 'content', 'gallery' ); ?>

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