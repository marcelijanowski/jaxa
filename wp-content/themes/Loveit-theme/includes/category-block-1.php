<!-- BEGIN .category-block -->
<div class="category-block">

    <?php $fc = 0; ?>

    <?php /* show posts tagged featured */
    $tz_category_one_posts = new WP_Query(); 
    $tz_category_one_posts->query('cat=' . $tz_cat_1_select . '&posts_per_page=5'); 
    
    while ($tz_category_one_posts->have_posts())
    {
        $tz_category_one_posts->the_post();

        $fc++;

        if ( $fc == 1 ) 
        {
            get_template_part( 'content', 'portfolio' ); ?>
            <div class="other-posts alignright">
        <?php
        }
        else
        {
            get_template_part( 'content', 'home-small' );
        }
        
        
    ?>
    
    <!--[if lt IE 8]>
            <style>#featured-posts-block .entry-header{min-height:55px;}</style>
    <![endif]-->

    <?php 
    } ?>
    
        <a class="seeMore" href="<?php echo get_category_link( $tz_cat_1_select ); ?>"><?php _e( 'More news', 'framework'); ?></a>
    
    </div>

<!-- END .category-block -->
</div>