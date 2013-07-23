<?php
/**
 * @package Custom_Meta_Box
 * @version 1.0
 */
/*
Plugin Name: Custom Meta Box
Plugin URI: http://wp.tutsplus.com/tutorials/plugins/how-to-create-custom-wordpress-writemeta-boxes/
Description: Add a custom meta box to your edit screen. Based on a wp-tuts tutorial.
Author: Christopher Davis (modified by Saki Sato)
Version: 1.0
*/

function get_artists( $object ) {
    
    $values = get_post_custom( $object->ID );
    
    // Query Artist Posts
    $args = array(
        'category_name' => 'artists',
        'orderby'=> 'title',
        'post_status'=> 'publish',
        'order' => 'ASC'
    );
    
    $artist_query = get_posts($args);
    
    if ( $artist_query ) :
        
        foreach ( $artist_query as $artist ) : setup_postdata($artist);
            
            // Artists values
            $artistKey = str_replace('-', '_', sanitize_title( $artist->post_name ) );
            $artistID = $artistKey . '_check';
            $artistTitle = $artist->post_title;
            $artistCheck = isset( $values[$artistID][0] ) ? esc_attr( $values[$artistID][0] ) : 'off';
            
            // Add artists to array
            $artists[$artistKey] = array(
                'id' => $artistID,
                'title' => $artistTitle,
                'checked' => $artistCheck
            );
        endforeach;
        
    else :
        // do nothing
    endif;
    
    return $artists;
}

/* Display the post meta box. */
function cd_meta_box_cb( $object ) {
    
    _log('printing');
    
    wp_nonce_field( basename( __FILE__ ), 'related_artists_nonce' );
?>
    <p>
        <?php _e( "Choose artist(s) related to this post.", 'example' ); ?>
    </p>
<?php
    // Call function to get Artist post data
    $artists = get_post_meta_artists($object);
    
    // Add checkboxes if there are Artists
    if ( !empty($artists) ) :
?>
        <ul>
<?php
        foreach( $artists as $artist ) :
?>
            <li>
                <input type="checkbox" id="<?php echo $artist['id']; ?>" name="<?php echo $artist['id']; ?>" <?php checked( $artist['checked'], 'on' ); ?> />
                <label for="<?php echo $artist['id']; ?>"><?php echo $artist['title']; ?></label>
            </li>
<?php
        endforeach;
?>
        </ul>
<?php
        
    else :
        // do nothing
    endif;
}

// Save Meta Box Information
function cd_meta_box_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
    
    // if our nonce isn't there, or we can't verify it, bail 
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'related_artists_nonce' ) ) return; 
    
    // THIS RETURNS AN ERROR
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post', $post_id ) ) return;
    
    // This is purely my personal preference for saving check-boxes
    // $chk = isset( $_POST['related_artist_check'] ) ? 'on' : 'off';
    // 
    $artists = get_artists();
    
    foreach( $artists as $artist ) :
        $artistKey = $artist['id'];
        $chk = isset( $_POST[$artistKey] ) ? 'on' : 'off';
        
        add_post_meta( $post_id, $artistKey, $chk, true );
        update_post_meta( $post_id, $artistKey, $chk );
        
    endforeach;
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function cd_meta_box_add() {

    add_meta_box(
        'related-artists',                          // Unique ID
        esc_html__( 'Related Artists', 'example' ), // Title
        'cd_meta_box_cb',                 // Callback function
        'post',                                     // Admin page (or post type)
        'side',                                     // Context
        'default'                                   // Priority
    );
}

/* Meta box setup function. */
function add_meta_boxes_setup() {
    _log('setup');
    /* Add meta boxes on the 'add_meta_boxes' hook. */
    // add_action( 'add_meta_boxes', 'cd_meta_box_cb' );
    
    /* Save post meta on the 'save_post' hook. */
    // add_action( 'save_post', 'cd_meta_box_save' );
}

/* Fire our meta box setup function on the post editor screen. */
// add_action( 'load-post.php', 'add_meta_boxes_setup' );
// add_action( 'load-post-new.php', 'add_meta_boxes_setup' );

?>