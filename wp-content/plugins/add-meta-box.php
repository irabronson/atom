<?php
/**
 * @package Add_Meta_Box
 * @version 1.0
 */
/*
Plugin Name: Add Meta Box
Plugin URI: http://wp.smashingmagazine.com/2011/10/04/create-custom-post-meta-boxes-wordpress/
Description: Add a custom meta box to your edit screen. Based on a wp-tuts tutorial.
Author: Christopher Davis (modified by Saki Sato)
Version: 1.0
*/

/* Create one or more meta boxes to be displayed on the post editor screen. */
function add_custom_meta_boxes() {

    add_meta_box(
        'related-artists',                          // Unique ID
        esc_html__( 'Related Artists', 'example' ), // Title
        'related_artists_meta_box',                 // Callback function
        'post',                                     // Admin page (or post type)
        'side',                                     // Context
        'default'                                   // Priority
    );
}

function get_post_meta_artists($object) {
    
    // Check for pre-existing artist values
    $values = get_post_meta( $object->ID, 'related_artists');
    _log($values);
    // Query Artist Posts
    $args = array(
        'category_name' => 'artists',
        'orderby'=> 'title',
        'order' => 'ASC'
    );
    
    $artist_query = get_posts($args);
    
    if ( $artist_query ) :
        
        foreach ( $artist_query as $artist ) : setup_postdata($artist);
            
            // Artists values
            $artistKey = str_replace('-', '_', sanitize_title( $artist->post_name ) );
            $artistID = $artistKey . '_check';
            $artistTitle = $artist->post_title;
            $artistCheck = isset( $values[0][$artistID] ) ? esc_attr( $values[0][$artistID] ) : 'off';
            _log($artistCheck);
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
function related_artists_meta_box( $object, $box ) {
    
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

/* Save the meta box's post metadata. */
function save_related_artists_meta() {
    global $post;
    $post_id = $post->ID;
    
    _log('save post');
    _log($post_id);
    
    /* Verify the nonce before proceeding. */
    if ( !isset( $_POST['related_artists_nonce'] ) || !wp_verify_nonce( $_POST['related_artists_nonce'], basename( __FILE__ ) ) )
        return $post_id;
    
    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );
    
    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;
    
    $artists = get_post_meta_artists($post);
    
    foreach( $artists as $artist ) :
        $artistKey = $artist['id'];
        // $chk = isset( $_POST[$artistKey] ) ? 'on' : 'off';
        
        // add_post_meta( $post_id, $artistKey, $chk, true );
        // update_post_meta( $post_id, $artistKey, $chk );
        
        // _log($artist);
        
        /* Get the posted data and sanitize it for use as an HTML class. */
        $related_artist_value = ( isset( $_POST[$artistKey] ) ? 'on' : 'off' );
        
        _log($related_artist_value);
        
        $relatedArtists[$artistKey] = $related_artist_value;
        
    endforeach;
    
    /* Get the posted data and sanitize it for use as an HTML class. */
    $new_meta_value = $relatedArtists;
    _log('New Value');
    _log($new_meta_value);
    /* Get the meta key. */
    $meta_key = 'related_artists';
    
    /* Get the meta value of the custom field key. */
    $meta_value = get_post_meta( $post_id, $meta_key );
    _log('Old Value');
    _log($meta_value);
    /* If a new meta value was added and there was no previous value, add it. */
    if ( $new_meta_value && '' == $meta_value )
        add_post_meta( $post_id, $meta_key, $new_meta_value, true );
    
    /* If the new meta value does not match the old value, update it. */
    elseif ( $new_meta_value && $new_meta_value != $meta_value )
        update_post_meta( $post_id, $meta_key, $new_meta_value );
    
    /* If there is no new meta value but an old value exists, delete it. */
    elseif ( '' == $new_meta_value && $meta_value )
        delete_post_meta( $post_id, $meta_key, $meta_value );
}

/* Meta box setup function. */
function custom_meta_boxes_setup() {
    _log('setup');
    /* Add meta boxes on the 'add_meta_boxes' hook. */
    add_action( 'add_meta_boxes', 'add_custom_meta_boxes' );
    
    /* Save post meta on the 'save_post' hook. */
    add_action( 'save_post', 'save_related_artists_meta' );
}

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'custom_meta_boxes_setup' );
add_action( 'load-post-new.php', 'custom_meta_boxes_setup' );

?>