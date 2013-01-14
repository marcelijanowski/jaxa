<!--BEGIN .hentry -->
<div id="<?php the_ID(); ?>" <?php post_class('portfolio-post'); ?>>
    
    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has post thumbnail */ ?>
    <div class="post-thumb">
        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"><?php the_post_thumbnail('main-image'); ?></a>
        <div class="entry-categories">
            <?php the_category(', ') ?>
        </div>
    </div>
    <?php } ?>
    
    <h2 class="entry-title">
        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>">
            <?php echo smart_trim($post->post_title, 55); ?>
        </a>
        <a href="<?php echo comments_link(); ?>" class="comment-count"><?php echo $post->comment_count; ?></a>
    </h2>
    
    <div class="entry-meta"><?php _e('On', 'framework') ?> <?php the_time( get_option('date_format') ); ?> <?php _e('by', 'framework') ?>  <?php the_author_posts_link(); ?></div>

    <div class="entry-summary">
        <?php echo smart_trim(null, '90'); ?>
    </div>
    
    <a class="continue" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>">
        <?php _e('Read', 'framework') ?>
    </a>


<!--END .hentry -->
</div>