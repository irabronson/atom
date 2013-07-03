<?php
/**
 * The page template for the Artists category page.
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
        
        $onTourCount = 0;
        
        while ( $artist_query->have_posts() ) : $artist_query->the_post();
            
            $onTour = get_field('on_tour');
            
            if( $onTour === true ) {
                $onTourClass = 'on-tour';
                
                $onTourCount++;
            } else {
                $onTourClass = 'not-on-tour';
            }
?>
            <!-- Artist: <?php the_title(); ?> -->
            <article id="post-<?php the_ID(); ?>" class="<?php echo $onTourClass; ?>">
                
                <!-- Artist Link -->
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    
                    <!-- Artist Thumbnail -->
                    <figure>
                <?php
                    $thumb = get_thumbnail_custom($post->ID, 'artist-thumbnail');
                    
                    if( $thumb ) {
                        echo '<img src="' . $thumb[0] . '" width="356" height="248" alt="' . get_the_title() . '"/>';
                    }
                ?>
                    </figure>
                    
                    <!-- Artist Title -->
                    <p>
                        <?php the_title(); ?>
                    </p>
                    
                </a>
            </article>
            
<?php
        endwhile;
        
    else :
        // no posts found
    endif;
    
    // Restore original Post Data
    wp_reset_postdata();
?>