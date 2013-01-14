<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>

			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed full-width">
                
                <div class="wrap">
                
                <?php if( function_exists('bcn_display')) : echo '<p class="breadcrumb">'; bcn_display(); echo '</p>'; endif; ?>
                
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <!--BEGIN .hentry-->
                    <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
                        <h1 class="mainTitle"><?php the_title(); ?></h1>
                        <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>

                        <!--BEGIN .entry-meta .entry-header-->
                        <div class="entry-meta entry-header">
                            <?php edit_post_link( __('edit', 'framework'), '<span class="edit-post">[', ']</span>' ); ?>
                        <!--END .entry-meta .entry-header-->
                        </div>
                        <?php endif; ?>

                        <!--BEGIN .entry-content -->
                        <div class="entry-content">
                            <?php the_content(__('Read more...', 'framework')); ?>
                            <?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'framework').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                        <!--END .entry-content -->
                        </div>

                    <!--END .hentry-->
                    </div>
                    
                </div>
                
                <?php 
                $att_gallery = get_post_meta($post->ID, 'att_gallery', true);
                
                if (!empty($att_gallery)) 
                {
                
                    if (function_exists('banesto_attached_gallery_block'))
                    {
                        banesto_attached_gallery_block($att_gallery, 5);
                    }
                
                }
                ?>
				
				<?php comments_template('', true); ?>

				<?php endwhile; endif; ?>
			
			<!--END #primary .hfeed-->
			</div>

<?php get_footer(); ?>