<?php
/**
 * The template for the Browse category.
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */
?>

<?php get_header(); ?>
        
    <section id="content">
    
    <?php
        
        if ( have_posts() ) :
            
            include('content.php');
                
        else :
            // Content Not Found Template
            include('content-not-found.php');
            
        endif;
    ?>
    
    </section>
    
<?php get_footer(); ?>