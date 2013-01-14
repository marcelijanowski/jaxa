<?php get_header(); ?>
<?php include( get_template_directory() . '/functions/get-options.php' ); /* include theme options */ ?>
			
<!--BEGIN #primary .hfeed-->
	<div id="primary" class="hfeed">
        
        <?php if( function_exists('bcn_display')) : echo '<p class="breadcrumb">'; bcn_display(); echo '</p>'; endif; ?>
        
        <?php 
            $category = get_the_category(); 
            if ($category[0])
            {
//                echo '<h1><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></h1>';
                echo '<h1 class="mainTitle"> ' . $category[0]->cat_name . '</h1>';
            }
        ?>
        
        
	
	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

		<?php get_template_part( 'content', 'blog' ); ?>

		<?php endwhile; ?>

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

<?php get_sidebar(); ?>

<?php get_footer(); ?>