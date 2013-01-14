<?php

/*
Plugin Name: Banesto Gallery Post Attatch
Plugin URI: 
Description: TBD
Version: 1.0
Author: Banesto
Author URI: 
Credits: 
*/

/*
  Copyright 2012 Ernests Kečko (ernests.kecko@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA


*/

//error_reporting(E_ALL);
//ini_set("display_errors","2");

$bgpa_textdomain = 'banesto-gallery-post-attach';

add_action('init', 'banesto_gpa_textdomain');

$banesto_gpa_plugin_url = get_bloginfo('wpurl') .'/wp-content/plugins/' . $bgpa_textdomain . '/';


function banesto_gpa_textdomain() {
	global $bgpa_textdomain;
	load_plugin_textdomain($bgpa_textdomain, 'wp-content/plugins/' . $bgpa_textdomain);
}



// head code - swfobject.js includion + css for flash object
function banesto_gpa_head() 
{
	global $banesto_gpa_plugin_url;
//	echo '<script type="text/javascript" src="' . $banesto_gpa_plugin_url . 'facebox.js"></script>';
}

add_action('wp_head', 'banesto_gpa_head');


function gallery_post_filter_hidden_field( $content ) 
{
	global $banesto_gpa_plugin_url;
	
    $post_list = banesto_gpa_get_gallery_posts();
    
    $post_list_json = json_encode( $post_list );
    
    $content .= '<script type="text/javascript">
		var post_list = ' . $post_list_json . ';
	</script>';
	return $content;
}


function banesto_gpa_get_gallery_posts()
{
    $args = array(
        'post_type'=> 'post',
        'post_status' => 'publish',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => array( 'post-format-gallery' )
            )
        )
    );

    return get_posts( $args );    
}


function banesto_get_image_list($id)
{
    $images = get_posts(array(
		'post_parent'       => $id,
		'post_type'         => 'attachment',
		'numberposts'       => -1,
		'orderby'           => 'title',
		'order'             => 'ASC',
		'post_mime_type'    => 'image',
   ));
    
    return $images;
}


// [gallery_post id="5" type="thumbnails"]
// [gallery_post id="5" type="slideshow"]
function banesto_gallery_handler($atts)
{
	global $banesto_gpa_plugin_url, $add_gallery_post_scripts;
	
	extract(shortcode_atts(array(
		'id'    => '',
		'type'  => 'slideshow',
        'count' => 3
	), $atts));
    
    if ('slideshow' == $type)
    {
        $add_gallery_post_scripts = true;
    }
    
    $images = banesto_get_image_list($id);
    
    if (count($images) == 0)
    {
        return null;
    }

    if ('thumbnails' == $type)
    {
        $result = display_thumbnail_block($images, $count, $id);
    }
    else
    {
        $result = display_slideshow_block($images, $id);
    }
    
    $result = wpautop(trim($result));
    
	return $result;
}

add_shortcode('post-gallery', 'banesto_gallery_handler');


// display thumbnails with 'more' link
function display_thumbnail_block($images, $count, $id)
{
    global $bgpa_textdomain;
    
    $images = array_slice($images, 0, $count);
    
    $ret = '<div class="postGalleryBlock" id="postGalleryThumbs_' . $id . '">';
    $ret .= '<div class="imageWrap">';
    $ret .= '<div class="title">' . __('Gallery', $bgpa_textdomain ) . '</div>';
    
    foreach ($images as $image)
    {   
        $ret .= '<a class="fancybox" title="' . $image->title . '" href="' . $image->guid .'" rel="fancybox">';
        $ret .= wp_get_attachment_image( $image->ID, 'main-image-pictures' );
        $ret .= '</a>';
    }
    $ret .= '</div>';
    
    $ret .= '<a class="seeMore" href="' . get_permalink( $id ) . '">' . __('See all photos', $bgpa_textdomain) . '</a>';
    
    $ret .= '</div>';
    
    return $ret;
}


// display slideshow
function display_slideshow_block($images, $id)
{
    $ret = '<div class="postGallerySlideshow" id="postGallerySlideshow_' . $id . '">';
    $ret .= '<div class="innerWrap">';
    $ret .= '<div class="imageWrap">';
    
    foreach ($images as $image)
    {   
        $image_src = wp_get_attachment_image_src( $image->ID, 'large' );
        $ret .= '<img src="' . $image_src[0] . '" alt="' . $image->post_title . '" width="100%" />';
    }
    $ret .= '</div>';
    
    
    $ret .= '<a id="nextBigLink_' . $id . '" class="nextLink nextPrevLinks" href="javascript:void(0);"></a>';
    $ret .= '<a id="prevBigLink_' . $id . '"class="prevLink nextPrevLinks" href="javascript:void(0);"></a>';
    
    $ret .= '</div>';
    
    $ret .= '<div class="imageTitle"></div>';
    $ret .= "<script type=\"text/javascript\">gallery_slideshow.push(" . $id . ")</script>";
    
    $ret .= '</div>';
    

    
    return $ret;
}


// gets called from outside the loop
function banesto_attached_gallery_block($id, $count = 3)
{
    $images = banesto_get_image_list($id);
    
    echo display_thumbnail_block($images, $count, $id);
}



function gallery_post_admin_head() 
{
	global $banesto_gpa_plugin_url;
	
	echo '<script type="text/javascript">var banesto_gpa_plugin_url = "' . $banesto_gpa_plugin_url . '"</script>'."\n";
	echo '<link rel="stylesheet" href="' . $banesto_gpa_plugin_url . 'css/facebox.css" type="text/css" media="screen" />'."\n";
	
	if ( strstr( $GLOBALS['wp_version'], '2.7' ) || strstr( $GLOBALS['wp_version'], '2.8' ) )
		echo '<link rel="stylesheet" href="' . $banesto_gpa_plugin_url . 'css/wordpress27.css" type="text/css" media="screen" />';
	
	echo '<script type="text/javascript" src="' . $banesto_gpa_plugin_url . 'facebox.js?ver=2.9.2"></script>';
}

add_action('admin_head', 'gallery_post_admin_head');


function gallery_post_public_head() 
{
	global $banesto_gpa_plugin_url;
	echo '<script type="text/javascript">
        //<![CDATA[
        var gallery_slideshow = new Array();
        //]]>
    </script>';
}

add_action('wp_head', 'gallery_post_public_head');




function add_gallery_post_button() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;
	if ( get_user_option('rich_editing') == 'true') {
		add_filter('mce_external_plugins', 'add_gallery_post_tinymce_plugin');
		add_filter('mce_buttons', 'register_gallery_post_button');
		add_filter('the_editor' , 'gallery_post_filter_hidden_field');
	}
}

add_action('init', 'add_gallery_post_button');


function gallery_post_action_load_scripts() {
	global $banesto_gpa_plugin_url;
	
	wp_enqueue_script('facebox', $banesto_gpa_plugin_url . 'gallery-slideshow.js', array( 'jquery' ) );
}

//add_action('init', 'gallery_post_action_load_scripts');




add_action('init', 'register_gallery_post_scripts');
add_action('wp_footer', 'print_gallery_post_scripts');
 
function register_gallery_post_scripts() 
{
	wp_register_script('jquery-cycle', plugins_url('jquery.cycle.all.min.js', __FILE__), array('jquery'), '2.9995', true);
	wp_register_script('gallery-slideshow', plugins_url('gallery-slideshow.js', __FILE__), null, null, true);
}

 

function print_gallery_post_scripts() 
{
	global $add_gallery_post_scripts;
    
	if (!$add_gallery_post_scripts)
    {
		return null;
    }
    else 
    {
        wp_print_scripts('jquery-cycle');
        wp_print_scripts('gallery-slideshow');
    }
}




function register_gallery_post_button($buttons) {
	array_push($buttons, "|", "gallery_post");
	return $buttons;
}

function add_gallery_post_tinymce_plugin($plugin_array) {
	global $banesto_gpa_plugin_url;
	
	$plugin_array['gallery_post'] = $banesto_gpa_plugin_url . 'editor_plugin.js';
	return $plugin_array;
}


function my_refresh_mce($ver) {
	$ver += 3;
	return $ver;
}

add_filter( 'tiny_mce_version', 'my_refresh_mce');








// Add Content Flags Meta box
add_action('admin_menu', 'banesto_gpa_add_meta_box');

function banesto_gpa_add_meta_box() {
	global $bgpa_textdomain;

    // add meta_box to post
	add_meta_box('attach_gallery_div', __('Attach Gallery', $bgpa_textdomain), 'banesto_gpa_metabox_admin', 'post', 'normal');
    
    // add meta_box to page
	add_meta_box('attach_gallery_div', __('Attach Gallery', $bgpa_textdomain), 'banesto_gpa_metabox_admin', 'page', 'normal');
}


// Meta box contents
function banesto_gpa_metabox_admin() {
	global $post, $bgpa_textdomain;
	
	$post_id = $post->ID;
	$att_gallery = '';
    
    $post_list = banesto_gpa_get_gallery_posts();
    
    if (count($post_list) == 0)
    {
        return null;
    }
	
	//echo '<h4 class="dbx-handle">' . __('Select local video:', $bgpa_textdomain) . '</h4>';
	echo '<div class="inside">';
	echo '<p>';
			
	# get existing data if post already exists
	if($post_id != null){
		$att_gallery = get_post_meta($post_id, 'att_gallery', true);
	}
	    
	echo '<select id="att_gallery" name="att_gallery" style="width:100%">';
	
    
    echo '<option value="0">' . __("No gallery attached", $bgpa_textdomain) . '</option>';
    
	foreach ($post_list as $item) { ?>
		<option value="<?php echo $item->ID ?>" <?php if (attribute_escape($att_gallery) == $item->ID) echo "selected='selected'"; ?>><?php echo $item->post_title . ""; ?></option>
	<?php }
	
	echo '</select>';
	
	
	echo '<p class="howto">' . __('Select gallery be attached to post.', $bgpa_textdomain) . '</p>';
	
	echo '<input type="hidden" name="banesto_gpa_noncename" id="banesto_gpa_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	echo '
		</p>
	</div>';
	
}

# Save checked values in wp_postmeta table

add_action('save_post', 'banesto_gpa_admin_save');

function banesto_gpa_admin_save($post_id) {
	
	# verify this came from the our screen and with proper authorization,
	# because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['banesto_gpa_noncename'], plugin_basename(__FILE__) )) {
		return $post_id;
	}
	
	# check if it's not post revisions
	$post_revision = true;
	
	if (WP_POST_REVISIONS != false) {
		$post_revision = wp_is_post_revision($post_id);
	}
	if ($post_revision != null){
		if ($_POST['att_gallery'] != __("No gallery", $bgpa_textdomain)) {
			update_post_meta($post_id, 'att_gallery', $_POST['att_gallery']);
		} else {
			// if there's no video attached, there's no sense to keep empty record
			delete_post_meta($post_id, 'att_gallery');
		}
	}
}



?>