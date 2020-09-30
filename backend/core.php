<?php

/**
 * INCLUDE ACF PLUGIN
 *
 */


// Check if ACF Classes exists:
if (!class_exists('acf_pro') || !class_exists('acf')) {

    // Define path and URL to the ACF plugin.
    define('MY_ACF_PATH', plugin_dir_path(__FILE__) . 'vendor/advanced-custom-fields/');
    define('MY_ACF_URL', plugin_dir_path(__FILE__) . 'vendor/advanced-custom-fields/');

    // Include the ACF plugin.
    include_once MY_ACF_PATH . 'acf.php';

    // (Optional) Hide the ACF admin menu item.
    add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
    function my_acf_settings_show_admin($show_admin)
    {
        return false;
    }

}

if (class_exists('acf_pro') || class_exists('acf')) {
    // (Optional) Hide the ACF admin menu item.
    add_filter('acf/settings/show_admin', 'my_acf_settings_hide_admin');
    function my_acf_settings_hide_admin($show_admin)
    {
        return false;
    }
}

/**
 * REGISTER CUSTOME POST TYPE VIDEO
 */

function cptui_register_my_cpts_video()
{

    /**
     * Post Type: Videos.
     */

    $labels = [
        "name" => __("Videos", "beaver-corporate-lite"),
        "singular_name" => __("Video", "beaver-corporate-lite"),
    ];

    $args = [
        "label" => __("Videos", "beaver-corporate-lite"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => ["slug" => "video", "with_front" => true],
        "query_var" => true,
        "menu_icon" => "dashicons-format-video",
        "supports" => ["title", "editor", "thumbnail", "page-attributes"],
        "taxonomies" => ["category", "post_tag"],
    ];

    register_post_type("video", $args);
}

add_action('init', 'cptui_register_my_cpts_video');

/**
 * REGISTER CUSTOME POST OPTIONS
 */


function video_query_post_type_register($query) {
    if ( is_category() && ( ! isset( $query->query_vars['suppress_filters'] ) || false == $query->query_vars['suppress_filters'] ) ) {
        $query->set( 'post_type', array( 'post', 'video' ) );
        return $query;
    }
}
add_filter('pre_get_posts', 'video_query_post_type_register');



/**
 * BACKEND MENU OPTION
 */

//Register Settings For a Plugin


function myplugin_register_settings() {
    add_option( 'myplugin_option_name', 'This is my option value.');
    register_setting( 'myplugin_options_group', 'myplugin_option_name', 'myplugin_callback' );
    register_setting( 'myplugin_options_group', 'responsive', 'myplugin_callback' );



 }
 add_action( 'admin_init', 'myplugin_register_settings' );

//Creating an Options Page
 function myplugin_register_options_page() {
    add_options_page('Page Title', 'Video Showcase', 'manage_options', 'video_showcase', 'myplugin_options_page');
  }
  add_action('admin_menu', 'myplugin_register_options_page');



  function myplugin_options_page()
{
  //content on page goes here

  ?>
  <div>
  
  <h2>Videos Showcase</h2>
  <p>Usefull Short codes for display videos</p>
  <p>

  Just Place following short code wordpress
  whereever you want to show the video contents<br><br>

  <h3>Short Codes :</h3>
  
 [related-posts posts="10" post_type="video"  post_title="Related Videos" ]<br><br>
 
  [all-posts posts="10" post_type="video"]<br><br>
  
  [category-posts posts="10" post_type="videos" category_name_main="abudhabi" ]<br><br>
  
 [popular-posts posts="10" post_type="video"  post_title="Popular Videos" ]<br><br>

 
 [related-posts posts="10" post_type="video"  post_title="Related Videos" ]<br><br>


</p>

<h3>Additional Option :</h3>

<p>posts  : Number of posts need to display <br>
   Post type : Video  or you can use this plugin short code for display another post types like post ,audio,page etc..<br>
   post_title : For Title of post<br>
   category_name_main : You can change to which category you need to display<br>
   all-posts : Display All posts of particular post type<br>
   related-posts  : Display All posts of particular post type<br>
   category-posts : Display post of particular<br>



</p>
  </div>
<?php
}
