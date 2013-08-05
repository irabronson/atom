<?php
/**
 * The template for displaying posts single Artist posts
 *
 * @package CleanSlate
 * @since CleanSlate 1.0
 */
?>

<section class="primary">
    
    <!-- Artist Image -->
    <figure>
        
        <!-- Artist Title -->
        <h2><?php the_title(); ?></h2>
        
    <?php
        $thumb = get_thumbnail_custom($post->ID, 'artist-detail');
        
        if( $thumb ) {
            echo '<img src="' . $thumb[0] . '" width="786" height="420" alt="' . get_the_title() . '"/>';
        }
    ?>
    </figure>
    
    
    <?php
        // SOCIAL MEDIA LINKS
        // Create array of social media links
        $socials = array(
            'bandcamp' => array(
                'class' => 'bandcamp',
                'link' => get_field('bandcamp')
            ),
            'facebook' => array(
                'class' => 'facebook',
                'link' => get_field('facebook')
            ),
            'instagram'=> array(
                'class' => 'instagram',
                'link' => get_field('instagram')
            ),
            'instagram' => array(
                'class' => 'instagram',
                'link' => get_field('instagram')
            ),
            'itunes' => array(
                'class' => 'itunes',
                'link' => get_field('itunes')
            ),
            'lastfm' => array(
                'class' => 'lastfm',
                'link' => get_field('lastfm')
            ),
            'soundcloud' => array(
                'class' => 'soundcloud',
                'link' => get_field('soundcloud')
            ),
            'tumblr' => array(
                'class' => 'tumblr',
                'link' => get_field('tumblr')
            ),
            'twitter' => array(
                'class' => 'twitter',
                'link' => get_field('twitter')
            ),
            'youtube' => array(
                'class' => 'youtube',
                'link' => get_field('youtube')
            )
        );
        
        // Check for social media links
        if( $socials ) {
    ?>
        <!-- Social Media Links -->
        <ul class="social-links">
    <?php
            
            $socialCount = 1;
            foreach( $socials as $social ) :
                
                // Display Links
                // Only allow up to six social links
                if( $social['link'] && $socialCount <= 6 ) {
    ?>
                <!-- Link for <?php echo $social['class']; ?> -->
                <li>
                    <a href="<?php echo $social['link']; ?>" class="<?php echo $social['class']; ?>">
                        
                        <!-- IRA: This is just a placeholder, you can delete this block of code -->
                        <!-- BEGIN -->
                        <?php 
                            echo $socialCount . ') ' . $social['class'];
                        ?>
                        <!-- END -->
                        
                    </a>
                </li>
                
    <?php
                    $socialCount++;
                }
                
            endforeach;
    ?>
        </ul>
    <?php
        }
    ?>
    
    <?php
        
        // PRESS MATERIALS
        // Check for press materials
        
        $pressMaterials = get_field('press_materials');
            
        if( empty($pressMaterials) != 1 ) {
    ?>
        <!-- Press Materials -->
        <h3>Download Press Materials</h3>
        <ul class="press-materials">
            
    <?php
            $i = 1;
            
            foreach( $pressMaterials as $pressMaterial ) :
    ?>
                <!-- Link for Press Material <?php echo $i; ?> -->
                <li>
                    <a href="<?php echo $pressMaterial['press_material_file']['url']; ?>" target="_blank">
                        
                        <?php 
                            echo $pressMaterial['press_material_title'];
                        ?>
                        
                    </a>
                </li>
                
    <?php
                $i++;
            endforeach;
    ?>
        </ul>
    <?php
        }
    ?>
    
</section>

<section class="secondary">
    
    <!-- About Column -->
    <div class="about column">
        
        <!-- Header -->
        <h3>About</h3>
        
    <?php
        // OFFICIAL SITE
        // Check for Official Site
        if( get_field('official_site') ) {
    ?>
        <!-- Official Site -->
        <p>
            Official site: <a href="<?php the_field('official_site'); ?>"><?php the_field('official_site'); ?></a>
        </p>
        
    <?php
        }
    ?>
        <!-- Post Content -->
        <div>
            <?php the_content(); ?>
        </div>
        
    </div>
    
    <?php
        // PRESS CLIPS
        // Check for Press Clips
        
        $pressClips = get_field('press_clips');
        
        if( empty($pressClips) != 1 ) {
    ?>
    
    <!-- Press Clips Column -->
    <div class="press column">
        
        <!-- Header -->
        <h3>Press Clips</h3>
        
    <?php
        
        $i = 1;
        
        foreach( $pressClips as $pressClip ) :
    ?>
        <!-- Clip <?php echo $i; ?> -->
        <div class="clip">
        
        <?php
            // Check for Quote
            if($pressClip['press_quote']) {
        ?>
            
            <!-- Quote -->
            <p>
                <?php echo $pressClip['press_quote']; ?>
            </p>
            
        <?php
            }
        ?>
        
        <?php
            // Check for Author
            if($pressClip['press_author']) {
        ?>
            
            <!-- Author -->
            <p>
                <?php echo $pressClip['press_author']; ?>
            </p>
            
        <?php
            }
        ?>
        
        <?php
            // Check for Link
            if($pressClip['press_link']) {
        ?>
            
            <!-- Link -->
            <p>
                <?php echo $pressClip['press_link']; ?>
            </p>
            
        <?php
            }
        ?>
            
        </div>
        
    <?php
            $i++;
        endforeach;
    ?>
        
    </div>
    
    <?php
        }
    ?>
    
    
    <?php
        // RELATED ARTISTS
        // Check for Related Artists
        
        $args = array(
            'post_status' => 'publish',
            'category_name' => 'blog',
            'meta_key' => 'related_artists',
            'posts_per_page' => 3
        );
        
        $related_artists = new WP_Query( $args );
        
        $originalPost = $post;
        
        // If any related posts, at all
        if( $related_artists->have_posts() ) {
            
            $related_artist_matches = array();
            
            // Find posts that match to this artist
            while ( $related_artists->have_posts() ) : $related_artists->the_post();
                
                $values = get_post_meta( $post->ID, 'related_artists');
                
                foreach ( $values as $value ) :
                    
                    if( in_array($originalPost->ID, $value) ) {
                        $related_artist_matches[] = $post;
                    }
                    
                endforeach;
                
            endwhile;
            
            // Write matching posts to page
            // Using custom array with WP_Post_Object
            if ( count($related_artist_matches) > 0 ) {
    ?>
                <!-- Related Blog Posts Column -->
                <div class="blog column">
                    
                    <!-- Header -->
                    <h3>Related News</h3>
    <?php
                foreach ( $related_artist_matches as $related_artist_match ) :
    ?>
                    <a href="<?php echo $related_artist_match->guid; ?>" title="<?php echo $related_artist_match->post_title; ?>"><?php echo $related_artist_match->post_title; ?></a>
                    <p><?php echo date('n/d', strtotime($related_artist_match->post_date)); ?></p>
    <?php
                endforeach;
    ?>
            </div>
    <?php
            }
        }
    ?>
    
    <?php
        // TWITTER
        // Check for Twitter
        //
        // Twitter column is hidden by CSS
        // Unless there are tweets
        
    ?>
        <div id="twitter-artist" class="twitter column">
            
            <!-- Header -->
            <h3>Twitter</h3>
            
            <!-- Twitter feed will be here -->
            <div class="tweet"></div>
            
        </div>
    
    <?php
        // TOUR
        // Content filled dynamically
        //
        // Tour column is hidden by CSS
        // Unless there are tweets
    ?>
        <!-- Tour Dates Column -->
        <div class="tour column">
        <!-- Header -->
        <h3>Tour</h3>
        
        <div class="tour-dates"></div>
        
        </div>
        
</section>