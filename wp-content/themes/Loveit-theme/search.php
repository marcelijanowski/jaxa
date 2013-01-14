<?php get_header(); ?>
			
			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
                
            <?php if( function_exists('bcn_display')) : echo '<p class="breadcrumb">'; bcn_display(); echo '</p>'; endif; ?>
        
            
                
                
			<?php if (have_posts()) : ?>

			<h1 class="mainTitle"><?php _e('Search Results', 'framework') ?></h1>

			<div id="search-results">

                <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part( 'content', 'blog' ); ?>

                <?php endwhile; ?>
			
			</div>

			<!--BEGIN .navigation .page-navigation -->
			<div class="navigation page-navigation">
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
				<div class="nav-next"><?php next_posts_link(__('&larr; Older Entries', 'framework')) ?></div>
				<div class="nav-previous"><?php previous_posts_link(__('Newer Entries &rarr;', 'framework')) ?></div>
				<?php } ?>
			<!--END .navigation ,page-navigation -->
			</div>

			<?php else : ?>
				
				<h1 class="mainTitle"><?php _e('Your search did not match any entries','framework') ?></h1 >
				
				<!--BEGIN #post-0-->
				<div id="post-0" class="search-post">
					
					<!--BEGIN .entry-content-->
					<div class="entry-content">
						
                        <!--BEGIN #searchform-->
                        <form method="get" action="<?php echo home_url(); ?>/">
                            <div class="search-container">
                                <div class="search-inner clearfix">

                                    <input type="submit" class="searchsubmit" value="" />

                                    <div class="input">
                                        <input type="text" name="s" class="search-input" placeholder="<?php _e('Search for', 'framework'); ?>" />
                                    </div>

                                </div>
                            </div>
                        <!--END #searchform-->
                        </form>
                        
                        
						<p><?php _e('Suggestions:','framework') ?></p>
						<ul>
							<li><?php _e('Make sure all words are spelled correctly.', 'framework') ?></li>
							<li><?php _e('Try different keywords.', 'framework') ?></li>
							<li><?php _e('Try more general keywords.', 'framework') ?></li>
						</ul>
					<!--END .entry-content-->
					</div>
					
				<!--END #post-0-->
				</div>

			<?php endif; ?>
			<!--END #primary .hfeed-->
			</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>