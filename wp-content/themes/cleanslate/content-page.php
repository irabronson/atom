<?php
/**
 * The general template used for displaying page content in page.php.
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <?php
        // Define args to get attachments
        $args = array(
            'post_parent' => $post->ID,
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );
        
        // Get image attachments
        $attachments = get_posts( $args );
        
        if ( $attachments ) :
            $noImageClass = '';
        else :
            $noImageClass = 'no-image';
        endif;
    ?>
    
    <div id="text" class="text-container <?php echo $noImageClass; ?>">
        <?php the_content(); ?>
    </div>
    
    <?php
        if ( $attachments ) :
            // Insert images uploaded to post
            foreach ( $attachments as $attachment ) {
                
                $image = wp_get_attachment_image( $attachment->ID, 'page' );
                $imageUrl = wp_get_attachment_image_src( $attachment->ID, 'page' );
    ?>
            <figure>
                <?php echo $image; ?>
            </figure>
            <figcaption>
                <?php
                    // Insert image description
                    echo $attachment->post_content;
                ?>
            </figcaption>
    <?php
              }
        else :
            // do nothing
        endif;
    ?>
    
</article>