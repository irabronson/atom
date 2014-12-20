<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */

get_header(); ?>
    
    <?php if ( have_posts() ) : ?>
        
        <section id="content">
            
            <?php get_sidebar(); ?>
            
            <?php
                
                $count = 0;
            ?>
            
            <div id="articles">
            
            <?php
                while ( have_posts() ) : the_post();
                    
                    if ( in_category('browse') ) :
                        get_template_part( 'content', get_post_format() );
                        
                        $count++;
                    else :
                        // don't show
                    endif;
                    
                endwhile;
                
                if ($count === 0) :
                    echo '<p class="not-found">Sorry, no results found.</p>';
                endif;
            ?>
            
            </div>
            
        </section>
        
    <?php else :
        // Content Not Found Template
        include('content-not-found.php');
        
    endif; ?>
    
<?php get_footer(); ?>