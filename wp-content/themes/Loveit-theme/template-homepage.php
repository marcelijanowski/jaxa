<?php
/*
Template Name: Homepage
*/
?>

<?php get_header(); ?>
<?php include( get_template_directory() . '/functions/get-options.php' ); /* include theme options */ ?>

    <!-- END #container -->
	</div>

    <?php if ($tz_big_slider == "true") : ?>
    <?php include( get_template_directory() . '/includes/home-main-slider.php' ); ?>
    <?php endif; ?>
    
    
    <?php if ($tz_story_slider == "true") : ?>
    <?php include( get_template_directory() . '/includes/home-story-slider.php' ); ?>
    <?php endif; ?>


    <!-- BEGIN .container -->
	<div class="container">

        <!--BEGIN #content -->
		<div id="content" class="clearfix">

            <?php if ($tz_recent_posts == "true") : ?>
            <?php include( get_template_directory() . '/includes/recent-posts.php' ); ?>
            <?php endif; ?>

			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
											
				
                <?php 
                    
                $categories_block = array();

                for ($i=1; $i<=4; $i++)
                {
                    if (($show = get_option('tz_cat_' . $i)))
                    {
                        $categories_block[get_option('tz_cat_' . $i . '_order')] = $i;   
                    }
                } 

                ksort($categories_block);
                ?>
                
                <?php foreach ($categories_block as $i):?>
                
                    <?php include( get_template_directory() . '/includes/category-block-' . $i . '.php' ); ?>
                
                <?php endforeach; ?>

                <?php if ($tz_gallery_posts == "true") : ?>
                <?php include( get_template_directory() . '/includes/gallery-block.php' ); ?>
                <?php endif; ?>
				
				
				<?php if ($tz_bottom_posts == "true") : ?>
                <?php include( get_template_directory() . '/includes/bottom-posts.php' ); ?>
                <?php endif; ?>
                
                

			<!--END #primary .hfeed-->
			</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>