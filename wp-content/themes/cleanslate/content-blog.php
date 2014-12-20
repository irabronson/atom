<?php
/**
 * The page template for the Blog category page.
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */
?>

<!-- Post ID: <?php the_ID(); ?> -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <!-- Post Date -->
    <p><?php echo get_the_date('n/j'); ?></p>
    
    <!-- Post Title -->
    <h3><?php the_title(); ?></h3>
    
    <!-- Post Link -->
    <a href="<?php the_permalink(); ?>">Read More &gt;</a>
    
</article>