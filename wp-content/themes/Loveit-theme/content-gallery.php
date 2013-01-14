<!--BEGIN .hentry -->
<div id="<?php the_ID(); ?>" <?php post_class('gallery-post'); ?>>
    
    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has post thumbnail */ ?>
    <div class="post-thumb">
        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"><?php the_post_thumbnail('gallery-image'); ?></a>
        <div class="views-count">
            
            <div class="count"><?php if(function_exists('get_post_views')) { echo number_format(get_post_total_views()); } ?></div>
            
        </div>
    </div>
    <?php } ?>
    
    <?php 
        $attachments = get_children( array( 'post_parent' => $post->ID ) );
        $image_count = count( $attachments );
    ?>

    <h2 class="entry-title">
        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>">
            <?php the_title(); ?>
        </a>
        <a href="<?php the_permalink(); ?>" class="comment-count image-count"><?php echo $image_count; ?></a>
    </h2>
    
    

<!--END .hentry -->
</div>