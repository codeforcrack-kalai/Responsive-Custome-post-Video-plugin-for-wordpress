<?php
/**
 * Plugin Name: Video Showcase
 * Plugin URI: https://www.boopin.com
 * Description: Display Custom post type video in Wordpress using Short code
 * Version: 0.1
 * Text Domain: video-showcase-wordpress-plugin-demo
 * Author: Boopin
 * Author URI: https://www.boopin.com
 */

/*HOW TO DIPLAY POST CONTENTS*/

/**
 * Just Place following short code wordpress
 * whereever you want to show the video contents
 *  
 *[related-posts posts="10" post_type="video"  post_title="Related Videos" ]
 *
 * [all-posts posts="10" post_type="video"]
 * 
 * [category-posts posts="10" post_type="videos" category_name_main="abudhabi" ]
 * 
 *[popular-posts posts="10" post_type="video"  post_title="Popular Videos" ]

 *
 * [related-posts posts="10" post_type="video"  post_title="Related Videos" ]

*[popular-posts posts="10" post_type="video"  post_title="Popular Videos" ]

  */
 
     
include( plugin_dir_path( __FILE__ ) . 'backend/core.php');
include( plugin_dir_path( __FILE__ ) . 'frontend/post-list.php');

       
     
function register_shortcodes(){

    add_shortcode('video-showcase', 'video_show_case_demo');

    add_shortcode('related-posts', 'related_posts_function');

    add_shortcode('popular-posts', 'popular_posts_function');

    add_shortcode('category-posts', 'category_posts_function');

    add_shortcode('all-posts', 'all_posts_function');

    
 }

 add_action( 'init', 'register_shortcodes');






  

 