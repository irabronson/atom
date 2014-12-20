<?php
/**
 * The template for routing Category posts to their respective pages.
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */
?>

<?php get_header(); ?>
    
    <section id="content">
        
        <div id="articles">
        
        <?php
            
            if ( have_posts() ) :
                
                // ARTISTS posts
                if ( is_category('artists') ) :
                    
                    // Loop is altered within this tempalte
                    get_template_part('content', 'artists');
                    
                // BLOG posts
                elseif ( is_category('blog') ) :
                    
                    while ( have_posts() ) : the_post();
                        get_template_part('content', 'blog');
                    endwhile;
                    
                // MISC. posts
                else :
                    
                    while ( have_posts() ) : the_post();
                        get_template_part('content', get_post_format() );
                    endwhile;
                    
                endif;
                
            else :
                
                // Content Not Found Template
                include('content-not-found.php');
                
            endif;
        ?>
        
        </div>
        
        <div class="pagination">
            <div id="next-page"><?php next_posts_link('Next &rarr;','') ?></div>
        </div>
        
    </section>
    
<?php get_footer(); ?>