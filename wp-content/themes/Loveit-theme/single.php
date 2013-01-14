<?php get_header(); ?>
<?php /* include theme options */ include( get_template_directory() . '/functions/get-options.php' ); ?>

			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
                
                <div class="wrap">
                
                <?php if( function_exists('bcn_display')) : echo '<p class="breadcrumb">'; bcn_display(); echo '</p>'; endif; ?>
                
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <!--BEGIN .hentry -->
                    <div <?php post_class() ?> id="post-<?php the_ID(); ?>">

                        <h1 class="mainTitle"><?php the_title(); ?></h1>

                        <div class="entry-meta entry-header">
                            <span class="author"><?php the_author_posts_link(); ?></span>
                            <span class="published"><?php the_time( get_option('date_format') ); ?></span>
                            <?php edit_post_link( __('edit', 'framework'), '<span class="edit-post">[', ']</span>' ); ?>
                        </div>

                        
                        <?php if ( !has_post_format( 'gallery' )) : ?>
                        
                            <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
                            <div class="post-thumb">
                                <?php the_post_thumbnail('lead-image'); ?>
                            </div>
                            <?php } ?>
                        
                        <?php endif; ?>

                        <!--BEGIN .entry-content -->
                        <div class="entry-content">
                            <?php the_content(__('Read more...', 'framework')); ?>
                            <?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'framework').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
                        <!--END .entry-content -->
                        </div>

                        <?php if ($tz_show_related == "true") { ?>
                        <?php include( get_template_directory() . '/includes/related-posts.php' ); ?>
                        <?php } ?>

                    
                    <?php if ($tz_sharing_enable == "true") { /* Display 468x60 banner if checked in theme options */ ?>
                        <ul class="share">




                            <?php if ($tz_enable_pinterest == "true") { /* Display Pinterest link if checked in theme options */ ?>
                            <li class="pinterest">
                                <script type="text/javascript">
                                    (function() {
                                        window.PinIt = window.PinIt || { loaded:false };
                                        if (window.PinIt.loaded) return;
                                        window.PinIt.loaded = true;
                                        function async_load(){
                                            var s = document.createElement("script");
                                            s.type = "text/javascript";
                                            s.async = true;
                                            s.src = "http://assets.pinterest.com/js/pinit.js";
                                            var x = document.getElementsByTagName("script")[0];
                                            x.parentNode.insertBefore(s, x);
                                        }
                                        if (window.attachEvent)
                                            window.attachEvent("onload", async_load);
                                        else
                                            window.addEventListener("load", async_load, false);
                                    })();
                                </script>
                                <?php $pinterestimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($post->ID)); ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php the_title(); ?>" class="pin-it-button" count-layout="none"></a>
                            </li>
                            <?php } ?>

                            <?php if ($tz_enable_twitter == "true") { /* Display Twitter link if checked in theme options */ ?>
                            <li class="tweet">
                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                                <a href="https://twitter.com/share" class="twitter-share-button" data-count="none"></a>
                            </li>
                            <?php } ?>



                            <?php if ($tz_enable_gplusone == "true") { /* Display Google +1 link if checked in theme options */ ?>
                            <li class="gplusone">
                                <script type="text/javascript">
                                  window.___gcfg = {lang: 'en-GB'};
                                  (function() {
                                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                    po.src = 'https://apis.google.com/js/plusone.js';
                                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                  })();
                                </script>
                                <g:plusone size="medium" annotation="none"></g:plusone>
                            </li>
                            <?php } ?>

                            <?php if ($tz_enable_fb == "true") { /* Display Facebook link if checked in theme options */ ?>
                            <li class="fb"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>?t=<?php the_title(); ?>" title="<?php _e('Post to Facebook', 'framework'); ?>" target="_blank"><?php _e('Post to Facebook', 'framework'); ?></a></li>
                            <?php } ?>

                            <?php if ($tz_enable_fblike == "true") { /* Display Facebook Like link if checked in theme options */ ?>
                            <li class="fblike">
                                <iframe src="//www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;send=false&amp;layout=button_count&amp;width=140&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=154641754625041" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:140px; height:21px;" allowTransparency="true"></iframe>
                            </li>
                            <?php } ?>

                            <?php if ($tz_enable_stumble == "true") { /* Display Stumble link if checked in theme options */ ?>
                            <li class="stumble">
                                <script type="text/javascript"> 
                                    (function() { 
                                        var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true; 
                                        li.src = window.location.protocol + '//platform.stumbleupon.com/1/widgets.js'; 
                                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s); 
                                    })();
                                </script>
                                <su:badge layout="4"></su:badge>
                                <span><?php _e('Stumble this', 'framework'); ?></span>
                            </li>
                            <?php } ?>

                            <?php if ($tz_enable_tumblr == "true") { /* Display Tumblr link if checked in theme options */ ?>
                            <li class="tumblr">
                                <script type="text/javascript" src="http://platform.tumblr.com/v1/share.js"></script>
                                <a href="http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink($post->ID)); ?>&name=<?php the_title(); ?>" title="<?php _e('Share on Tumblr', 'framework'); ?>"><?php _e('Share on Tumblr', 'framework'); ?></a>
                            </li>
                            <?php } ?>

                            <?php if ($tz_enable_digg == "true") { /* Display Digg link if checked in theme options */ ?>
                            <li class="digg"><a href="http://digg.com/submit?url=<?php the_permalink();?>&amp;title=<?php the_title(); ?>&amp;thumbnails=1" title="<?php _e('Digg this', 'framework'); ?>" target="_blank"><?php _e('Digg this', 'framework'); ?></a></li>
                            <?php } ?>

                            <?php if ($tz_enable_reddit == "true") { /* Display Reddit link if checked in theme options */ ?>
                            <li class="reddit"><a href="http://www.reddit.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" title="<?php _e('Share on Reddit', 'framework'); ?>" target="_blank"><?php _e('Share on Reddit', 'framework'); ?></a></li>
                            <?php } ?>

                            <?php if ($tz_enable_del == "true") { /* Display Deliciouos link if checked in theme options */ ?>
                            <li class="del"><a href="http://del.icio.us/post?url=<?php the_permalink();?>&amp;title=<?php the_title(); ?>" title="<?php _e('Add To Delicious', 'framework'); ?>" target="_blank"><?php _e('Add To Delicious', 'framework'); ?></a></li>
                            <?php } ?>

                            <?php if ($tz_enable_techno == "true") { /* Display Technorati link if checked in theme options */ ?>
                            <li class="techno"><a href="http://technorati.com/signup/?f=favorites&amp;Url=<?php the_permalink(); ?>" title="<?php _e('Post to Technorati', 'framework'); ?>" target="_blank"><?php _e('Post to Technorati', 'framework'); ?></a></li>
                            <?php } ?>

                            <?php if ($tz_enable_linkedin == "true") { /* Display Linkedin link if checked in theme options */ ?>
                            <li class="linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;source="  title="<?php _e('Share on LinkedIn', 'framework'); ?>" target="_blank"><?php _e('Share on LinkedIn', 'framework'); ?></a></li>
                            <?php } ?>

                            <?php if ($tz_enable_xing == "true") { /* Display Xing link if checked in theme options */ ?>
                            <li class="xing"><a href="https://www.xing.com/app/user?op=share&amp;url=<?php the_permalink(); ?>;title=<?php the_title(); ?>"  title="<?php _e('Share on XING', 'framework'); ?>" target="_blank"><?php _e('Share on XING', 'framework'); ?></a></li>
                            <?php } ?>

                            <?php if ($tz_enable_flattr == "true") { /* Display Flattr link if checked in theme options */ ?>
                            <li class="flattr">
                                <a href="https://flattr.com/donation/give/to/<?php echo $tz_flattr_id; ?>" title="<?php _e('Support us via Flattr', 'framework'); ?>" target="_blank"><?php _e('Support us via Flattr', 'framework'); ?></a>
                            </li>
                            <?php } ?>


                            <?php if ($tz_enable_email == "true") { /* Display email link if checked in theme options */ ?>
                            <li class="email"><a href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>" title="<?php _e('Email a friend', 'framework'); ?>"><?php _e('Email a friend', 'framework'); ?></a></li>
                            <?php } ?>

                        </ul>
                    <?php } ?>	



                    <!--END .hentry-->  
                    </div>
                    
                </div>
                
                <?php 
                $att_gallery = get_post_meta($post->ID, 'att_gallery', true); 
                
                if (!empty($att_gallery)) 
                {
                
                    if (function_exists('banesto_attached_gallery_block'))
                    {
                        banesto_attached_gallery_block($att_gallery);
                    }
                
                }
                ?>

				<?php comments_template('', true); ?>
				
				<?php endwhile; else: ?>

				<!--BEGIN #post-0-->
				<div id="post-0" <?php post_class() ?>>
				
					<h1 class="entry-title"><?php _e('Error 404 - Not Found', 'framework') ?></h1>
				
					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e("Sorry, but you are looking for something that isn't here.", "framework") ?></p>
						<?php get_search_form(); ?>
					<!--END .entry-content-->
					</div>
				
				<!--END #post-0-->
				</div>

			<?php endif; ?>
			<!--END #primary .hfeed-->
			</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>