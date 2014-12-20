<?php
/**
 * The page template for the About page.
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */
?>

<!-- Content Header -->
<section class="primary">
    
    <h3>An independent, full service boutique music PR firm</h3>
    <h4>with over 15 years experience, we deliver aggressive publicity and artist imaging tailored for maximum exposure</h4>
    
</section>

<!-- Main Content -->
<section class="secondary">
    
    <!-- The Content -->
    <div id="text"><?php the_content(); ?></div>
    
    <!-- Sidebar -->
    <?php get_sidebar('about'); ?>
    
</section>