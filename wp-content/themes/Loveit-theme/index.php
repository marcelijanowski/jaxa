<?php get_header(); ?>
<?php include( get_template_directory() . '/functions/get-options.php' ); /* include theme options */ ?>
			
<!--BEGIN #primary .hfeed-->
	<div id="primary" class="hfeed">
	
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