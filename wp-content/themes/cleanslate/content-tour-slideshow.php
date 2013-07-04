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
        
        $onTourCount = 0;
?>
        <!-- On Tour Slideshow -->
        <div id="on-tour-slideshow" class="block">
        
<?php
        while ( $artist_query->have_posts() ) : $artist_query->the_post();
            
            $onTour = get_field('on_tour');
            
            if( $onTour === true ) {
                $onTourClass = 'on-tour';
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
                
                </a>
            </article>
            
<?php
                $onTourCount++;
?>
        </div><!-- #on-tour-slideshow -->
<?php
            }
            
        endwhile;
    else :
        
    endif;
?>