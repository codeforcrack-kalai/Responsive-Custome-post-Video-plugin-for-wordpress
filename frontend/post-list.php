<?php
/*

    TABLE OF CONTENTS
    ---------------------------
     1. General
     2. Popular Videos
     3. Related Videos
     4. All Videos   
     */


/*******************************************************************
 ********************** 1. General ************************************
 *******************************************************************/


/**
 * REGISTER CSS FILES
 */

add_action('wp_enqueue_scripts', 'frontend_style_register');
function frontend_style_register()
{
    wp_register_style('video_list_style', plugins_url('/assets/css/style.css', __FILE__));
    wp_enqueue_style('video_list_style');
    // wp_enqueue_script( 'namespaceformyscript', 'http://locationofscript.com/myscript.js', array( 'jquery' ) );
}

function video_show_case_demo($atts)
{
    $Content = "<style>\r\n";
    $Content .= "h3.demoClass {\r\n";
    $Content .= "color: #26b158;\r\n";
    $Content .= "}\r\n";
    $Content .= "</style>\r\n";
    $Content .= '<h3 class="demoClass">Check it out!</h3>';

    return $Content;
}



/*******************************************************************
 ********************** 2 .Related Videos ******************************
 *******************************************************************/


/**
 * Show Recent Related Posts 
 */

function related_posts_function($atts)
{
    $html='';
    extract(shortcode_atts(array(
        'posts' => 10000,
        'post_type' => 'video',
        'post_title' => 'Related Videos',
    ), $atts));

   // $return_string = '<ul>';
    query_posts(array('orderby' => 'date', 'order' => 'DESC', 'showposts' => $posts, 'post_type' => $post_type, 'post__not_in' => array(get_the_ID()),
    ));

   

    $html .= '<div class="main"><h1>'.$post_title.'</h1><ul class="cards">';   
    
    
    if (have_posts()):
        while (have_posts()): the_post();
            $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $the_cat = get_the_category();
            $category_name = $the_cat[0]->cat_name;
            $category_link = get_category_link( $the_cat[0]->cat_ID );
            $post_date = get_the_date( 'l F j, Y' );
          //  $return_string .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            $html .= '<li class="cards_item"><div class="card"><a href="' . get_permalink() . '"><div class="card_image"><img src="' . esc_url($featured_img_url) . '" class="inner-img"></div><div class="card_content"><h2 class="card_title">' . get_the_title() . '</h2> </a><p class="card_text"><a href="'.$category_link.'">'.$category_name.'</a><br>'.$post_date.'</p></div></div></li>';

        endwhile;
    endif;




    $html .= '</ul></div>';

    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

    $return_string =$html;

    wp_reset_query();
    return $return_string;
}



function show_related_videos_custome_video_post_page( $content ) {


 
    if(is_singular('video'))
    {    
        $content .= '<span class="custom_fds">Welcome</span>';

    $content.= do_shortcode('[related-posts posts="10" post_type="video"  post_title="Related Videos" ]');
   

  
    return $content;
    }
  }
  
  add_filter( 'the_content', 'show_related_videos_custome_video_post_page' );




/*******************************************************************
 ********************** 3 .Popular Videos ******************************
 *******************************************************************/

/**
 * Show Popular Posts
 */


function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);


function wpb_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    wpb_set_post_views($post_id);
}


add_action( 'wp_head', 'wpb_track_post_views');



function popular_posts_function($atts)
{

   

    extract(shortcode_atts(array(
        'posts' => 10000,
        'post_type' => 'video',
        'post_title' => 'Related Videos',
    ), $atts));

   // $return_string = '<ul>';
    query_posts(array('meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'showposts' => $posts, 'post_type' => $post_type, 'post__not_in' => array(get_the_ID()),
    ));



    $html .= '<div class="main"><h1>'.$post_title.'</h1><ul class="cards">';   
    
    
    if (have_posts()):
        while (have_posts()): the_post();
            $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $the_cat = get_the_category();
            $category_name = $the_cat[0]->cat_name;
            $category_link = get_category_link( $the_cat[0]->cat_ID );
            $post_date = get_the_date( 'l F j, Y' );
          //  $return_string .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            $html .= '<li class="cards_item"><div class="card"><a href="' . get_permalink() . '"><div class="card_image"><img src="' . esc_url($featured_img_url) . '" class="inner-img"></div><div class="card_content"><h2 class="card_title">' . get_the_title() . '</h2> </a><p class="card_text"><a href="'.$category_link.'">'.$category_name.'</a><br>'.$post_date.'</p></div></div></li>';

        endwhile;
    endif;




    $html .= '</ul></div>';

    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

    $return_string .= $html;

    wp_reset_query();
    return $return_string;

}




/*******************************************************************
 ********************** 4 .All Videos Videos ******************************
 *******************************************************************/


function all_posts_function($atts)
{
    extract(shortcode_atts(array(
        'posts' => 10000,
        'post_type' => 'video',
        'post_title' => 'All Videos',
    ), $atts));

   // $return_string = '<ul>';
    query_posts(array('orderby' => 'date', 'order' => 'DESC', 'showposts' => $posts, 'post_type' => $post_type,
    ));



    $html .= '<div class="main"><h1>'.$post_title.'</h1><ul class="cards">';   
    
    
    if (have_posts()):
        while (have_posts()): the_post();
            $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $the_cat = get_the_category();
            $category_name = $the_cat[0]->cat_name;
            $category_link = get_category_link( $the_cat[0]->cat_ID );
            $post_date = get_the_date( 'l F j, Y' );
          //  $return_string .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            $html .= '<li class="cards_item"><div class="card"><a href="' . get_permalink() . '"><div class="card_image"><img src="' . esc_url($featured_img_url) . '" class="inner-img"></div><div class="card_content"><h2 class="card_title">' . get_the_title() . '</h2> </a><p class="card_text"><a href="'.$category_link.'">'.$category_name.'</a><br>'.$post_date.'</p></div></div></li>';

        endwhile;
    endif;




    $html .= '</ul></div>';

    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

    $return_string .= $html;

    wp_reset_query();
    return $return_string;
}










 