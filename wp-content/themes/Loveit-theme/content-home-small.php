<!--BEGIN .hentry -->
<div id="<?php the_ID(); ?>" <?php post_class('home-small-post'); ?>>


    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
    <div class="tab-thumb">
        <a href="<?php the_permalink();?>" class="thumb"><?php the_post_thumbnail(); ?></a>
    </div>
    <?php } ?>
    <h3 class="entry-title">
        <a href="<?php the_permalink(); ?>" class="title"><?php the_title();?><span class="more"></span></a>
    </h3>
    <div class="entry-meta entry-header">
        <span class="published"><?php _e('On', 'framework') ?> <?php the_time( get_option('date_format') ); ?></span>
        <span class="author-simple"><?php _e('by', 'framework') ?> <?php the_author_posts_link(); ?></span>
    </div>
    

<!-- END .post-container -->
</div>