<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include( get_template_directory() . '/functions/get-options.php' ); /* include theme options */ ?>

<!-- BEGIN html -->
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<!-- BEGIN head -->
<head profile="http://gmpg.org/xfn/11">

	<!-- Meta Tags -->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<!-- Title -->
	<title><?php if(is_home() || is_search() || is_front_page()) { bloginfo('name'); echo ' - '; bloginfo('description'); } else { wp_title('') ;} ?></title>	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo ($tz_favicon_url); ?>" />
	
    
    <link href='http://fonts.googleapis.com/css?family=Homenaje' rel='stylesheet' type='text/css'></link>
    
	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

    <?php if ($tz_background_image_show && !empty($tz_background_image_url )) { ?>
		<style type="text/css">
            body 
            { 
                background: url("<?php echo $tz_background_image_url; ?>") <?php echo $tz_background_fixation; ?> <?php echo $tz_background_position; ?> <?php echo $tz_background_repeat; ?>;
                <?php if (!empty($tz_background_color)) { ?>background-color: <?php echo $tz_background_color; ?>;<?php } else { ?>background-color: transparent;<?php } ?>
            
            }
        </style>
	<?php } ?>
    
	<!-- RSS, Atom & Pingbacks -->
	<?php if ($tz_feedburner) { /* if FeedBurner URL is set in theme options */ ?>
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php echo ($tz_feedburner); ?>" />
	<?php } else { /* if not then use the standard WP feed */ ?>
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<?php } ?>
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo( 'rss_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo( 'atom_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!-- Theme Hook -->
	<?php wp_enqueue_script("jquery"); /* load JQuery (modified to use Google over WP Bundle in functions.php) */ ?>
    <?php wp_enqueue_script("jquery-ui-core"); ?>
    <?php wp_enqueue_script("jquery-ui-widget", false, "jquery-ui-core"); ?>
    <?php wp_enqueue_script("jquery-ui-mouse", false, "jquery-ui-core"); ?>
    <?php wp_enqueue_script("jquery-effects-core", false, "jquery-ui-core"); ?>
    <?php wp_enqueue_script("jquery-easing", get_template_directory_uri() . '/js/jquery.easing.min.js', "jquery-ui"); ?>
    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); /* loads the javascript required for threaded comments */ ?>
	<?php wp_head(); ?>
	
	<!-- JS Scripts -->
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.placeholder.min.js"></script>
	
    <script type="text/javascript">
    //<![CDATA[

    jQuery(document).ready(function($) {

        // secondary navigation 
        $('#secondary-nav ul').superfish({ 
            delay: 100,
            animation: {opacity:'show'},
            speed: 'fast',
            autoArrows: false,
            dropShadows: false
        }); 

        // primary navigation
        $('#primary-nav ul').superfish({ 
            delay: 200,
            animation: {opacity:'show', height:'show'},
            speed: 'fast',
            autoArrows: false,
            dropShadows: false
        }); 

    });

    //]]>
    </script>
    
    
	<?php if ((is_page_template('template-homepage.php')) && ($tz_big_slider == "true")) { /* if we are on the template homepage */ ?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.min.js"></script>
    <script type="text/javascript">
    //<![CDATA[
    
    jQuery(document).ready(function($){

        $('#bigSliderWrap').cycle({ 
            fx:     'scrollHorz', 
            prev:   '#prevBigLink', 
            next:   '#nextBigLink', 
            slideExpr: '.item'
    <?php if ('true' != $tz_big_slider_autostart) : ?>, timeout: 0<?php endif; ?>
        });
    });
    //]]>
    </script>
	<?php } ?>
    
    
    
    <?php if ((is_page_template('template-homepage.php')) && ($tz_story_slider == "true")) { /* if we are on the template homepage */ ?>
    
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.carouFredSel-5.6.4-packed.js"></script>
    <script type="text/javascript">
    //<![CDATA[

        jQuery(document).ready(function() {
            jQuery("#storyCarousel").carouFredSel({
                circular : true,
                infinite : false,
                scroll : 3,
                width       : '990px',
                height      : '230px',
                auto :
                {
                    <?php if ('false' == $tz_story_slider_autostart) : ?>   play: false,
                <?php else : ?> play: true,
                <?php endif; ?>
                    duration : 1000
                },
                prev	: {	
                    button	: "#prevStoryLink",
                    key		: "left"
                },
                next	: { 
                    button	: "#nextStoryLink",
                    key		: "right"
                }
            });

        });

    //]]>
    </script>
	<?php } ?>
    

    

	
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.validate.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $("#contactForm").validate();
            $("#commentform").validate();

        });
    </script>
    
    <script type="text/javascript">

        jQuery(document).ready(function($){

            var $cols = $('colgroup');

            $('td').live('mouseover', function(){
                var i = $(this).prevAll('td').length;
                $(this).parent().addClass('hover')
                $($cols[i]).addClass('hover');

            }).live('mouseout', function(){
                var i = $(this).prevAll('td').length;
                $(this).parent().removeClass('hover');
                $($cols[i]).removeClass('hover');
            })

            $('table').mouseleave(function(){
                $cols.removeClass('hover');
            })

        });

    </script>
             
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.lavalamp.js" type="text/javascript"></script>
    <script type="text/javascript">

        // change to window load because of the font rendition delay
        (function($) {
            $(window).load(function() {
                
                $("#menu-primary-menu > li:last").addClass('last');

                $(".current-menu-item, .current-post-ancestor, .current-category-ancestor").addClass("current");
                $("#menu-primary-menu").lavaLamp({ fx: "backout", offset: 50, speed: 450, 'startItem' : 2 })

                $("#primary-nav > .main-menu > li:not(.current-menu-item)").mouseover(function(){
                    //$(this).children("a").addClass("hovered", 500)
                    $(this).siblings().filter(".current-menu-item").removeClass("current");
                }).mouseout(function(){
                    //$(this).children("a").removeClass("hovered", 500);
                    $(this).siblings().filter(".current-menu-item").addClass("current");
                });
            }) // document

        })(jQuery)

    </script>

    <script type="text/javascript">
    //<![CDATA[
        (function($) {
            $(document).ready(function(){
                
                $backToTop = $('#backToTop');

                // fade in #back-top
                $(function () {
                    $(window).scroll(function () {
                        if ($(this).scrollTop() > 100) {
                            $backToTop.fadeIn();
                        } else {
                            $backToTop.fadeOut();
                        }
                    });

                    // scroll body to 0px on click
                    $backToTop.click(function () {
                        $('body,html').animate({
                            scrollTop: 0
                        }, 800);
                        return false;
                    });
                });
                
                
            });
        })(jQuery)
    //]]>
    </script>




    <!-- fancy box : -->
    
    <!-- modified fancybox for navigation buttons not to flicker on transition -> 
    
        if (wrap.is(":visible")) { /*$( close.add( nav_left ).add( nav_right ) ).hide();*/  -->
    
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.fancybox.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/fancybox.css" media="screen" />

    <script type="text/javascript">
    //<![CDATA[

        function trimAll(sString)
        {
            while (sString.substring(0,1) == ' ')
            {
                sString = sString.substring(1, sString.length);
            }

            while (sString.substring(sString.length-1, sString.length) == ' ')
            {
                sString = sString.substring(0,sString.length-1);
            }
            return sString;
        } 

        function formatTitle(title, currentArray, currentIndex, currentOpts) {
            return (currentIndex + 1) + ' of ' + currentArray.length;
        }


        jQuery(window).load(function() {
            //jQuery(function($) {

            jQuery.fn.getTitle = function() {
                var arr = jQuery("a.fancybox");
                jQuery.each(arr, function() {
                    var title = jQuery(this).children("img").attr("alt");
                    title = trimAll(title);
                    jQuery(this).attr('title',title);
                })
            }

            // Supported file extensions
            var thumbnails = 'a:has(img)[href$=".bmp"],a:has(img)[href$=".gif"],a:has(img)[href$=".jpg"],a:has(img)[href$=".jpeg"],a:has(img)[href$=".png"],a:has(img)[href$=".BMP"],a:has(img)[href$=".GIF"],a:has(img)[href$=".JPG"],a:has(img)[href$=".JPEG"],a:has(img)[href$=".PNG"]';

            jQuery(thumbnails).addClass("fancybox").attr("rel","fancybox").getTitle();

            jQuery("a.fancybox").fancybox({
                'padding' :             0,
                'margin' :              80,
                'overlayColor' :        "#222528",
                'overlayOpacity' :      0.84,
                'enableEscapeButton' :  true,
                'showCloseButton' :     true,
                'hideOnOverlayClick' :  true,
                'hideOnContentClick' :  false,
                'titlePosition' :       'outside',
                'centerOnScroll' :      true,
                'transitionIn' :        'fade',
                'transitionIn' :        'fade',
                'titleFormat' :         formatTitle,
                'cyclic' :              true
            });

        });

    //]]>
    </script>
    <!-- : -->


    <script type="text/javascript">
    //<![CDATA[

        // search bar autogrow
        (function($) {

            $(document).ready(function(){

                var searchBar = $('#searchform');
                var input = searchBar.find('input#s');
                var divInput = searchBar.find('div.input');
                var width = divInput.width();
                var outerWidth = divInput.parent().width() - (divInput.outerWidth() - width) - 50;
                var txt = input.val();

                input.on('focus', function(){
                    if(input.val() === txt) {
                        input.val('');
                    }
                    $(this).parent().animate({
                        width: outerWidth + 'px'
                    }, 300).addClass('focus');
                }).on('blur', function() {
                    $(this).parent().animate({
                        width: width + 'px'
                    }, 300, function() {
                        if(input.val() === '') {
                            input.val(txt)
                        }
                    }).removeClass('focus');
                });
            });
        })(jQuery)
    //]]>
    </script>


    <script type="text/javascript">
    //<![CDATA[

        // add hasChildren class to main menu items
        (function($) {
            $(document).ready(function(){
                var $menuItems = $('#menu-primary-menu > li');
                $menuItems.each(function(index){
                    var $this = $(this);
                    if (($this.has("li").length))
                    {
                        $this.addClass('hasChildren');
                    }
                });
            });
        })(jQuery)
    //]]>
    </script>
    
    
    <!--[if (gte IE 6)&(lte IE 8)]>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/selectivizr.js"></script>
    <![endif]--> 
	
    
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/<?php echo ($tz_theme_stylesheet); ?>" type="text/css" media="screen" />
	
	<!--[if lt IE 8]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/ie8.js"></script>
 <script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"></script>
	<![endif]-->
	
	<!--[if IE 6]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/DD_belatedPNG.js"></script>
		<script> DD_belatedPNG.fix('img'); </script>
	<![endif]--> 

<!-- END head -->
</head>

<!-- BEGIN body -->
<body <?php body_class(); ?>>

	<!-- BEGIN .container -->
	<div class="container">
	
		<!-- BEGIN .header -->
		<div id="header" class="clearfix">
			
            <div class="headerWrap">
    
                <div id="logo">
                    <?php
                    if ($tz_plain_logo == "true") { ?>
                    <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
                    <?php } elseif ($tz_logo_url) { ?>
                    <a href="<?php echo home_url(); ?>"><img src="<?php echo ($tz_logo_url); ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
                    <?php } ?>
                </div>
                
                <div id="tagline"><?php bloginfo( 'description' ); ?></div>
                
              
                
			

            </div>
	
            <!-- BEGIN #primary-nav -->
            <div id="primary-nav" class="rounded">
                <?php if ( has_nav_menu( 'primary-menu' ) ) { /* if menu location 'primary-menu' exists then use custom menu */ ?>
                <?php wp_nav_menu( array( 'theme_location' => 'primary-menu' ) ); ?>
                <?php } else { /* else use wp_list_categories */ ?>
                <ul class="main-menu">
                    <?php wp_list_categories( array( 'exclude' => $tz_primary_nav_exclude, 'title_li' => '' )); ?>
                </ul>
                <?php } ?>
            <!-- END #primary-nav -->
            </div>
            
            
		<!--END .header-->
		</div>
		

		
        <?php $page_id = $wp_query->get_queried_object_id(); ?>
        <?php if (get_post_meta( $page_id, '_wp_page_template', true ) !== 'template-homepage.php') : ?>
        
		<!--BEGIN #content -->
		<div id="content" class="clearfix">
	
        <?php endif; ?>