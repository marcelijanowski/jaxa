<?php include( get_template_directory() . '/functions/get-options.php' ); /* include theme options */ ?>

		<!-- END #content -->
		</div>
        
    <!-- END #container -->
	</div>
    
        <!-- BEGIN #footer -->
        <div id="footer">



            <!-- BEGIN #foot-inner -->
            <div id="foot-inner" class="clearfix">

                <div class="foot-widget-one">
                    <?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 1') ) ?>
                </div>

                <div class="foot-widget-two">
                    <?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 2') ) ?>
                </div>

                <div class="foot-widget-three">
                    <?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 3') ) ?>
                </div>

                <div class="foot-widget-four">
                    <?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 4') ) ?>
                </div>

            <!-- END #foot-inner -->
            </div>


        <!-- END #footer -->
        </div>
    
    </div>

    <!-- BEGIN #foot-notes -->
    <div id="foot-notes">

        <p class="copyright">&copy; <?php the_time( 'Y' ); ?> <?php echo $tz_footer_text; ?></p>

    <!-- END #foot-notes -->
    </div>
		
    <a id="backToTop" href="#container">&nbsp;</a>

		
	<!-- Theme Hook -->
	<?php wp_footer(); ?>
	
	<?php if ($tz_g_analytics) { /* if google analytics is set in theme options then show code */ echo stripslashes($tz_g_analytics); } ?>
			
<!--END body-->
</body>
<!--END html-->
</html>