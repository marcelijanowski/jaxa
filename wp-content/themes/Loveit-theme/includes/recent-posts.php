<!-- BEGIN #recent-news-block -->
<div id="recent-news-block">

<?php 
    
    if ($tz_recent_manual == 'true')
    {
        for ($i=1; $i<=3; $i++)
        {
            $post_id = get_option('tz_recent_' . $i);
            $tz_recent_post = new WP_Query('p=' . $post_id);

            while ($tz_recent_post->have_posts())
            {
                $tz_recent_post->the_post();
                get_template_part( 'content', 'portfolio' );
            }
        }
    }
    else 
    {
        $tz_recent_posts_list = new WP_Query(); 
        $tz_recent_posts_list->query('posts_per_page=3&cat=' . $tz_recent_cats); 

        while ($tz_recent_posts_list->have_posts())
        { 
            $tz_recent_posts_list->the_post();
            get_template_part( 'content', 'portfolio' );
        }
    }
    
?>

<!-- END #recent-news-block -->
</div>