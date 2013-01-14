<?php

/* 
	Here we have all the custom functions for the theme
	Please be extremely cautious editing this file,
	When things go wrong, they tend to go wrong in a big way.
	You have been warned!
*/

// Register the wp 3.0 Menus
add_action( 'init', 'register_my_menus' );

function register_my_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu', 'framework' ),
			'secondary-menu' => __( 'Secondary Menu', 'framework' )
		)
	);
}


// Ready for theme localisation
load_theme_textdomain ('framework');


// Register the sidebars and widget classes
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Home Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Blog Category Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Single Post Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Page Sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer 1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer 2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer 3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}


// Add support for WP 2.9 post thumbnails
if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 60, 58, true ); // Main theme thumbnails
	add_image_size( 'main-image', 288, 190, true ); // Main (latest) image
	add_image_size( 'main-image-pictures', 125, 115, true ); // Main (pictures) image
	add_image_size( 'lead-image', 574, 320, true ); // Post Page Main image
	add_image_size( 'blog-image', 614, 182, true ); // Blog Page Main image
	add_image_size( 'gallery-image', 288, 288, true ); // Gallery Page Main image
}


// Add support for a variety of post formats
add_theme_support( 'post-formats', array( 'gallery' ) );


// Change the execution priority of wpautop so that it executes after the shotcodes are processed instead of before
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);


// Add option for custom gravatar
function tz_custom_gravatar( $avatar_defaults ) {
    $tz_avatar = get_template_directory_uri() . '/images/gravatar.png';
    $avatar_defaults[$tz_avatar] = 'Custom Gravatar (/images/gravatar.png)';
    return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'tz_custom_gravatar' );


// Content width
if ( ! isset( $content_width ) ) $content_width = 940;


// Feed links
 add_theme_support( 'automatic-feed-links' );


// Change Excerpt Length
function tz_excerpt_length($length) {
return 40; }
add_filter('excerpt_length', 'tz_excerpt_length');


// Change Excerpt [...] to new string : WP2.8+
function tz_excerpt_more($excerpt) {
return str_replace('[...]', '...', $excerpt); }
add_filter('wp_trim_excerpt', 'tz_excerpt_more');


// Register jQuery
function tz_google_jquery() {
	if (!is_admin()) {
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'tz_google_jquery');



// Add browser detection class to body tag
add_filter('body_class','tz_browser_body_class');
function tz_browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}

// Output the styling for the seperated Pings
function tz_list_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment; ?>
<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }


// Make a custom login logo and link
function tz_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_template_directory_uri().'/images/custom-login-logo.png) !important; }
    </style>';
}
function tz_wp_login_url() {
echo home_url();
}
function tz_wp_login_title() {
echo get_option('blogname');
}

//add_action('login_head', 'tz_custom_login_logo');
//add_filter('login_headerurl', 'tz_wp_login_url');
//add_filter('login_headertitle', 'tz_wp_login_title');


// Find and close unclosed xhtml tags
function close_tags($text) {
    $patt_open    = "%((?<!</)(?<=<)[\s]*[^/!>\s]+(?=>|[\s]+[^>]*[^/]>)(?!/>))%";
    $patt_close    = "%((?<=</)([^>]+)(?=>))%";

    if (preg_match_all($patt_open,$text,$matches))
    {
        $m_open = $matches[1];
        if(!empty($m_open))
        {
            preg_match_all($patt_close,$text,$matches2);
            $m_close = $matches2[1];
            if (count($m_open) > count($m_close))
            {
                $m_open = array_reverse($m_open);
                foreach ($m_close as $tag) $c_tags[$tag]++;
                foreach ($m_open as $k => $tag)    if ($c_tags[$tag]--<=0) $text.='</'.$tag.'>';
            }
        }
    }
    return $text;
}

// Content Limit
function content($num, $more_link_text = '(more...)') {  
$theContent = get_the_content($more_link_text);  
$output = preg_replace('/<img[^>]+./','', $theContent);  
$output = strip_shortcodes($output);
$output = strip_tags($output);
$output = preg_replace("/\[caption.*\[\/caption\]/", '', $output);
$limit = $num+1;  
$content = explode(' ', $output, $limit);  
array_pop($content);  
$content = implode(" ",$content);  
echo close_tags($content);
}

// Custom Comments Display
function tz_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-body">
			<?php echo get_avatar($comment,$size='50'); ?>
            
            <div class="head">
    
                <div class="comment-author vcard cleafix">
                    <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
                </div>			
                <a class="commentmetadata" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s ago', 'framework'), human_time_diff( get_comment_time('U'), current_time('timestamp') )) ?></a><?php edit_comment_link(__('(Edit)', 'framewrok'),'  ','') ?>
                
            </div>
			
			<div class="comment-text"><?php comment_text() ?></div>		
            
            <?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.', 'framework') ?></em>
			<?php endif; ?>
			
		</div>
<?php
        }
        
        
add_filter('comment_form_default_fields', 'tz_comment_args');

function tz_comment_args($arg)
{
    $commenter = wp_get_current_commenter();
    
    $arg = array(
        'author'         => '<div class="wrap"><div class="input-container"><input type="text" name="author" id="author" value="' . esc_attr($commenter['comment_author']) . '" size="22" tabindex="1" class="required" placeholder="' .  __('Your Name', 'framework') . '"/></div></div>',
        'email'          => '<div class="wrap"><div class="input-container"><input type="text" name="email" id="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="22" tabindex="2" class="required email" placeholder="' . __('Your e-mail', 'framework') . '"/></div></div>',
        'url'            => '<div class="wrap"><div class="input-container"><input type="text" name="url" id="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="22" tabindex="3" class="url" placeholder="' . __('Your web site', 'framework') . '"/></div></div>',
    );        
    
    return $arg;
}

        
        

add_filter('next_posts_link_attributes', 'get_next_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'get_previous_posts_link_attributes');

if (!function_exists('get_next_posts_link_attributes')){
	function get_next_posts_link_attributes($attr){
		$attr = 'class="nextLink"';
		return $attr;
	}
}
if (!function_exists('get_previous_posts_link_attributes')){
	function get_previous_posts_link_attributes($attr){
		$attr = 'class="prevLink"';
		return $attr;
	}
}



/**
 * Conditional tag expanding - check whether current category is child of defined category
 *
 * @param	integer		$parent_id		ID of parent category.
 * @param	string		$exclude_ids	comma separated ID list
 *
 * @return	array		$ret
 */
function is_category_parent($parent_id, $exclude_ids = '', $include_parent = true, $ret_array = false) {
	global $wpdb;
	global $wp_query;
	
	$ret = array();
	
	//"SELECT tt.term_taxonomy_id FROM wp_terms t, wp_term_taxonomy tt WHERE tt.term_id = t.term_id AND tt.taxonomy = 'category' AND tt.parent = '23' AND tt.term_taxonomy_id NOT IN (112)"
	if (is_int($parent_id) && $parent_id > 0) {
		//$parent_sql = "SELECT group_concat(CONVERT(tt.term_taxonomy_id, CHAR(8)) separator ', ') as tt_ids FROM " . $wpdb->terms . " t, " . $wpdb->term_taxonomy . " tt WHERE tt.term_id = t.term_id AND tt.taxonomy = 'category' AND tt.parent = '" . $parent_id . "'";
		$parent_sql = "SELECT tt.term_taxonomy_id FROM " . $wpdb->terms . " t, " . $wpdb->term_taxonomy . " tt WHERE tt.term_id = t.term_id AND tt.taxonomy = 'category' AND tt.parent = '" . $parent_id . "'";
	
		if ($exclude_ids != "") {
			$parent_sql .= " AND tt.term_taxonomy_id NOT IN (" . $exclude_ids . ")";
		}
		
		//$results = $wpdb->get_row($parent_sql, ARRAY_A);
		//$ret = $results['tt_ids'];
		
		$ret = $wpdb->get_results($parent_sql, ARRAY_A);
		
		
		
		foreach ($ret as &$item) {
			$item = $item['term_taxonomy_id'];
		}

		if ($include_parent) {
			$ret[] = $parent_id;
		}
		
		//print_r($ret);
		//echo "wp_query->query_vars['cat']: " . $wp_query->query_vars["cat"] . "<br/>";
		
		# return just the array of categories
		if ($ret_array) {
			
			return $ret;
		
		# return if current category is within range
		} else {
		
			# check if current category is one of childs of defined parent
			if (in_array($wp_query->query_vars["cat"] , $ret)) {
				$return = true;
				//echo "exists<br/>";
			} else {
				$return = false;
				//echo "does not exists<br/>";
			}
		}
	}
	
	return $return;
}
        

function inherit_template() 
{ 
    if (is_category()) 
    {
        $catid = get_query_var('cat');
        
        if ( file_exists(get_template_directory() . '/category-' . $catid . '.php') ) 
        {
            include( get_template_directory() . '/category-' . $catid . '.php');
            exit;
        }

        $cat = &get_category($catid);
        $parent = $cat->category_parent;
        while ($parent) 
        {
            $cat = &get_category($parent);
            
            if ( file_exists(get_template_directory() . '/category-' . $cat->cat_ID . '.php') ) 
            {
                include (get_template_directory() . '/category-' . $cat->cat_ID . '.php');
                exit;
            }
            elseif ( file_exists(get_template_directory() . '/category-' . $cat->slug . '.php') ) 
            {
                include (get_template_directory() . '/category-' . $cat->slug . '.php');
                exit;
            }

            $parent = $cat->category_parent;
        }
    }
}

add_action('template_redirect', 'inherit_template', 1);


function smart_trim($text, $max_len, $trim_middle = false, $trim_chars = '...') {
	global $post;
	if ($text == '') $text = get_the_content('');
	
	$text = trim($text);
	$text = strip_tags($text, '<b><strong><i><em><u>');

    // strip shortcodes
    $text = preg_replace( '/(\][^\[]*\[)/', '', $text );
    $text = preg_replace( '/(\[[^\]]*\])/', '', $text );
    
	if (strlen($text) < $max_len) {
		return $text;
	} elseif ($trim_middle) {

		$hasSpace = strpos($text, ' ');
		if (!$hasSpace) {
			/**
			 * The entire string is one word. Just take a piece of the
			 * beginning and a piece of the end.
			 */
			$first_half = substr($text, 0, $max_len / 2);
			$last_half = substr($text, -($max_len - strlen($first_half)));
		} else {
			/**
			 * Get last half first as it makes it more likely for the first
			 * half to be of greater length. This is done because usually the
			 * first half of a string is more recognizable. The last half can
			 * be at most half of the maximum length and is potentially
			 * shorter (only the last word).
			 */
			$last_half = substr($text, -($max_len / 2));
			$last_half = trim($last_half);
			$last_space = strrpos($last_half, ' ');
			if (!($last_space === false)) {
				$last_half = substr($last_half, $last_space + 1);
			}
			$first_half = substr($text, 0, $max_len - strlen($last_half));
			$first_half = trim($first_half);
			if (substr($text, $max_len - strlen($last_half), 1) == ' ') {
				/**
				 * The first half of the string was chopped at a space.
				 */
				$first_space = $max_len - strlen($last_half);
			} else {
				$first_space = strrpos($first_half, ' ');
			}
			if (!($first_space === false)) {
				$first_half = substr($text, 0, $first_space);
			}
		}
		return $first_half.$trim_chars.$last_half;
	} else {

		$trimmed_text = substr($text, 0, $max_len);
		$trimmed_text = trim($trimmed_text);
		$trimmed_text = strip_tags($trimmed_text);
		if (substr($text, $max_len, 1) == ' ') {
			/**
			 * The string was chopped at a space.
			 */
			$last_space = $max_len;
		} else {
			/**
			 * In PHP5, we can use 'offset' here -Mike
			 */
			$last_space = strrpos($trimmed_text, ' ');
		}
		if (!($last_space === false)) {
			$trimmed_text = substr($trimmed_text, 0, $last_space);
		}
		return remove_trailing_punctuation($trimmed_text).$trim_chars;
	}
}

/**
 * Strip trailing punctuation from a line of text.
 *
 * @param  string $text The text to have trailing punctuation removed from.
 *
 * @return string       The line of text with trailing punctuation removed.
 */
function remove_trailing_punctuation($text) {
	return preg_replace("'[^a-zA-Z_0-9]+$'s", '', $text);
}



// Add the Related Posts Custom Widget
include("functions/widget-related-posts.php");

// Add the Latest Tweets Custom Widget
//include("functions/widget-tweets.php");

// Add the Flickr Photos Custom Widget
//include("functions/widget-flickr.php");

// Add the Follow Us Widget
include("functions/widget-category-list.php");

// Add the Follow Us Widget
include("functions/widget-follow-us.php");

// Add the Custom Video Widget
include("functions/widget-video.php");

// Add the Custom Tabbed Widget
include("functions/widget-tabbed.php");

// Add the Custom Social Counter Widget
include("functions/widget-social-counter.php");

// Add the Shortcodes
include("functions/theme-shortcodes.php");

// Add the Theme Options Pages
include("functions/theme-options.php");

?>