<!-- BEGIN .gallery-block -->
<div class="gallery-block home-block-wide">

    <?php
    
    $tz_gallery_posts = new WP_Query(); 
    
    $gallery_post_args = array(
        'posts_per_page'    => $tz_gallery_number,
        'tax_query' => array(
            array(
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => array( 'post-format-gallery' )
            )
        )
    );
    
    $tz_gallery_posts->query($gallery_post_args); 
    
    while ($tz_gallery_posts->have_posts())
    {
        $tz_gallery_posts->the_post();
        get_template_part( 'content', 'gallery-small' );
    } 
    
    ?>
    
    <div class="title"><?php _e('Gallery', 'framework' ); ?></div>

    <div class="delimiter bottom-left"></div>
    <div class="delimiter bottom-right"></div>
    
<!-- END .gallery-block -->
</div>