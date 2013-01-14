							<!-- BEGIN #related-posts -->
							<div id="related-posts">
							
								<?php
								$backup = $post;  // backup the current object
								$tz_categories = get_the_category($post->ID);
								if ($tz_categories) {
									$tz_category_ids = array();
									foreach($tz_categories as $tz_individual_category) $tz_category_ids[] = $tz_individual_category->term_id;
								
									$args=array(
										'category__in' => $tz_category_ids,
										'post__not_in' => array($post->ID),
										'showposts'=>$tz_related_number, // Number of related posts that will be shown.
										'caller_get_posts'=>1
									);
									$tz_related_posts = new wp_query($args);
									if( $tz_related_posts->have_posts() ) { ?>
										<h3 class="widget-title"><?php _e('Related Posts', 'framework') ?></h3>
										<?php while ($tz_related_posts->have_posts()) {
											$tz_related_posts->the_post();
										?>
											<!-- BEGIN .post-container -->
											<div class="post-container clearfix">
											
												<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has post thumbnail */ ?>
												<div class="post-thumb">
													<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"><?php the_post_thumbnail('main-image'); /* post thumbnail settings configured in functions.php */ ?></a>
												</div>
												<?php } ?>
												
												<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'framework'), get_the_title()); ?>"> <?php the_title(); ?></a></h2>
												
												<!--BEGIN .entry-meta .entry-header-->
												<div class="entry-meta entry-header">
													<span class="published"><?php the_time( get_option('date_format') ); ?></span>
													<span class="meta-sep">&middot;</span>
													<span class="comment-count"><?php comments_popup_link(__('No comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span>
												<!--END .entry-meta entry-header -->
												</div>
												
												<!--BEGIN .entry-summary -->
												<div class="entry-summary">
													<p><?php content(20); ?></p>
												<!--END .entry-summary -->
												</div>
											
											<!-- END .post-container -->
											</div>
										<?php
										}
									}
								}
								$post = $backup;  // copy it back
 								 wp_reset_query(); // to use the original query again
								?>
							
							<!-- END #related-posts -->
							</div>