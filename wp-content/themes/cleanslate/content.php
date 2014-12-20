<?php
/**
 * The general template for displaying content.
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-post-id="<?php echo date('m-d-Y', strtotime(get_the_date())); ?>">
    
    <div class="post-header">
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>"><?php the_title();?></a>
        </h2>
        
        <p class="post-date">
            <?php the_date(); ?>
        </p>
    </div>
    
    <div class="text-container">
        <?php the_content(); ?>
    </div>
    
</article>