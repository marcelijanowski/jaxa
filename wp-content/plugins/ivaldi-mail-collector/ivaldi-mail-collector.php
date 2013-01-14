<?php
/*
Plugin Name: Ivaldi Mail Collector
Plugin URI: http://ivaldi.nl/blog/2010/10/11/wp-plugin-ivaldi-mail-collector/
Description: Ivaldi Mail Collector allows you to collect email addresses of users visiting your website using a widget. The email addresses can then be copied to your email program to sent them a news letter for example.
Version: 0.4.2
Author: Ivaldi
Author URI: http://ivaldi.nl
*/

/*
    Mail Collector allows you to collect email addresses of users visiting your website using a widget.
    Copyright (C) 2010 Ivaldi (http://ivaldi.nl)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

function ivaldi_mail_collector_loadplugin(){
	$widget_ops = array('classname' => 'ivaldi_mail_collector_frontend', 'description' => __('A widget to collect email addresses.', "ivaldi_mail_collector_frontend"));
    wp_register_sidebar_widget('ivaldi_mail_collector_frontend', 'Ivaldi Mail Collector', 'ivaldi_mail_collector_frontend', $widget_ops);
    wp_register_widget_control('ivaldi_mail_collector_frontend', 'ivaldi_mail_collector_control', 200, 200 );
}

function ivaldi_mail_collector_control()
{
  $options = get_option("ivaldi_mail_collector_frontend");
  if (!is_array( $options )){
	$options = array(
      'title' => __('Newsletter', "ivaldi_mail_collector_frontend"),
      'intro' => __('With this form, you can subscribe for a newsletter', "ivaldi_mail_collector_frontend"),
      'error_msg' => __('Invalid email address or email address already exist', "ivaldi_mail_collector_frontend"),
      'success_msg' => __('Email address succesfully added', "ivaldi_mail_collector_frontend")
    );
  }
 
  if ($_POST['ivaldi_mail_collector-Submit'])  {
    $options['title'] = htmlspecialchars($_POST['ivaldi_mail_collector-WidgetTitle']);
    $options['intro'] = htmlspecialchars($_POST['ivaldi_mail_collector-WidgetIntro']);
    $options['error'] = htmlspecialchars($_POST['ivaldi_mail_collector-WidgetError']);
    $options['success'] = htmlspecialchars($_POST['ivaldi_mail_collector-WidgetSuccess']);

    update_option("ivaldi_mail_collector_frontend", $options);
  }
 
?>  
    <p><label for="ivaldi_mail_collector-WidgetTitle"><?php echo __('Title', "ivaldi_mail_collector_frontend");?></label>
    <input class="widefat" type="text" id="ivaldi_mail_collector-WidgetTitle" name="ivaldi_mail_collector-WidgetTitle" value="<?php echo $options['title'];?>" /></p>
    <p><label for="ivaldi_mail_collector-WidgetTitle"><?php echo __('Intro text', "ivaldi_mail_collector_frontend");?></label>
    <textarea style="height:200px;" class="widefat" id="ivaldi_mail_collector-WidgetIntro" name="ivaldi_mail_collector-WidgetIntro"><?php echo stripslashes(htmlspecialchars(( $options['intro'] ), ENT_QUOTES)); ?></textarea></p>
    <p><label for="ivaldi_mail_collector-WidgetTitle"><?php echo __('Error message', "ivaldi_mail_collector_frontend");?></label>
    <input class="widefat" type="text" id="ivaldi_mail_collector-WidgetError" name="ivaldi_mail_collector-WidgetError" value="<?php echo $options['error'];?>" /></p>
    <p><label for="ivaldi_mail_collector-WidgetTitle"><?php echo __('Success message', "ivaldi_mail_collector_frontend");?></label>
    <input class="widefat" type="text" id="ivaldi_mail_collector-WidgetSuccess" name="ivaldi_mail_collector-WidgetSuccess" value="<?php echo $options['success'];?>" /></p>
    <input type="hidden" id="ivaldi_mail_collector-Submit" name="ivaldi_mail_collector-Submit" value="1" />
  </p>
<?php
}

function ivaldi_mail_collector_frontend($args)
{
	$options = get_option("ivaldi_mail_collector_frontend");

	if(isset($_POST['ivaldi_mail_collector_emailfield'])){
		$err = '';
		if($_POST['ivaldi_mail_collector_emailfield'] == '' || !preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/', $_POST['ivaldi_mail_collector_emailfield'])) {
			$err = $options['error'];
		}
		else{
			global $wpdb;
			if($wpdb->insert($wpdb->prefix . 'ivaldi_mail_collector', array('email' => $_POST['ivaldi_mail_collector_emailfield'])) === false){
					$err = $options['error'];
			} else {
				$success = true;
			}
		}	
	}
	
	extract($args); // extracts before_widget,before_title,after_title,after_widget
	echo $before_widget . $before_title . $options['title'] . $after_title;
	if($success == true) {
?>
	<div class="ivaldi_mail_collector-succes textwidget"> <?php echo $options['success']; $err = ''; ?></div>			
<?php
	}
	
	if(!isset($err) || ($err != '')){
		echo '<div class="ivaldi_mail_collector-formcontainer textwidget">';
		
		if(isset($err) && $err != ''){
?>	
			<p class="ivaldi_mail_collector-error"> <?php echo $err; ?></p>
<?php
		} ?>
            
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
            <div class="input-container email-input">
                <input type="text" id="ivaldi_mail_collector_emailfield" name="ivaldi_mail_collector_emailfield" placeholder="<?php _e('Your e-mail address'); ?>" />
            </div>
            <input type="submit" class="submit" value="<?php _e('Subscribe'); ?>" />
        </form>
            
		<p class="ivaldi_mail_collector-intro"><?php echo $options['intro']; ?></p>
    </div>
<?php	}
	echo $after_widget;
} 

function ivaldi_mail_collector_menu() {
    add_menu_page(__('Email addresses', "ivaldi_mail_collector_frontend"), __('Email addresses', "ivaldi_mail_collector_frontend"), 'publish_pages', 'ivaldi_mail_collector_admin', 'ivaldi_mail_collector_admin');
    add_submenu_page('ivaldi_mail_collector_export', __('Export', "ivaldi_mail_collector_frontend"), __('Export', "ivaldi_mail_collector_frontend"), 'publish_pages', 'ivaldi_mail_collector_export', 'ivaldi_mail_collector_export');
}

function ivaldi_mail_collector_remove() {
    global $wpdb;

    $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'ivaldi_mail_collector WHERE id = "' . $_GET['removeid'] . '";');
    ?>
        <script type="text/javascript">
            document.location = "<?php echo $_SERVER['HTTP_REFERER'] ?>";
        </script>
    <?php
}

/* show the table navigation */
function ivaldi_mail_collector_table_paginate($itemsperpage, $totalitems) {
    $totalpages = ceil($totalitems / $itemsperpage);

    $page_links = paginate_links( array(
        'base' => add_query_arg( 'paged', '%#%' ),
        'format' => '',
        'prev_text' => __('&laquo;'),
        'next_text' => __('&raquo;'),
        'total' => $totalpages,
        'current' => $_GET['paged']
    ));
    if($page_links) {
		?>
		<div class="tablenav">
			<div class="tablenav-pages"><?php $page_links_text = sprintf('<span class="displaying-num">' . __('Displaying %s&#8211;%s of %s' ) . '</span>%s',
				number_format_i18n(($_GET['paged'] - 1) * $itemsperpage + 1),
				number_format_i18n(min($_GET['paged'] * $itemsperpage, $totalitems)),
				number_format_i18n($totalitems),
				$page_links
			); echo $page_links_text; ?>
			</div>
		</div>
		<?php
    }
}

function ivaldi_mail_collector_admin() {
    
    if(isset($_GET['removeid'])) {
        ivaldi_mail_collector_remove();
        echo '<p>Bezig met verwijderen</p>';
        return;
    }

    global $wpdb;

    if(!isset($_GET['paged'])) {
        $_GET['paged'] = 1;
    }

    $perpage = 20;

    $offset = ($_GET['paged'] - 1) * $perpage;

    $where = ' 1=1 ';

    $rows = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'ivaldi_mail_collector WHERE ' . $where . ' ORDER BY id DESC LIMIT ' . $offset . ', ' . $perpage . ';');
    $total = $wpdb->get_var('SELECT COUNT(id) FROM ' . $wpdb->prefix . 'ivaldi_mail_collector WHERE ' . $where . ';');

	?>
	<div class="wrap">
	<h2><?php echo __('Registrations', "ivaldi_mail_collector_frontend"); ?> <a href="admin.php?page=ivaldi_mail_collector_export" class="button add-new-h2"><?php echo __('Copy email addresses', "ivaldi_mail_collector_frontend"); ?></a></h2>
	<form method="get" action="admin.php" id="posts-filter">
		<input type="hidden" name="page" value="ivaldi_mail_collector_admin" />

		<p class="search-box">
			<input type="text" value="" name="s" id="post-search-input"/>
			<input type="submit" class="button" value="<?php echo __('Search for email address'); ?>"/>
		</p>
		<?php ivaldi_mail_collector_table_paginate($perpage, $total); ?>
		<table class="widefat">
			<thead>
				<tr>
					<th><?php echo __('Email'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><?php echo __('Email'); ?></th>
				</tr>
			</tfoot>
			<tbody>
	<?php

    foreach($rows as $row) {
        echo '<tr><td>', $row->email;

        echo '<div class="row-actions"><span class="trash"><a href="admin.php?page=ivaldi_mail_collector_admin&removeid=', $row->id, '">', __('Remove'), '</a></span></div>';
        echo '</td></tr>', PHP_EOL;
    }
	?>
        </tbody>
    </table>
    <?php ivaldi_mail_collector_table_paginate($perpage, $total); ?>
</form>
</div>
<?php
}

function ivaldi_mail_collector_export(){
    global $wpdb;    
	?>

	<div class="wrap">
	<h2><?php echo __('Export', "ivaldi_mail_collector_frontend"); ?> <a href="admin.php?page=ivaldi_mail_collector_admin" class="button add-new-h2">&larr; <?php echo __('Back to overview', "ivaldi_mail_collector_frontend"); ?></a></h2>
		<p><?php echo __('The list below can be copied in order to mail these people.', "ivaldi_mail_collector_frontend"); ?></p>
		
		<form>
		<textarea id="excerpt" name="text_area"><?php
		$rows = $wpdb->get_results('SELECT email FROM ' . $wpdb->prefix . 'ivaldi_mail_collector');
		$total = $wpdb->get_var('SELECT COUNT(id) FROM ' . $wpdb->prefix . 'ivaldi_mail_collector');
		$i = 1;
		foreach($rows as $row) {
			echo $row->email;
			if($i != $total){
				echo ', ';
			}
			$i++;
		}
		?></textarea>
		<p><input type="button" value="<?php echo __('Select email addresses'); ?>" onClick="javascript:this.form.text_area.focus();this.form.text_area.select();"> <?php echo __('Copy afterwards', "ivaldi_mail_collector_frontend"); ?></p>
		</form>
	</div>

	<?php
}

function ivaldi_mail_collector_create_tables() {
	global $wpdb;

	$ivaldi_mail_collector_db_ver = '0.01';

	if(get_option('ivaldi_mail_collector_db_ver') != $ivaldi_mail_collector_db_ver) {

		/* include this for dbDelta */
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		$sql = 'CREATE TABLE ' . $wpdb->prefix . 'ivaldi_mail_collector (
				id INT UNSIGNED NOT NULL AUTO_INCREMENT,
				email VARCHAR(255) NOT NULL,
				UNIQUE (email),
				PRIMARY KEY  (id)
			);';

		dbDelta($sql);

		update_option('ivaldi_mail_collector_db_ver', $ivaldi_mail_collector_db_ver);
	}
}
/* register the installation function */
register_activation_hook(__FILE__, 'ivaldi_mail_collector_create_tables');

/* menu for the mail collector*/
add_action('admin_menu', 'ivaldi_mail_collector_menu');

/* load the widget */
add_action('plugins_loaded','ivaldi_mail_collector_loadplugin');


/* load the language file */
load_plugin_textdomain('ivaldi_mail_collector_frontend', dirname( plugin_basename( __FILE__ ) ) . '/languages/');

?>
