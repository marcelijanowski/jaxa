<!--BEGIN .hentry -->
<div id="<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has post thumbnail */ ?>
    <div class="post-thumb">
        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"><?php the_post_thumbnail('blog-image'); ?></a>
        <div class="entry-categories">
            <?php the_category(', ') ?>
        </div>
    </div>
    <?php } ?>

    <h2 class="entry-title">
        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"><?php the_title(); ?></a>
        <span><?php _e('On', 'framework') ?> <?php the_time( get_option('date_format') ); ?> <?php _e('by', 'framework') ?>  <?php the_author_posts_link(); ?> <?php edit_post_link( __('edit', 'framework'), '<span class="edit-post">[', ']</span>' ); ?></span>
    </h2>

    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
    
    <a class="continue" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>">
        <?php _e('Read', 'framework') ?>
    </a>


<!--END .hentry -->
</div>