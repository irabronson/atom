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

function get_artists() {
    global $post;
    $values = get_post_custom( $post->ID );
    
    // Query Artist Posts
    $args = array(
        'category_name' => 'artists',
        'orderby'=> 'title',
        'order' => 'ASC'
    );
    
    $artist_query = new WP_Query($args);
    
    $artists = array();
    
    if ( $artist_query->have_posts() ) :
        
        while ( $artist_query->have_posts() ) : $artist_query->the_post();
            
            // Artists values
            $artistKey = str_replace('-', '_', $post->post_name);
            $artistID = $artistKey . '_check';
            $artistTitle = get_the_title();
            $artistCheck = isset( $values[$artistID][0] ) ? esc_attr( $values[$artistID][0] ) : 'off';
            
            // Add artists to array
            $artists[$artistKey] = array(
                'id' => $artistID,
                'title' => $artistTitle,
                'checked' => $artistCheck
            );
            
        endwhile;
    else :
        // do nothing
    endif;
    
    wp_reset_postdata();
    
    return $artists;
}

// Add Meta Box
add_action( 'add_meta_boxes', 'cd_meta_box_add' );
function cd_meta_box_add()
{
    add_meta_box( 'related-artists', 'Related Artist(s)', 'cd_meta_box_cb', 'post', 'side', 'high' );
}

// Display Meta Box
function cd_meta_box_cb()
{
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'related_artists_nonce', 'meta_box_nonce' );
    
    // Call function to get Artist post data
    $artists = get_artists();
    
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
add_action( 'save_post', 'cd_meta_box_save' );
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

?>