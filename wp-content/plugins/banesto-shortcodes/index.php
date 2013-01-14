<?php
/*
Plugin Name: Banesto Shortcodes
Plugin URI: 
Description: Add columns, buttons, spacers, quotes, google map & accordions to content via buttons or shortcodes.
Version: 1.0
Author: Banesto
Author URI: http://ernests.info
Credits: 
*/

/*
  Copyright 2012 Ernests Kecko (ernests.kecko@gmail.com)

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


global $banesto_bsc_accordion_shortcode_count;

$banesto_bsc_accordion_shortcode_count = 0;

$bsc_textdomain = 'banesto-shortcodes';
add_action('init', 'banesto_bsc_textdomain');

$banesto_bsc_plugin_url = get_bloginfo('wpurl') .'/wp-content/plugins/' . $bsc_textdomain . '/';


function banesto_bsc_textdomain() 
{
	global $bsc_textdomain;
	load_plugin_textdomain($bsc_textdomain, 'wp-content/plugins/' . $bsc_textdomain);
}



function banesto_bsc_stylesheet() 
{
    global $banesto_bsc_plugin_url;
    
    wp_register_style('column-styles', $banesto_bsc_plugin_url . 'styles.css');
    wp_enqueue_style('column-styles');
}

add_action('wp_print_styles', 'banesto_bsc_stylesheet');


/*
 * Columns Shortcodes (2-3 columns)
 */
 
function banesto_bsc_one_third( $atts, $content = null ) 
{
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}

add_shortcode('one_third', 'banesto_bsc_one_third');

function banesto_bsc_one_third_last( $atts, $content = null ) 
{
   return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}

add_shortcode('one_third_last', 'banesto_bsc_one_third_last');

function banesto_bsc_one_half( $atts, $content = null ) 
{
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}

add_shortcode('one_half', 'banesto_bsc_one_half');

function banesto_bsc_one_half_last( $atts, $content = null ) 
{
   return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}

add_shortcode('one_half_last', 'banesto_bsc_one_half_last');



/*
 * Button Shortcode
 */

function banesto_bsc_button($att, $content = null) 
{
    extract(shortcode_atts(array(
        'link' => '#',
        'target' => '_blank',
        'style' => '',
        'align' => '',
    ), $att));
    
    $my_button = '<span class="bk-button-wrapper"><a href="' . $link . '" target="' . $target . '" class="bk-button ' . $style. '  ' . $align . '">' . do_shortcode($content) . '</a></span>';
    
    return $my_button; 
}
add_shortcode('button','banesto_bsc_button');


/*
 * Spacer Shortcode
 */

function banesto_bsc_spacer($att, $content = null) 
{
    extract(shortcode_atts(array(
        'style' => '',
    ), $att));
    
    $my_button = '<div class="content-spacer clear"><div class="' . $style. '"></div></div>';
    
    return $my_button; 
}
add_shortcode('spacer','banesto_bsc_spacer');


/*
 * Quote Shortcode
 */

function banesto_bsc_quote($att, $content = null) 
{
    extract(shortcode_atts(array(
        'style' => '',
    ), $att));
    
    $my_button = '<div class="quote-wrapper clear"><div class="' . $style. '"><div class="innerWrap">' . do_shortcode($content) . '</div></div></div>';
    
    return $my_button; 
}
add_shortcode('quote','banesto_bsc_quote');


/*
 * Gmap Shortcode
 */

add_action('init', 'register_gmap_api_script');
add_action('wp_footer', 'print_gmap_api_script');
 
function register_gmap_api_script() 
{
//	wp_register_script('gmap-api', 'http://maps.googleapis.com/maps/api/js?sensor=false', null, null, true);
	wp_register_script('gmap-api', plugins_url('gmap_api.js', __FILE__), null, null, true);
	wp_register_script('gmap-setup', plugins_url('gmap_point.js', __FILE__), null, null, true);
}

 

function print_gmap_api_script() 
{
	global $add_gmap_api;
    
	if (!$add_gmap_api)
    {
		return null;
    }
    else 
    {
        wp_print_scripts('gmap-api');
        wp_print_scripts('gmap-setup');
    }
}



function banesto_bsc_gmap($att, $content = null) 
{
    global $banesto_bsc_plugin_url, $add_gmap_api;
 
	$add_gmap_api = true;
    
    extract(shortcode_atts(array(
        'height'    => '402',
        'lat'       => '23.344',
        'lng'       => '12.342',
        'zoom'      => 7
    ), $att));
    
    $my_button = '<div class="gmapWrap" style="height: ' . $height . 'px">';
    $my_button .= '<script type="text/javascript">var lat = "' . $lat . '",lng = "' . $lng . '",zoom=' . $zoom . ',gmap_point = "' . get_template_directory_uri() . '/images/gmap-pin.png";</script>';
    $my_button .= '<div class="gmap" id="gmap"></div></div>';
    
    return $my_button; 
}

add_shortcode('gmap','banesto_bsc_gmap');






/*
 * Accordion Shortcode
 */

function banesto_bsc_accordion($atts, $content)
{
	global $banesto_bsc_accordion_shortcode_count, $post;
    
	extract(shortcode_atts(array(
		'title' => null,
		'class' => null,
	), $atts));
	
	ob_start();
	
	if ($title):
		?>
		<h3><a href="#<?php echo ereg_replace("[^A-Za-z0-9]", "", $title)."-".$olt_accordion_shortcode_count; ?>"><?php echo $title; ?></a></h3>
		<div class="accordian-shortcode-content <?php echo $class; ?>" >
			<?php echo do_shortcode( $content ); ?>
		</div>
		<?php
	elseif($post->post_title):
	?>
		<div id="<?php echo ereg_replace("[^A-Za-z0-9]", "", $post->post_title)."-".$olt_accordion_shortcode_count; ?>" >
			<?php echo do_shortcode( $content ); ?>
		</div>
	<?php
	else:
	?>
		<span style="color:red">Please enter a title attribute like [accordion title="title name"]accordion content[accordion]</span>
		<?php 	
	endif;
	$banesto_bsc_accordion_shortcode_count ++;
	return ob_get_clean();
}



function banesto_bsc_accordions($attr, $content)
{
	// wordpress function 
	global $banesto_bsc_accordion_shortcode_count, $post, $add_accordion_scripts;
    
    $add_accordion_scripts = true;
	
	$attr['autoHeight']     = (bool) $attr['autoHeight'];
	$attr['active']         = (int)  $attr['active'];
	$attr['clearStyle']     = (bool) $attr['clearStyle'];
	$attr['collapsible']    = (bool) $attr['collapsible'];
	$attr['fillSpace']      = (bool) $attr['fillSpace'];
    
	$query_atts = shortcode_atts(
		array( 
			'autoHeight'    => false,
			'active'        => 0,
			'animated'      => 'slide',
			'clearStyle'    => false,
			'collapsible'   => true,
			'event'         => 'click',
			'fillSpace'     => false
		), $attr);
	
	// there might be a better way of doing this
	$id = "random-accordion-id-" . rand(0,100);
	
	$content = (substr($content,0,6) =="<br />" ? substr($content,6): $content);
	$content = str_replace("]<br />","]",$content);
	ob_start();
	?>
	<div id="<?php echo $id ?>" class="accordions-shortcode">
		<?php echo do_shortcode( $content ); ?> 
        <script type="text/javascript">accordion_shorcodes['<?php echo $id ?>'] = <?php echo json_encode($query_atts); ?>;</script>
	</div>

	<?php
	$post_content = ob_get_clean();
     
	return str_replace("\r\n", '',$post_content);
}


function banesto_bsc_accordions_shortcode_init()
{
    add_shortcode('accordion', 'banesto_bsc_accordion'); // Individual accordion
    add_shortcode('accordions', 'banesto_bsc_accordions'); // The shell
}

add_action('init','banesto_bsc_accordions_shortcode_init');


function accordion_shortcode_public_head() 
{
	global $banesto_gpa_plugin_url;
	echo '<script type="text/javascript">
        //<![CDATA[
        var accordion_shorcodes = new Array();
        //]]>
    </script>';
}

add_action('wp_head', 'accordion_shortcode_public_head');


add_action('init', 'register_accordion_scripts');
add_action('wp_footer', 'print_accordion_scripts');
 
function register_accordion_scripts() 
{
    wp_register_script('accordion_setup', plugins_url('accordion-setup.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-accordion'), null, true);
}

 

function print_accordion_scripts() 
{
	global $add_accordion_scripts;
    
	if (!$add_accordion_scripts)
    {
		return null;
    }
    else 
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-accordion');
     
        wp_print_scripts('accordion_setup');
    }
}



// Add Buttons to MCE
function banesto_bsc_add_button_button() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;
	if ( get_user_option('rich_editing') == 'true') {
		add_filter('mce_external_plugins', "banesto_bsc_tiny_register");
        add_filter('mce_buttons', 'banesto_bsc_tiny_add_button', 0);
	}
}

add_action('init', 'banesto_bsc_add_button_button');



// attach buttons to tinyMCE button block
function banesto_bsc_tiny_add_button($buttons)
{
    array_push($buttons, "|", "banesto_button", "banesto_columns", "banesto_spacer", "banesto_quote", "banesto_gmap", "banesto_accordion");
    return $buttons;
}

// register js functions
function banesto_bsc_tiny_register($plugin_array)
{
    global $banesto_bsc_plugin_url;

    $plugin_array['banesto_button']     = $banesto_bsc_plugin_url . 'editor_plugin.js';
    $plugin_array['banesto_columns']    = $banesto_bsc_plugin_url . 'editor_plugin.js';
    $plugin_array['banesto_spacer']     = $banesto_bsc_plugin_url . 'editor_plugin.js';
    $plugin_array['banesto_quote']      = $banesto_bsc_plugin_url . 'editor_plugin.js';
    $plugin_array['banesto_gmap']       = $banesto_bsc_plugin_url . 'editor_plugin.js';
    $plugin_array['banesto_accordion']  = $banesto_bsc_plugin_url . 'editor_plugin.js';
    return $plugin_array;
}
    
// refresh tinyMCE to see new buttons
function banesto_bsc_refresh_mce($ver) {
	$ver += 3;
	return $ver;
}

add_filter( 'tiny_mce_version', 'banesto_bsc_refresh_mce');




?>