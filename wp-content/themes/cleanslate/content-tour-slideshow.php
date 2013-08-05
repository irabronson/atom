<?php
/**
 * The template for showing bands on tour in a slideshow.
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */
?>


<?php
    $args = array(
        'category_name' => 'artists',
        'orderby'=> 'title',
        'order' => 'ASC'
    );
    
    $artist_query = new WP_Query($args);
    
    // The Loop
    if ( $artist_query->have_posts() ) :
?>
        <!-- On Tour Slideshow -->
        <div id="on-tour-slideshow-container">
            <div id="on-tour-slideshow">
<?php
            while ( $artist_query->have_posts() ) : $artist_query->the_post();
                $band = get_the_title();
                $bandSlug = rawurlencode(strtolower($band));
                $thumb = get_thumbnail_custom($post->ID, 'artist-thumbnail');
                
                if( $thumb ) {
                    $source = $thumb[0];
                } else {
                    $source = '';
                }
?>
                <a href="<?php the_permalink(); ?>" class="artist" data-band="<?php echo $bandSlug; ?>" data-id="<?php echo $post->ID; ?>">
                    <img src="<?php echo $source; ?>" width="356" height="248" alt="<?php the_title(); ?>" />
                </a>
<?php            
            endwhile;
?>
            </div><!-- #on-tour-slideshow -->
            <div id="slideshow-caption">
                <p class="current"></p>
            </div>
        </div><!-- #on-tour-slideshow-container -->
<?php
    else :
        // do nothing
    endif;
?>