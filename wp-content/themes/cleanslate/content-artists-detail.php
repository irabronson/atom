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
    
</section>

<section class="secondary">
    
    <!-- About Column -->
    <div class="about column">
        
        <!-- Header -->
        <h3>About</h3>
        
    <?php
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
        // Check for Related Artist
        $values = get_post_custom( $post->ID );
        
        $artistKey = str_replace('-', '_', $post->post_name);
        $artistID = $artistKey . '_check';
        
        if( $values[$artistID] ) {
        
    ?>
    
    <!-- Related Blog Posts Column -->
    <div class="blog column">
        
        <!-- Header -->
        <h3>Related News</h3>
        
        
    </div>
    <?php
        }
    ?>
    
    <?php
        // Check for Twitter
        $twitter = true;
        
        if( $twitter ) {
        
    ?>
    
    <!-- Related Blog Posts Column -->
    <div class="twitter column">
        
        <!-- Header -->
        <h3>Twitter</h3>
        
        
    </div>
    
    <?php
        }
    ?>
    
    <?php
        // Check for Tour
        $tour = true;
        
        if( $tour ) {
        
    ?>
    
    <!-- Related Blog Posts Column -->
    <div class="tour column">
        
        <!-- Header -->
        <h3>Tour</h3>
        
        
    </div>
    
    <?php
        }
    ?>
    
</section>
    