<?php
/**
 * The Template for displaying all single posts.
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */
?>

<?php get_header(); ?>
    
<section id="content">
    
<?php
    // Sidebar defaults to none
    $sidebar = false;
    
    if ( have_posts() ) :
?>
    <div id="articles">
        
    <?php
        if( in_category('artists') ) :
            
            while ( have_posts() ) : the_post();
                get_template_part('content', 'artists-detail' );
            endwhile;
            
        elseif( in_category('blog') ) :
            
            // Set Sidebar to load
            $sidebar = true;
            
            while ( have_posts() ) : the_post();
                get_template_part('content', 'blog-detail' );
            endwhile;
            
        endif;
    ?>
    
    </div>
    
<?php
    else :
        // Content Not Found Template
        include('content-not-found.php');
    
    endif;

?>
    
<?php
    
    // Load Sidebar
    if( $sidebar === true ) {
        get_sidebar();
    }
    
?>
    
</section>
    
<?php get_footer(); ?>