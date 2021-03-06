<?php
/**
 * Cleanslate functions and definitions
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */

// DEBUGGING
if(!function_exists('_log')){
    function _log( $message ) {
        if( WP_DEBUG === true ){
            if( is_array( $message ) || is_object( $message ) ){
                error_log( print_r( $message, true ) );
            } else {
                error_log( $message );
            }
        }
    }
}

 if ( ! function_exists( 'cleanslate_setup' ) ):
/**
* Sets up theme defaults and registers support for various WordPress features.
*
* Note that this function is hooked into the after_setup_theme hook, which runs
* before the init hook. The init hook is too late for some features, such as indicating
* support post thumbnails.
*
* To override cleanslate_setup() in a child theme, add your own cleanslate_setup to your child theme's
* functions.php file.
*/
function cleanslate_setup() {
 /**
  * Add default posts and comments RSS feed links to head
  */
 add_theme_support( 'automatic-feed-links' );
 
 /**
  * This theme uses wp_nav_menu() in one location.
  */
 register_nav_menus( array(
     'primary' => __( 'Primary Menu', 'cleanslate' ),
 ) );
 
 /**
  * Add support for the Gallery and Video Post Formats
  */
 // add_theme_support( 'post-formats', array( 'gallery' ) );
}
endif; // cleanslate_setup

/**
* Tell WordPress to run cleanslate_setup() when the 'after_setup_theme' hook is run.
*/
add_action( 'after_setup_theme', 'cleanslate_setup' );

/**
* Register widgetized area and update sidebar with default widgets
*/

if ( function_exists ('register_sidebar')) { 
 // register_sidebar( array(
 //     'name' => __( 'cat-posts' ),
 //     'id' => 'cat-posts'
 // ) );
 
 register_sidebar();
}
// add_action( 'init', 'cleanslate_widgets_init' );

// Add and enqueue jQuery
function register_jquery() {
    wp_enqueue_script( 'jquery' );
}
add_action('wp_enqueue_scripts', 'register_jquery');

// Add Artists to menu
function artists_menu() {
    add_submenu_page('edit.php', 'Artists', 'Artists', 'manage_options', 'edit.php?category_name=artists' );
}
add_action('admin_menu', 'artists_menu');

function get_first_attachment() {
    global $post;

    $id = $post->ID;
    $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'DESC', 'orderby' => 'menu_order ASC') );
    $tpl = get_bloginfo('template_url');
    // $nothing = $tpl.'/nothing.jpg';
    $nothing = '';

    if ( empty($attachments) )
        return $nothing;

        foreach ( $attachments as $id => $attachment )
            $link = wp_get_attachment_url($id);
        return $link;
}

// Custom Thumbnail Retreival
include('php/get-thumbnail-custom.php');

function the_excerpt_max_charlength($charlength) {
    $excerpt = get_the_excerpt();
    $charlength++;
    
    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        echo '[...]';
    } else {
        echo $excerpt;
    }
}

function get_category_tags($args) {
    global $wpdb;
    $tags = $wpdb->get_results
    ("
        SELECT DISTINCT terms2.term_id as tag_id, terms2.name as tag_name, null as tag_link
        FROM
            wp_posts as p1
            LEFT JOIN wp_term_relationships as r1 ON p1.ID = r1.object_ID
            LEFT JOIN wp_term_taxonomy as t1 ON r1.term_taxonomy_id = t1.term_taxonomy_id
            LEFT JOIN wp_terms as terms1 ON t1.term_id = terms1.term_id,

            wp_posts as p2
            LEFT JOIN wp_term_relationships as r2 ON p2.ID = r2.object_ID
            LEFT JOIN wp_term_taxonomy as t2 ON r2.term_taxonomy_id = t2.term_taxonomy_id
            LEFT JOIN wp_terms as terms2 ON t2.term_id = terms2.term_id
        WHERE
            t1.taxonomy = 'category' AND p1.post_status = 'publish' AND terms1.term_id IN (".$args['categories'].") AND
            t2.taxonomy = 'post_tag' AND p2.post_status = 'publish'
            AND p1.ID = p2.ID
        ORDER by tag_name
    ");
    
    return $tags;
}

// Adding Thumbnails
add_theme_support( 'post-thumbnails' );

// Adding Custom Thumbnail Size
add_image_size( 'artist-thumbnail', 356, 248, true );

// Adding Custom Image Size
add_image_size( 'artist-detail', 786, 420, true );

// // Alter the Loop for homepage
// function most_recent_post( $query ) {
//     if ( $query->is_home() && $query->is_main_query() ) :
//             $query->set('posts_per_page', '1');
//             $query->set('cat', '2');
//     endif;
// }
// add_action( 'pre_get_posts', 'most_recent_post' );


// Add "last" class to last post in loop
add_filter('post_class', 'my_post_class');
function my_post_class($classes){
    global $wp_query;
    if(($wp_query->current_post+1) == $wp_query->post_count) $classes[] = 'last';
    return $classes;
}

// Add category class to body in single posts
add_filter('body_class','add_category_to_single');
function add_category_to_single($classes) {
     if ( is_single() ) {
        global $post;
        foreach((get_the_category($post->ID)) as $category) {
            // add category slug to the $classes array
            $classes[] = $category->category_nicename;
        }
     }
     
     if ( is_page() ) {
        global $post;
        // add page title to the $classes array
        $classes[] = 'page-' . $post->post_name;
     }
     
     // return the $classes array
     return $classes;
}

// Prevent from adding link to inserted imgaes
update_option('image_default_link_type','none');

/**
 * This theme was built with PHP, Semantic HTML, CSS, love, and a Toolbox.
 */