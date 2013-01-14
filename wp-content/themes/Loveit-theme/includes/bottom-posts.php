<!-- BEGIN .bottom-blocks -->
<div class="bottom-blocks home-block-wide">

<?php 
    
    $tz_bottom_posts = new WP_Query(); 
    
    $bottom_post_args = array(
        'posts_per_page'    => $tz_bottom_number
    );
    
    
    // exclude categories if set any
    if (!empty($tz_bottom_cats_exluded))
    {
        $bottom_excluded_cat_array = explode(',', $tz_bottom_cats_exluded);
        
        if (count($bottom_excluded_cat_array) > 0)
        {
            $bottom_post_args['category__not_in'] = explode(',', $tz_bottom_cats_exluded);
        }
    }
    
    // exclude recent posts
    if ($tz_bottom_exclude_recent == "true" && $tz_recent_posts == "true")
    {
        if ($tz_recent_manual == 'true')
        {
            $exluded_posts_array = array(
                $tz_recent_1,
                $tz_recent_2,
                $tz_recent_3
            );
        }
        else 
        {
            $tz_recent_posts = new WP_Query(); 
            $tz_recent_posts->query('posts_per_page=3&cat=' . $tz_recent_cats); 
   
            foreach ($tz_recent_posts->posts as $post_item)
            { 
                $exluded_posts_array[] = $post_item->ID;
            }
        }
        
        $bottom_post_args['post__not_in'] = $exluded_posts_array;
    }
    
    
    $tz_bottom_posts->query($bottom_post_args); 
    
    while ($tz_bottom_posts->have_posts())
    {
        $tz_bottom_posts->the_post();
        get_template_part( 'content', 'home-small' );
    } 
    
?>
    
    <div class="delimiter bottom-left"></div>
    <div class="delimiter bottom-right"></div>
    
<!-- END .bottom-blocks -->
</div>