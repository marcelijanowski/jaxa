<?php
function my_init() {
	if (is_admin()) {
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-accordion');
        
		wp_register_script('tabs', get_template_directory_uri().'/functions/tabs.js');
		wp_enqueue_script('tabs');
		wp_register_style('theme-options', get_template_directory_uri().'/functions/theme-options.css');
		wp_enqueue_style('theme-options');
	}
}
add_action('init', 'my_init');

$categories = get_categories('hide_empty=0&orderby=name');  
$tz_wp_cats = array('0' => "Choose a category");  
foreach ($categories as $category_list ) 
{  
    $tz_wp_cats[$category_list->cat_ID] = $category_list->cat_name;  
}

$psot_list_args = array( 
    'numberposts' => -1, 
    'order'=> 'DESC', 
    'orderby' => 'post_date',
    'post_status' => 'publish'
);
$post_list = get_posts($psot_list_args); 

$big_slider_orders = range(1,5);
$category_block_orders = range(1,4);
$follow_us_orders = range(1,5);

$tz_wp_posts = array('0' => "Choose a post");  
foreach ($post_list as $post_item ) 
{  
    $tz_wp_posts[$post_item->ID] = $post_item->post_title;  
}
    
    



// ==========================//
//             Start the theme options!                  //
// ==========================//

$themename = "Deadline";
$shortname = "tz";

$options = array(
    array("name" => __("selected", 'framework'),
        "id" => $shortname . "_selectedtab",
        "std" => "",
        "type" => "hidden"),
    array("type" => "opentab"),
    array("type" => "open"),
    array("name" => __('Colour Schemes', 'framework'),
        "id" => $shortname . "_colour_settings",
        "type" => "title"),
    array("name" => __('Theme Stylesheet', 'framework'),
        "desc" => __('Select a colour scheme for your site.', 'framework'),
        "id" => $shortname . "_theme_stylesheet",
        "std" => "default.css",
        "type" => "select",
        "options" => array("default.css")),
    array("type" => "close"),
    array("type" => "open"),
    array("name" => __('Logo and Favicon Settings', 'framework'),
        "id" => $shortname . "_logo_settings",
        "type" => "title"),
    array("name" => __("Upload Logo", 'framework'),
        "desc" => __("Enter the full URL of an image you would like to use as a logo e.g http://www.example.com/logo.png", 'framework'),
        "id" => $shortname . "_logo_url",
        "std" => "",
        "type" => "file"),
    array("name" => __("Enable plain text logo", 'framework'),
        "desc" => __("Check this box to use a plain text logo rather than an image. Info will be taken from your WordPress settings.", 'framework'),
        "id" => $shortname . "_plain_logo",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Favicon URL", 'framework'),
        "desc" => __("Enter the full URL of your favicon e.g. http://www.example.com/favicon.ico", 'framework'),
        "id" => $shortname . "_favicon_url",
        "std" => get_template_directory_uri() . "/favicon.ico",
        "type" => "file"),
    array("type" => "close"),
    
    
    array("type" => "open"),
    array("name" => __("Background Settings", 'framework'),
        "id" => $shortname . "_background_settings",
        "type" => "title"),
    array("name" => __("Upload Background Image", 'framework'),
        "desc" => __("Enter the full URL of an image you would like to use as a background image e.g http://www.example.com/logo.png", 'framework'),
        "id" => $shortname . "_background_image_url",
        "std" => "",
        "type" => "file"),
    array("name" => __("Show Background Image", 'framework'),
        "desc" => __("Check this to show a background image", 'framework'),
        "id" => $shortname . "_background_image_show",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __('Background position', 'framework'),
        "desc" => __('Select a background position.', 'framework'),
        "id" => $shortname . "_background_position",
        "std" => "center top",
        "type" => "select",
        "options" => array("left top", "center top", "right top", "left bottom", "center bottom", "right bottom")),
    array("name" => __('Background repeat', 'framework'),
        "desc" => __('Select a background repeat type.', 'framework'),
        "id" => $shortname . "_background_repeat",
        "std" => "repeat",
        "type" => "select",
        "options" => array("repeat", "repeat-x", "repeat-y", "no-repeat")),
    array("name" => __('Background fixation', 'framework'),
        "desc" => __('Chose if background should be fixed or scrollable.', 'framework'),
        "id" => $shortname . "_background_fixation",
        "std" => "fixed",
        "type" => "select",
        "options" => array("fixed", "scroll")),
    array("name" => __("Background color", 'framework'),
        "desc" => __("Define background color in HEX, starting with '#'. Leave blank for transparent.", 'framework'),
        "id" => $shortname . "_background_color",
        "std" => "",
        "type" => "text"),
    array("type" => "close"),
    
    array("type" => "open"),
    array("name" => __("Category settings", 'framework'),
        "id" => $shortname . "_category_settings",
        "type" => "title"),
    array("name" => __("Blog Category", 'framework'),
        "desc" => "Choose a category for blog",
        "id" => $shortname . "_blog_category",
        "type" => "select",
        "options" => $tz_wp_cats,
        "keysAsValue" => true,
        "std" => ""),
    array("name" => __("Portfolio Category", 'framework'),
        "desc" => "Choose a category for portfolio",
        "id" => $shortname . "_portfolio_category",
        "type" => "select",
        "options" => $tz_wp_cats,
        "keysAsValue" => true,
        "std" => ""),
    array("type" => "close"),
    array("type" => "open"),
    array("name" => __("Footer Text", 'framework'),
        "id" => $shortname . "_footer_settings",
        "type" => "title"),
    array("name" => __("Footer text", 'framework'),
        "desc" => __("Enter text which will be displayed right after copyright sign and year in the page footer.", 'framework'),
        "id" => $shortname . "_footer_text",
        "std" => "",
        "type" => "textarea"),
    array("type" => "close"),
    array("type" => "open"),
    array("name" => __("Analytics Settings", 'framework'),
        "id" => $shortname . "_analytics",
        "type" => "title"),
    array("name" => __("Google Analytics Code", 'framework'),
        "desc" => __("Enter your full Google Analytics code (or any other site tracking code) here. It will be inserted before the closing body tag.", 'framework'),
        "id" => $shortname . "_g_analytics",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("FeedBurner URL", 'framework'),
        "desc" => __("Enter your full FeedBurner URL (or any other preferred feed URL) if you wish to use FeedBurner over the standard WordPress Feed e.g. http://feeds.feedburner.com/yoururlhere", 'framework'),
        "id" => $shortname . "_feedburner",
        "std" => "http://feeds.feedburner.com/themiac",
        "type" => "text"),
    array("name" => __("FeedBurner Email URL", 'framework'),
        "desc" => __("Enter your full FeedBurner email URL if you wish to enable users to subscribe to posts by email e.g. http://feedburner.google.com/fb/a/mailverify?uri=usernamehere", 'framework'),
        "id" => $shortname . "_feedburner_email",
        "std" => "http://feedburner.google.com/fb/a/mailverify?uri=themiac",
        "type" => "text"),
    array("type" => "close"),
    array("type" => "closetab"),
    
    array("type" => "opentab"),
    array("type" => "open"),
    array("name" => __('Contact form settings', 'framework'),
        "id" => $shortname . "_form_settings",
        "type" => "title"),
    array("name" => __("Email adress", 'framework'),
        "desc" => __("Enter the email adress where you'd like to receive emails from the contact form, or leave blank to use admin email.", 'framework'),
        "id" => $shortname . "_email",
        "std" => "",
        "type" => "text"),
    
    array("name" => __("Adress", 'framework'),
        "desc" => __("Enter address which will be publicly visible on contacts page.", 'framework'),
        "id" => $shortname . "_contact_address",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Contact Phone Number", 'framework'),
        "desc" => __("Enter your full phone number which will be publicly visible on contacts page.", 'framework'),
        "id" => $shortname . "_contact_phone",
        "std" => "",
        "type" => "text"),
    array("name" => __("Contact Email", 'framework'),
        "desc" => __("Enter your email which will be publicly visible on contacts page.", 'framework'),
        "id" => $shortname . "_contact_email",
        "std" => "",
        "type" => "text"),
    array("name" => __("Google Map Coordinates - Latitude", 'framework'),
        "desc" => __("Enter your office google map coordinate latitude e.g. '23.344'", 'framework'),
        "id" => $shortname . "_contact_gmap_lat",
        "std" => "",
        "type" => "text"),
    array("name" => __("Google Map Coordinates - Longitude", 'framework'),
        "desc" => __("Enter your office google map coordinate longitude e.g. '12.342'", 'framework'),
        "id" => $shortname . "_contact_gmap_lng",
        "std" => "",
        "type" => "text"),
    
    
    
    array("name" => __("Enable Captcha", 'framework'),
        "desc" => __("Check this to enable a captcha", 'framework'),
        "id" => $shortname . "_captcha_select",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Public key", 'framework'),
        "desc" => __("Enter your public key. https://www.google.com/recaptcha/admin/create", 'framework'),
        "id" => $shortname . "_public_key",
        "std" => "",
        "type" => "text"),
    array("name" => __("Private key", 'framework'),
        "desc" => __("Enter your private key. https://www.google.com/recaptcha/admin/create", 'framework'),
        "id" => $shortname . "_private_key",
        "std" => "",
        "type" => "text"),
    array("name" => __('Look and feel', 'framework'),
        "desc" => __('Select a colour scheme for your captcha.', 'framework'),
        "id" => $shortname . "_captcha_theme",
        "std" => "clean",
        "type" => "select",
        "options" => array("clean", "white", "blackglass", "red")),
    array("type" => "close"),
    array("type" => "closetab"),
    
    
    
    array("type" => "opentab"),
    
    array("type" => "open"),
    array("name" => __("Big Slider", 'framework'),
        "id" => $shortname . "_big_slider_settings",
        "type" => "title"),
    array("name" => __("Enable Big Slider", 'framework'),
        "desc" => __("Check this to show big slider", 'framework'),
        "id" => $shortname . "_big_slider",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Enable Autostart", 'framework'),
        "desc" => __("Check this to enable autoscrolling", 'framework'),
        "id" => $shortname . "_big_slider_autostart",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Big Slider Image 1", 'framework'),
        "id" => $shortname . "_big_slider_1_image_url",
        "std" => "",
        "type" => "file"),
    array("name" => __("Big Slider Image 1 Position", 'framework'),
        "desc" => "Choose image position",
        "id" => $shortname . "_big_slider_1_image_position",
        "type" => "select",
        "options" => array('left', 'center', 'right'),
        "std" => "center"),
    array("name" => __("Big Slider Text 1", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_big_slider_1_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Big Slider Link 1", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_big_slider_1_url",
        "std" => "",
        "type" => "text"),
    array("name" => __('Big Slide 1 Order nr.', 'framework'),
        "desc" => __('Select order number for this slide.', 'framework'),
        "id" => $shortname . "_big_slider_1_order",
        "std" => "1",
        "type" => "select",
        "options" => $big_slider_orders),
    array("name" => __("Show Slide 1", 'framework'),
        "desc" => __("Check this to show this slide", 'framework'),
        "id" => $shortname . "_big_slider_1_show",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Big Slider Image 2", 'framework'),
        "id" => $shortname . "_big_slider_2_image_url",
        "std" => "",
        "type" => "file"),
    array("name" => __("Big Slider Image 2 Position", 'framework'),
        "desc" => "Choose image position",
        "id" => $shortname . "_big_slider_2_image_position",
        "type" => "select",
        "options" => array('left', 'center', 'right'),
        "std" => "center"),
    array("name" => __("Big Slider Text 2", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_big_slider_2_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Big Slider Link 2", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_big_slider_2_url",
        "std" => "",
        "type" => "text"),
    array("name" => __('Big Slide 2 Order nr.', 'framework'),
        "desc" => __('Select order number for this slide.', 'framework'),
        "id" => $shortname . "_big_slider_2_order",
        "std" => "2",
        "type" => "select",
        "options" => $big_slider_orders),
    array("name" => __("Show Slide 2", 'framework'),
        "desc" => __("Check this to show this slide", 'framework'),
        "id" => $shortname . "_big_slider_2_show",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Big Slider Image 3", 'framework'),
        "id" => $shortname . "_big_slider_3_image_url",
        "std" => "",
        "type" => "file"),
    array("name" => __("Big Slider Image 3 Position", 'framework'),
        "desc" => "Choose image position",
        "id" => $shortname . "_big_slider_3_image_position",
        "type" => "select",
        "options" => array('left', 'center', 'right'),
        "std" => "center"),
    array("name" => __("Big Slider Text 3", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_big_slider_3_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Big Slider Link 3", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_big_slider_3_url",
        "std" => "",
        "type" => "text"),
    array("name" => __('Big Slide 3 Order nr.', 'framework'),
        "desc" => __('Select order number for this slide.', 'framework'),
        "id" => $shortname . "_big_slider_3_order",
        "std" => "3",
        "type" => "select",
        "options" => $big_slider_orders),
    array("name" => __("Show Slide 3", 'framework'),
        "desc" => __("Check this to show this slide", 'framework'),
        "id" => $shortname . "_big_slider_3_show",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Big Slider Image 4", 'framework'),
        "id" => $shortname . "_big_slider_4_image_url",
        "std" => "",
        "type" => "file"),
    array("name" => __("Big Slider Image 4 Position", 'framework'),
        "desc" => "Choose image position",
        "id" => $shortname . "_big_slider_4_image_position",
        "type" => "select",
        "options" => array('left', 'center', 'right'),
        "std" => "center"),
    array("name" => __("Big Slider Text 4", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_big_slider_4_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Big Slider Link 4", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_big_slider_4_url",
        "std" => "",
        "type" => "text"),
    array("name" => __('Big Slide 4 Order nr.', 'framework'),
        "desc" => __('Select order number for this slide.', 'framework'),
        "id" => $shortname . "_big_slider_4_order",
        "std" => "4",
        "type" => "select",
        "options" => $big_slider_orders),
    array("name" => __("Show Slide 4", 'framework'),
        "desc" => __("Check this to show this slide", 'framework'),
        "id" => $shortname . "_big_slider_4_show",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Big Slider Image 5", 'framework'),
        "id" => $shortname . "_big_slider_5_image_url",
        "std" => "",
        "type" => "file"),
    array("name" => __("Big Slider Image 5 Position", 'framework'),
        "desc" => "Choose image position",
        "id" => $shortname . "_big_slider_5_image_position",
        "type" => "select",
        "options" => array('left', 'center', 'right'),
        "std" => "center"),
    array("name" => __("Big Slider Text 5", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_big_slider_5_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Big Slider Link 5", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_big_slider_5_url",
        "std" => "",
        "type" => "text"),
    array("name" => __('Big Slide 5 Order nr.', 'framework'),
        "desc" => __('Select order number for this slide.', 'framework'),
        "id" => $shortname . "_big_slider_5_order",
        "std" => "5",
        "type" => "select",
        "options" => $big_slider_orders),
    array("name" => __("Show Slide 5", 'framework'),
        "desc" => __("Check this to show this slide", 'framework'),
        "id" => $shortname . "_big_slider_5_show",
        "std" => "",
        "type" => "checkbox"),
    array("type" => "close"),
    
    array("type" => "open"),
    array("name" => __("Story Slider", 'framework'),
        "id" => $shortname . "_story_slider_settings",
        "type" => "title"),
    
    array("name" => __("Enable Story Slider", 'framework'),
        "desc" => __("Check this to show the story slider section.", 'framework'),
        "id" => $shortname . "_story_slider",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Enable Autostart", 'framework'),
        "desc" => __("Check this to enable autoscrolling on the news in images section", 'framework'),
        "id" => $shortname . "_story_slider_autostart",
        "std" => "",
        "type" => "checkbox"),
    
    array("name" => __("Story 1 Title", 'framework'),
        "desc" => __("Enter the title", 'framework'),
        "id" => $shortname . "_story_1_title",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 1 Text", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_story_1_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Story 1 Link", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_story_1_url",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 2 Title", 'framework'),
        "desc" => __("Enter the title", 'framework'),
        "id" => $shortname . "_story_2_title",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 2 Text", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_story_2_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Story 2 Link", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_story_2_url",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 3 Title", 'framework'),
        "desc" => __("Enter the title", 'framework'),
        "id" => $shortname . "_story_3_title",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 3 Text", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_story_3_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Story 3 Link", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_story_3_url",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 4 Title", 'framework'),
        "desc" => __("Enter the title", 'framework'),
        "id" => $shortname . "_story_4_title",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 4 Text", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_story_4_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Story 4 Link", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_story_4_url",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 5 Title", 'framework'),
        "desc" => __("Enter the title", 'framework'),
        "id" => $shortname . "_story_5_title",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 5 Text", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_story_5_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Story 5 Link", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_story_5_url",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 6 Title", 'framework'),
        "desc" => __("Enter the title", 'framework'),
        "id" => $shortname . "_story_6_title",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 6 Text", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_story_6_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Story 6 Link", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_story_6_url",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 7 Title", 'framework'),
        "desc" => __("Enter the title", 'framework'),
        "id" => $shortname . "_story_7_title",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 7 Text", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_story_7_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Story 7 Link", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_story_7_url",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 8 Title", 'framework'),
        "desc" => __("Enter the title", 'framework'),
        "id" => $shortname . "_story_8_title",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 8 Text", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_story_8_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Story 8 Link", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_story_8_url",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 9 Title", 'framework'),
        "desc" => __("Enter the title", 'framework'),
        "id" => $shortname . "_story_9_title",
        "std" => "",
        "type" => "text"),
    array("name" => __("Story 9 Text", 'framework'),
        "desc" => __("Enter the text", 'framework'),
        "id" => $shortname . "_story_9_text",
        "std" => "",
        "type" => "textarea"),
    array("name" => __("Story 9 Link", 'framework'),
        "desc" => __("Enter the link url", 'framework'),
        "id" => $shortname . "_story_9_url",
        "std" => "",
        "type" => "text"),
    array("type" => "close"),
    
    array("type" => "open"),
    array("name" => __("Recent Posts", 'framework'),
        "id" => $shortname . "_recent_posts_settings",
        "type" => "title"),
    array("name" => __("Show recent posts block", 'framework'),
        "desc" => __("Check to enable recent post block", 'framework'),
        "id" => $shortname . "_recent_posts",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Check posts manually", 'framework'),
        "desc" => __("Show specifically assigned posts rather than latest", 'framework'),
        "id" => $shortname . "_recent_manual",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Recent Post Categories (to show posts only from certain categories)", 'framework'),
        "desc" => __("Enter category ID's (with minus sign for exclusion) and delimite them by comma, eg. -13,6", 'framework'),
        "id" => $shortname . "_recent_cats",
        "std" => "",
        "type" => "text"),
    array("name" => __("Recent Post 1", 'framework'),
        "desc" => "Choose a post from the list",
        "id" => $shortname . "_recent_1",
        "type" => "select",
        "keysAsValue" => true,
        "options" => $tz_wp_posts,
        "std" => ""),
    array("name" => __("Recent Post 2", 'framework'),
        "desc" => "Choose a post from the list",
        "id" => $shortname . "_recent_2",
        "type" => "select",
        "keysAsValue" => true,
        "options" => $tz_wp_posts,
        "std" => ""),
    array("name" => __("Recent Post 3", 'framework'),
        "desc" => "Choose a post from the list",
        "id" => $shortname . "_recent_3",
        "type" => "select",
        "keysAsValue" => true,
        "options" => $tz_wp_posts,
        "std" => ""),
    array("type" => "close"),
    
    array("type" => "open"),
    array("name" => __("Category Blocks", 'framework'),
        "id" => $shortname . "_category_blocks",
        "type" => "title"),
    array("name" => __("Enable Category Block 1", 'framework'),
        "desc" => __("Check this to enable the category block 1", 'framework'),
        "id" => $shortname . "_cat_1",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Category Block 1 Category", 'framework'),
        "desc" => "Choose a category for 'block one' from which the posts are displayed",
        "id" => $shortname . "_cat_1_select",
        "type" => "select",
        "options" => $tz_wp_cats,
        "keysAsValue" => true,
        "std" => ""),
    array("name" => __('Category Block 1 Order nr.', 'framework'),
        "desc" => __('Select order number for this category block.', 'framework'),
        "id" => $shortname . "_cat_1_order",
        "std" => "1",
        "type" => "select",
        "options" => $category_block_orders),
    array("name" => __("Enable Category Block 2", 'framework'),
        "desc" => __("Check this to enable the category block 2", 'framework'),
        "id" => $shortname . "_cat_2",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Category Block 2 Category", 'framework'),
        "desc" => "Choose a category for 'block one' from which the posts are displayed",
        "id" => $shortname . "_cat_2_select",
        "type" => "select",
        "options" => $tz_wp_cats,
        "keysAsValue" => true,
        "std" => ""),
    array("name" => __('Category Block 2 Order nr.', 'framework'),
        "desc" => __('Select order number for this category block.', 'framework'),
        "id" => $shortname . "_cat_2_order",
        "std" => "2",
        "type" => "select",
        "options" => $category_block_orders),
    array("name" => __("Enable Category Block 3", 'framework'),
        "desc" => __("Check this to enable the category block 3", 'framework'),
        "id" => $shortname . "_cat_3",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Category Block 3 Category", 'framework'),
        "desc" => "Choose a category for 'block one' from which the posts are displayed",
        "id" => $shortname . "_cat_3_select",
        "type" => "select",
        "options" => $tz_wp_cats,
        "keysAsValue" => true,
        "std" => ""),
    array("name" => __('Category Block 3 Order nr.', 'framework'),
        "desc" => __('Select order number for this category block.', 'framework'),
        "id" => $shortname . "_cat_3_order",
        "std" => "3",
        "type" => "select",
        "options" => $category_block_orders),
    array("name" => __("Enable Category Block 4", 'framework'),
        "desc" => __("Check this to enable the category block 4", 'framework'),
        "id" => $shortname . "_cat_4",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Category Block 4 Category", 'framework'),
        "desc" => "Choose a category for 'block one' from which the posts are displayed",
        "id" => $shortname . "_cat_4_select",
        "type" => "select",
        "options" => $tz_wp_cats,
        "keysAsValue" => true,
        "std" => ""),
    array("name" => __('Category Block 4 Order nr.', 'framework'),
        "desc" => __('Select order number for this category block.', 'framework'),
        "id" => $shortname . "_cat_4_order",
        "std" => "4",
        "type" => "select",
        "options" => $category_block_orders),
    array("type" => "close"),
    
    array("type" => "open"),
    array("name" => __("Gallery Blocks", 'framework'),
        "id" => $shortname . "_gallery_block_settings",
        "type" => "title"),
    array("name" => __("Display Gallery Posts", 'framework'),
        "desc" => __("Check this to display gallery posts block", 'framework'),
        "id" => $shortname . "_gallery_posts",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Gallery Post Count", 'framework'),
        "desc" => "Choose a number of posts to display",
        "id" => $shortname . "_gallery_number",
        "type" => "select",
        "options" => array(4,8,12,16),
        "std" => 4),
    array("type" => "close"),
    
    array("type" => "open"),
    array("name" => __("Bottom Block", 'framework'),
        "id" => $shortname . "_bottom_posts_settings",
        "type" => "title"),
    array("name" => __("Display Bottom Posts", 'framework'),
        "desc" => __("Check this to display bottom posts block", 'framework'),
        "id" => $shortname . "_bottom_posts",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("Bottom Posts Excluded Categories", 'framework'),
        "desc" => __("Enter category ID's and delimite them by comma, eg. 13,6", 'framework'),
        "id" => $shortname . "_bottom_cats_exluded",
        "std" => "",
        "type" => "text"),
    array("name" => __("Bottom Post Count", 'framework'),
        "desc" => "Choose a number of posts to display",
        "id" => $shortname . "_bottom_number",
        "type" => "select",
        "options" => array(4,6,8,10,12,14,16),
        "std" => 6),
    array("name" => __("Exclude Recent Posts From This Block", 'framework'),
        "desc" => __("Check this to exclude news already present in Recent Posts block", 'framework'),
        "id" => $shortname . "_bottom_exclude_recent",
        "std" => "",
        "type" => "checkbox"),
    array("type" => "close"),
    
    array("type" => "closetab"),
    
    array("type" => "opentab"),
    
    array("type" => "open"),
    array("name" => __("Related Posts", 'framework'),
        "id" => $shortname . "_related_posts",
        "type" => "title"),
    array("name" => __("Show Related Posts", 'framework'),
        "desc" => __("Check this to show related posts (same category) on post pages", 'framework'),
        "id" => $shortname . "_show_related",
        "std" => "",
        "type" => "checkbox"),
    array("name" => __("No. of Related Posts", 'framework'),
        "desc" => __("Enter the number of related posts you wish to display", 'framework'),
        "id" => $shortname . "_related_number",
        "std" => "5",
        "type" => "text"),
    array("type" => "close"),
    array("type" => "closetab"),
    
    array("type" => "opentab"),
    array("type" => "open"),
    array("name" => __('Post sharing', 'framework'),
        "id" => $shortname . "_post_sharing",
        "type" => "title"),
    array("name" => __("Enable post sharing links", 'framework'),
        "desc" => __("Check this box to enable post sharing links on single post pages. ", 'framework'),
        "id" => $shortname . "_sharing_enable",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable sharing to Twitter", 'framework'),
        "desc" => __("Check this box to enable post sharing to Twitter.", 'framework'),
        "id" => $shortname . "_enable_twitter",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable sharing to Facebook", 'framework'),
        "desc" => __("Check this box to enable post sharing to Facebook.", 'framework'),
        "id" => $shortname . "_enable_fb",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable Facebook like", 'framework'),
        "desc" => __("Check this box to enable Facebook like.", 'framework'),
        "id" => $shortname . "_enable_fblike",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable sharing to Google +1", 'framework'),
        "desc" => __("Check this box to enable post sharing to Google +1.", 'framework'),
        "id" => $shortname . "_enable_gplusone",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable sharing to Pinterest", 'framework'),
        "desc" => __("Check this box to enable post sharing to Pinterest.", 'framework'),
        "id" => $shortname . "_enable_pinterest",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable sharing to Stumble", 'framework'),
        "desc" => __("Check this box to enable post sharing to Stumble.", 'framework'),
        "id" => $shortname . "_enable_stumble",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable sharing to Tumblr", 'framework'),
        "desc" => __("Check this box to enable post sharing to Tumblr.", 'framework'),
        "id" => $shortname . "_enable_tumblr",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable sharing to Digg", 'framework'),
        "desc" => __("Check this box to enable post sharing to Digg.", 'framework'),
        "id" => $shortname . "_enable_digg",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable sharing to Reddit", 'framework'),
        "desc" => __("Check this box to enable post sharing to Reddit.", 'framework'),
        "id" => $shortname . "_enable_reddit",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable sharing to Delicious", 'framework'),
        "desc" => __("Check this box to enable post sharing to Delicious.", 'framework'),
        "id" => $shortname . "_enable_del",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable sharing to Technorati", 'framework'),
        "desc" => __("Check this box to enable post sharing to Technorati.", 'framework'),
        "id" => $shortname . "_enable_techno",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable sharing to LinkedIn", 'framework'),
        "desc" => __("Check this box to enable post sharing to LinkedIn.", 'framework'),
        "id" => $shortname . "_enable_linkedin",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable sharing to Xing", 'framework'),
        "desc" => __("Check this box to enable post sharing to Xing.", 'framework'),
        "id" => $shortname . "_enable_xing",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Enable support via Flattr", 'framework'),
        "desc" => __("Check this box to enable support via Flattr.", 'framework'),
        "id" => $shortname . "_enable_flattr",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __("Flattr ID", 'framework'),
        "desc" => __("Enter your Flattr ID to enable the donation", 'framework'),
        "id" => $shortname . "_flattr_id",
        "std" => __("", 'framework'),
        "type" => "text"),
    array("name" => __("Enable sharing via e-mail", 'framework'),
        "desc" => __("Check this box to enable post sharing via e-mail.", 'framework'),
        "id" => $shortname . "_enable_email",
        "std" => "false",
        "type" => "checkbox"),
    array("type" => "close"),
    
    
    
    array("type" => "open"),
    array("name" => __('Following links', 'framework'),
        "id" => $shortname . "_site_following",
        "type" => "title"),
    array("name" => __(sprintf( __("Enable following option %s"), 1 ), 'framework'),
        "desc" => "",
        "id" => $shortname . "_follow_1_active",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __(sprintf( __("Upload Following Icon Image %s"), 1 ), 'framework'),
        "desc" => "",
        "id" => $shortname . "_follow_1_image_url",
        "std" => "",
        "type" => "file"),
    array("name" => __(sprintf( __("Following %s Url"), 1 ), 'framework'),
        "desc" => __("Enter URL", 'framework'),
        "id" => $shortname . "_follow_1_url",
        "std" => __("", 'framework'),
        "type" => "text"),
    array("name" => __(sprintf( __("Following %s Order nr."), 1 ), 'framework'),
        "desc" => __('Select order number for this category block.', 'framework'),
        "id" => $shortname . "_follow_1_order",
        "std" => "1",
        "type" => "select",
        "options" => $follow_us_orders),

    array("name" => __(sprintf( __("Enable following option %s"), 2 ), 'framework'),
        "desc" => "",
        "id" => $shortname . "_follow_2_active",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __(sprintf( __("Upload Following Icon Image %s"), 2 ), 'framework'),
        "desc" => "",
        "id" => $shortname . "_follow_2_image_url",
        "std" => "",
        "type" => "file"),
    array("name" => __(sprintf( __("Following %s Url"), 2 ), 'framework'),
        "desc" => __("Enter URL", 'framework'),
        "id" => $shortname . "_follow_2_url",
        "std" => __("", 'framework'),
        "type" => "text"),
    array("name" => __(sprintf( __("Following %s Order nr."), 2 ), 'framework'),
        "desc" => __('Select order number for this category block.', 'framework'),
        "id" => $shortname . "_follow_2_order",
        "std" => "2",
        "type" => "select",
        "options" => $follow_us_orders),

    array("name" => __(sprintf( __("Enable following option %s"), 3 ), 'framework'),
        "desc" => "",
        "id" => $shortname . "_follow_3_active",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __(sprintf( __("Upload Following Icon Image %s"), 3 ), 'framework'),
        "desc" => "",
        "id" => $shortname . "_follow_3_image_url",
        "std" => "",
        "type" => "file"),
    array("name" => __(sprintf( __("Following %s Url"), 3 ), 'framework'),
        "desc" => __("Enter URL", 'framework'),
        "id" => $shortname . "_follow_3_url",
        "std" => __("", 'framework'),
        "type" => "text"),
    array("name" => __(sprintf( __("Following %s Order nr."), 3 ), 'framework'),
        "desc" => __('Select order number for this category block.', 'framework'),
        "id" => $shortname . "_follow_3_order",
        "std" => "3",
        "type" => "select",
        "options" => $follow_us_orders),

    array("name" => __(sprintf( __("Enable following option %s"), 4 ), 'framework'),
        "desc" => "",
        "id" => $shortname . "_follow_4_active",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __(sprintf( __("Upload Following Icon Image %s"), 4 ), 'framework'),
        "desc" => "",
        "id" => $shortname . "_follow_4_image_url",
        "std" => "",
        "type" => "file"),
    array("name" => __(sprintf( __("Following %s Url"), 4 ), 'framework'),
        "desc" => __("Enter URL", 'framework'),
        "id" => $shortname . "_follow_4_url",
        "std" => __("", 'framework'),
        "type" => "text"),
    array("name" => __(sprintf( __("Following %s Order nr."), 4 ), 'framework'),
        "desc" => __('Select order number for this category block.', 'framework'),
        "id" => $shortname . "_follow_4_order",
        "std" => "4",
        "type" => "select",
        "options" => $follow_us_orders),
    
    array("name" => __(sprintf( __("Enable following option %s"), 5 ), 'framework'),
        "desc" => "",
        "id" => $shortname . "_follow_5_active",
        "std" => "false",
        "type" => "checkbox"),
    array("name" => __(sprintf( __("Upload Following Icon Image %s"), 5 ), 'framework'),
        "desc" => "",
        "id" => $shortname . "_follow_5_image_url",
        "std" => "",
        "type" => "file"),
    array("name" => __(sprintf( __("Following %s Url"), 5 ), 'framework'),
        "desc" => __("Enter URL", 'framework'),
        "id" => $shortname . "_follow_5_url",
        "std" => __("", 'framework'),
        "type" => "text"),
    array("name" => __(sprintf( __("Following %s Order nr."), 5 ), 'framework'),
        "desc" => __('Select order number for this category block.', 'framework'),
        "id" => $shortname . "_follow_5_order",
        "std" => "5",
        "type" => "select",
        "options" => $follow_us_orders),
    array("type" => "close"),
    
    
    
    array("type" => "closetab")
	

	);

	/*Add The Theme Options Page*/
	function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {

        if ( 'save' == $_REQUEST['action'] ) {
			
				$url = $_REQUEST['tz_selectedtab'];
            	if ($url == ''){
//					$url = 'themes.php?page=theme-options.php&saved=true&tab=1';
					$url = 'admin.php?page=theme-options.php&saved=true&tab=1';
                    
				} else {
					$t = substr($url, -1);
//					$url = 'themes.php?page=theme-options.php&saved=true&tab='.$t;
					$url = 'admin.php?page=theme-options.php&saved=true&tab='.$t;
				}
				
    			foreach ($options as $value) 
                {
					if ( 
                        ($value['id'] != 'tz_logo_url') 
                        && 
                        ($value['id'] != 'tz_background_image_url') 
                        && 
                        ($value['id'] != 'tz_favicon_url') 
                        && 
                        ($value['id'] != 'tz_follow_1_image_url') 
                        && 
                        ($value['id'] != 'tz_follow_2_image_url') 
                        && 
                        ($value['id'] != 'tz_follow_3_image_url') 
                        && 
                        ($value['id'] != 'tz_follow_4_image_url') 
                        && 
                        ($value['id'] != 'tz_follow_5_image_url') 
                        && 
                        ($value['id'] != 'tz_big_slider_1_image_url') 
                        && 
                        ($value['id'] != 'tz_big_slider_2_image_url') 
                        && 
                        ($value['id'] != 'tz_big_slider_3_image_url') 
                        && 
                        ($value['id'] != 'tz_big_slider_4_image_url') 
                        && 
                        ($value['id'] != 'tz_big_slider_5_image_url') 
                    )
                    {
                    	update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 
					}	
				}

                foreach ($options as $value) 
                {
					if ( 
                        ($value['id'] != 'tz_logo_url') 
                        && 
                        ($value['id'] != 'tz_background_image_url') 
                        && 
                        ($value['id'] != 'tz_favicon_url') 
                        && 
                        ($value['id'] != 'tz_follow_1_image_url') 
                        && 
                        ($value['id'] != 'tz_follow_2_image_url') 
                        && 
                        ($value['id'] != 'tz_follow_3_image_url') 
                        && 
                        ($value['id'] != 'tz_follow_4_image_url') 
                        && 
                        ($value['id'] != 'tz_follow_5_image_url') 
                        && 
                        ($value['id'] != 'tz_big_slider_1_image_url') 
                        && 
                        ($value['id'] != 'tz_big_slider_2_image_url') 
                        && 
                        ($value['id'] != 'tz_big_slider_3_image_url') 
                        && 
                        ($value['id'] != 'tz_big_slider_4_image_url') 
                        && 
                        ($value['id'] != 'tz_big_slider_5_image_url') 
                    )
                    {
                    	if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } 
					}
				}

	
			// If files has been uploaded, move them to the /uploads dir and update the option value
			if (  (isset($_FILES['tz_logo_url'])) && ($_FILES['tz_logo_url']['error'] == UPLOAD_ERR_OK)  ) {
				$overrides = array('test_form' => false); 
		        $file = wp_handle_upload($_FILES['tz_logo_url'], $overrides);
				$urlimage = $file['url'];
				update_option('tz_logo_url', $urlimage);
			}
			
			if (  (isset($_FILES['tz_favicon_url'])) && ($_FILES['tz_favicon_url']['error'] == UPLOAD_ERR_OK)  ) {
				$overrides = array('test_form' => false); 
		        $file = wp_handle_upload($_FILES['tz_favicon_url'], $overrides);
				$urlimage = $file['url'];
				update_option('tz_favicon_url', $urlimage);
			}
            
            if (  (isset($_FILES['tz_background_image_url'])) && ($_FILES['tz_background_image_url']['error'] == UPLOAD_ERR_OK)  ) {
				$overrides = array('test_form' => false); 
		        $file = wp_handle_upload($_FILES['tz_background_image_url'], $overrides);
				$urlimage = $file['url'];
				update_option('tz_background_image_url', $urlimage);
			}
            
            
            for ($i = 1; $i<=5; $i++)
            {
                if (  (isset($_FILES['tz_follow_' . $i . '_image_url'])) && ($_FILES['tz_follow_' . $i . '_image_url']['error'] == UPLOAD_ERR_OK)  ) {
                    $overrides = array('test_form' => false); 
                    $file = wp_handle_upload($_FILES['tz_follow_' . $i . '_image_url'], $overrides);
                    $urlimage = $file['url'];
                    update_option('tz_follow_' . $i . '_image_url', $urlimage);
                }
            }
            
            for ($i = 1; $i<=5; $i++)
            {
                if (  (isset($_FILES['tz_big_slider_' . $i . '_image_url'])) && ($_FILES['tz_big_slider_' . $i . '_image_url']['error'] == UPLOAD_ERR_OK)  ) {
                    $overrides = array('test_form' => false); 
                    $file = wp_handle_upload($_FILES['tz_big_slider_' . $i . '_image_url'], $overrides);
                    $urlimage = $file['url'];
                    update_option('tz_big_slider_' . $i . '_image_url', $urlimage);
                }
            }
            
			
				header("Location: ".$url);
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] );}

            header("Location: themes.php?page=theme-options.php&reset=true");
           	die;
            
        }
    }

//        add_theme_page($themename." Options", "Options", 'edit_pages', basename(__FILE__), 'mytheme_admin');
    
        // add to main menu
        add_menu_page($themename." Options", 'LoveIt Options', 'edit_pages', basename(__FILE__), 'mytheme_admin', get_template_directory_uri() . '/images/menu-icon.png');
	}

	function mytheme_admin() {

    global $themename, $shortname, $options;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';

?>
		<?php // now style the actual theme options page ?>
		
		<div class="wrap">
			<div id="icon-themes" class="icon32"><br /></div>
			<h2><?php _e('Theme Options', 'framework') ?></h2>
			
			<div id="doc-block">
                <p><?php printf(__('For help, please read our %1$stheme documentation%2$s. In case you still experience problems please visit our %3$sTheme Support%4$s.','framework'), '<a href="http://www.themeforest.net/user/themiac">', '</a>', '<a href="http://www.themiac.com/">', '</a>'); ?></p>
            </div>

			<form method="post" action="" enctype="multipart/form-data" style="overflow:hidden;">
			<input type="hidden" name="selectedtab" id="selectedtab" value="0"/>	
			
			<div id="tabs" class="metabox-holder clearfix">
				
                <ul id="tab-items">
                    <li><a href="#tabs-1"><?php _e('General', 'framework') ?></a></li>
                    <li><a href="#tabs-2"><?php _e('Contacts', 'framework') ?></a></li>
                    <li><a href="#tabs-3"><?php _e('Homepage', 'framework') ?></a></li>
                    <li><a href="#tabs-4"><?php _e('Post Settings', 'framework') ?></a></li>
                    <li><a href="#tabs-5"><?php _e('Social Networks', 'framework') ?></a></li>
				</ul>
                
				<div class="clear"></div>
				
				<div class="postbox-container">

				<?php 
				$tab = 1;
				foreach ($options as $value) { 
				switch ( $value['type'] ) {

				case "opentab": ?>
				<div id="tabs-<?php echo $tab;?>" class="tab">
				<?php 
				$tab++;
				break;
				
				case "closetab": ?>
				</div><!-- #tabs- -->
				<?php
				break;

				case "open": // style the opening
				?>
				<!-- div id="tabs-<?php echo $tab;?>" -->
				<div class="postbox">

				<?php 
				break;
				
				case "note": // style the notes
				?>
				<div class="notes"><p><?php echo $value['desc']; ?></p></div>
				
				<?php 
				break;
				
				case "title": // style the titles
				?>
				<h3 class="hndle"><span><?php echo $value['name']; ?></span></h3>
				<div class="inside">		
					
				<?php break;
				
				case "hidden": ?>
				
				<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="hidden" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(htmlspecialchars(get_option( $value['id'] ), ENT_QUOTES)); } else { echo $value['std']; } ?>" />
								
				
				<?php break;
				
				case "text": // style the text boxes
				?>
				
				<div class="textcont">
					<div class="value">
						<?php echo $value['name']; ?>:
					</div>
					<div class="input">
						<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(htmlspecialchars(get_option( $value['id'] ), ENT_QUOTES)); } else { echo $value['std']; } ?>" />
						<p><?php echo stripslashes(htmlspecialchars($value['desc'])); ?></p>
					</div>
					<div class="clear"></div>
				</div>
				
				
				<?php break;
				
				case "file": // style the upload boxes
				?>
				
				<div class="textcont">
					<div class="value">
						<?php echo $value['name']; ?>:
					</div>
					<div class="input">
						<table class="form-table">
							<tr valign="top">
								<th scope="row">File:</th>
								<td><input type="file" name="<?php echo $value['id']; ?>" class="tz-upload" size="40" border="0" /></td>
							</tr>
						</table>
							<p><?php _e('Current file:', 'framework') ?> <?php echo get_option($value['id']); ?></p>
					</div>
					<div class="clear"></div>
				</div>
				
				
				<?php break;
				
				case "textarea": // style the textareas
				?>
				
				<div class="textcont">
				<div class="value"><?php echo $value['name']; ?>:</div>
				<div class="input">
				<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>"><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(htmlspecialchars(get_option( $value['id'] ), ENT_QUOTES)); } else { echo $value['std']; } ?></textarea>
				<p><?php echo stripslashes(htmlspecialchars($value['desc'])); ?></p>
				</div>
				<div class="clear"></div>
				</div>
				
					
				<?php break;
				
				case "checkbox": // style the checkboxes
				?>
				
				<div class="textcont">
				<div class="value check-value"><?php echo $value['name']; ?>:</div>
				<div class="input">
				<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
				<p><input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
				<label for="<?php echo $value['id']; ?>"><?php echo stripslashes(htmlspecialchars($value['desc'])); ?></label></p>
				</div>
				<div class="clear"></div>
				</div>
				
									
				<?php break;
				
				case "select": // style the select
				?>
				
				<div class="textcont">
				<div class="value"><?php echo $value['name']; ?>:</div>
				<div class="input">
				<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                    <?php $curr_value = get_option( $value['id'] ); ?>
                    <?php foreach ($value['options'] as $key => $option) { ?>
                    <option<?php 
                    
                        if ( $curr_value == $option) 
                        {
                            echo ' selected="selected"'; 
                        } 
                        elseif (
                            ($option == $value['std'])
                            &&
                            (empty($curr_value))
                        )
                        { 
                            echo ' selected="selected"'; 
                        } 
                        elseif (
                            ($curr_value == $key)
                            &&
                            (isset($value['keysAsValue']))
                        ) 
                        { 
                            echo ' selected="selected"'; 
                        } 
                        ?><?php if (isset($value['keysAsValue'])) { echo ' value="' . $key . '"'; } ?>><?php echo $option; ?></option>
                        <?php } ?>
                </select>
				<p><?php echo stripslashes(htmlspecialchars($value['desc'])); ?></p>
				</div>
				<div class="clear"></div>
				</div>
				
					
				<?php break;
				
				case "close": // style the closing
				?>
                        <p class="submit">
                            <input name="save" type="submit" class="button" value="Save Settings" />    
                            <input type="hidden" name="action" value="save" />
                        </p>
                
                
					</div><!-- inside -->
				 </div><!-- postbox -->
				
				
				
				<?php break;
				} 
			}
			?>
			
			</div><!-- postbox container -->
			</div><!-- metabox holder -->
			
		
			</form>
			<form method="post" action="" onsubmit="return confirm('<?php _e('Are you sure you want to restore theme defaults?','framework'); ?>\n<?php _e('Please be advised that these changes cannot be undone.', 'framework') ?>');">
				<p class="submit">
					<input name="reset" type="submit" class="button" value="Reset" />
					<input type="hidden" name="action" value="reset" />
					<span><?php _e('Caution: will restore theme defaults', 'framework') ?></span>
				</p>
			</form>
	</div>
	
	<?php
	}



add_action('admin_menu', 'mytheme_add_admin');



// ==========================//
//             END the theme options!                   //
// ==========================//

?>