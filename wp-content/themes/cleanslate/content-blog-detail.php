<?php
/**
 * The template for displaying posts single Blog posts
 *
 * @package CleanSlate
 * @since CleanSlate 1.0
 */
?>

<!-- Post ID: <?php the_ID(); ?> -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <!-- Post Date -->
    <p><?php echo get_the_date('n/j'); ?></p>
    
    <!-- Post Title -->
    <h3><?php the_title(); ?></h3>
    
    <!-- Social Icons -->
    <div></div>
    
    <!-- Post Content -->
    <div><?php the_content(); ?></div>
    
    <?php
        
        $tags = get_the_tags($post->ID);
        
        if( $tags ) :
    ?>
    
    <!-- Post Tags -->
    <div>
        Tagged in:
        
    <?php
            foreach($tags as $tag) :
    ?>
        
        <a href="<?php get_tag_link($tag->term_id); ?>">
            <?php echo $tag->name; ?>
        </a>&nbsp;
        
    <?php
            endforeach;
    ?>
    
    </div>
    
    <?php
        endif;
    ?>
    
</article>