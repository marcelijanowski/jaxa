=== Plugin Name ===
Contributors: violetcharm
Donate link: http://ziming.org
Tags: post,views,analytics,post-views,coverage
Requires at least: 2.8
Tested up to: 3.3.1

A plugin logging how many times your post/page has been visited, supporting cache plugin, with detailed analysis pages and powerful external invoking functions. (import views data from wp-postviews if used.)

== Description ==

A plugin logging how many times your post/page has been visited, supporting cache plugin, with detailed analysis pages and powerful external invoking functions. (import views data from wp-postviews if used.)

[Demo](http://ziming.org/dev/post-views)

== Installation ==

1. Unzip the archive and put the 'post-views' folder into your plugins folder (/wp-content/plugins/).
2. Activate the plugin from the Plugins menu.

== Usage ==
1. Add the following code to you template's single.php and index.php or another place where you want to show it.

if(function_exists('get_post_views')) {  _e(' , Views: '); echo get_post_views('normal');     } 
 
if(function_exists('get_post_views')) {  _e(' , Index: ');  echo get_post_views('robot');      } 
 
if(function_exists('get_post_views')) { _e(' , Today Views: '); echo get_post_views('normal','today');} 
 
if(function_exists('get_post_views')) { _e(' , Week Index: ');  echo get_post_views('robot','week'); } 
 
php if(function_exists('get_post_views_time')) {  
              _e('Last indexed : ');  echo get_post_views_time('robot','m-d H:i:s');
} 
 
php if(function_exists('get_post_views_time')) {  
              _e('Last viewed : ');  echo get_post_views_time('normal','m-d H:i:s');
}
 
The parameter 'm-d H:i:s' can be changed to your favorite format: such as 'Y-m-j H:i:s'.

For external invoking pls visit [Advanced Usage](http://ziming.org/dev/post-views/usage)

2. You can add a 'post-views' widget to you sidebar, it includes 'most view','least view' and so on.

= Changing the CSS =
No till now.
== Screenshots ==
1. post views summary
2. show post views
3. post views trend
4. post views ranking list
5. post views analytics
5. post views SUMMARY
== Frequently Asked Questions ==
No till now.
== Changelog ==
2011-03-21  version 2.5.0  It¡¯s a completely new version, which cannot upgraded from the lowest versions. It¡¯s the most stable version, with stable invoking functions (wont be changed later), and all features that i want to apply on.

2011-03-21  version 1.9.0  (1) fixed bug in week summary, (2) add feature of 'excerpt' views analytics, (3) changes in invoking functions, (4) optimize database table structure.

2010-12-03  version 1.7.0  support cache plugin such as wp super cache.

2010-11-10  version 1.6.0  new features.

2010-11-08  version 1.5.0  new features.

2010-11-02  version 1.2.3  fixed a bots logging error.
== Upgrade Notice ==
No till now.