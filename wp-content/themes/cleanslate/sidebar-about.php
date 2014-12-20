<?php
/**
 * The Sidebar for the About page.
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */
?>

<div id="sidebar">
    
    <!-- Writing Blog Callout -->
    <div class="block">
        <p>Amy's Writing Site</p>
        <a href="http://www.amysciarrettowriter.com/">amysciarrettowriter.com</a>
        <p>Interviews, reviews, etc.</p>
    </div>
    
    <?php
        $args = array(
            'category_name' => 'blog',
            'orderby'=> 'date',
            'order' => 'DESC',
            'posts_per_page' => 1
        );
        
        $blog_query = new WP_Query($args);
        
        // The Loop
        if ( $blog_query->have_posts() ) :
            
            while ( $blog_query->have_posts() ) : $blog_query->the_post();
    ?>
            <!-- Most Recent Blog Post -->
            <div class="block">
                
                <!-- Post Link -->
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    
                    <p>From the Blog</p>
                    
                    <!-- Post Title -->
                    <p><?php the_title(); ?></p>
                    
                    <!-- Post Date -->
                    <p><?php echo get_the_date('n/j'); ?></p>
                    
                </a>
                
            </div>
    <?php
            endwhile;
        else :
            // do nothing
        endif;
    ?>
    
    <?php
        // Retrieve Tour Slideshow Widget from content-tour-slideshow.php
        get_template_part('content', 'tour-slideshow');
    ?>
    
</div><!-- #sidebar -->