<?php
/**
 * The page template for the Home page.
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */
?>

<!-- Slideshow -->
<section class="primary">
<?php echo do_shortcode("[metaslider id=64]"); ?>
</section>

<!-- Artist Listing -->
<section class="secondary">
    <h2>Aggressive Publicity and Music Marketing</h2>
        
        <?php
            $args = array(
                'category_name' => 'artists',
                'orderby'=> 'title',
                'order' => 'ASC'
            );
            
            $artist_query = new WP_Query($args);
            
            // The Loop
            if ( $artist_query->have_posts() ) {
        ?>
        
        <ul class="artists-list">
        
        <?php
                $onTourCount = 0;
                
                while ( $artist_query->have_posts() ) : $artist_query->the_post();
                    
                    $band = get_the_title();
                    $bandSlug = rawurlencode(strtolower($band));
        ?>
                    <!-- Artist: <?php the_title(); ?> -->
                    <li class="artist" data-band="<?php echo $bandSlug; ?>" data-id="<?php echo $post->ID; ?>">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </li>
        <?php
                endwhile;
        ?>
        
        </ul>
        
        <div class="on-tour-symbol">On Tour Now</div>
                
        <?php
            } else {
                // no posts found
            }
            
            // Restore original Post Data
            wp_reset_postdata();
        ?>
        
</section>

<!-- In-site links -->
<section class="tertiary">
    <ul>
        <li>
            <!-- Sevices -->
            <a href="<?php echo get_page_link(11); ?>">Services</a>
            <!-- About -->
            <a href="<?php echo get_page_link(12); ?>">About</a>
            <!-- Blog -->
            <a href="<?php echo get_page_link(9); ?>">Blog</a>
        <li>
    </ul>
</section>