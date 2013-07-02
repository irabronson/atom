<?php
/**
 * The template to display thumbnails.
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */
?>

<a href="<?php the_permalink(); ?>">
    <div class="caption">
        <h4 class="post-title">
            <?php the_title(); ?>
        </h4>
        <p class="post-date">
            <?php echo get_the_date(); ?>
        </p>
        <p class="post-excerpt">
            <?php echo substr(get_the_excerpt(), 0,225); ?>
        </p>
    </div>
    
    <figure class="post-thumb">
        <img src="<?php echo get_thumbnail_custom($post->ID, 'browse-thumbnail'); ?>" width="392" height="392" alt="<?php the_title(); ?>" />
    </figure>
</a>