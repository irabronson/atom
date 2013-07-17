<?php
/**
 * The template for displaying posts single Artist posts
 *
 * @package CleanSlate
 * @since CleanSlate 1.0
 */
?>

<?php
    
    // Check for Custom Fields
    
    if( get_field('official_site') ) {
        
    }
    
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
        
        if( $pressMaterials ) {
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
        
        if( $pressClips ) {
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
        $values = get_post_custom( $post->ID );
        
        $artistKey = str_replace('-', '_', $post->post_name);
        $artistID = $artistKey . '_check';
        
        // if( $values[$artistID] ) {
        
    ?>
    
    <!-- Related Blog Posts Column -->
    <div class="blog column">
        
        <!-- Header -->
        <h3>Related News</h3>
        
        
    </div>
    <?php
        // }
    ?>
    
    <?php
        // TWITTER
        // Check for Twitter
        $twitter = true;
        
        if( $twitter ) {
        
    ?>
    
    <!-- Twitter Feed Column -->
    <div class="twitter column">
        
        <!-- Header -->
        <h3>Twitter</h3>
        
        <?php
            
        ?>
        <div id="twitter-feed"></div>
        
        <script type="text/javascript">
            var getTweetsURL = templateDirectoryUrl + '/php/get-tweets.php';
            var artistProfile = 'farawaybeaches';
            var noOfTweets = 1;
            
            twitterFeed(getTweetsURL, artistProfile, noOfTweets);
        </script>
        
    </div>
    
    <?php
        }
    ?>
    
    <?php
        // TOUR
        // Content filled dynamically
        // JS function called in header with show-tour-dates.js
    ?>
    
</section>
    