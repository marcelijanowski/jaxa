<!--BEGIN .hentry -->
<div id="<?php the_ID(); ?>" <?php post_class('gallery-post-small'); ?>>
    
    
    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has post thumbnail */ ?>
    <div class="post-thumb">
        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"><?php the_post_thumbnail('main-image-pictures'); ?></a>
    </div>
    <?php } ?>
    
    <?php 
        $attachments = get_children( array( 'post_parent' => $post->ID ) );
        $image_count = count( $attachments );
    ?>

    <h3 class="entry-title">
        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>">
            <?php the_title(); ?>
        </a>
        <a href="<?php the_permalink(); ?>" class="image-count"><?php echo $image_count; ?></a>
    </h3>
    
    

<!--END .hentry -->
</div>