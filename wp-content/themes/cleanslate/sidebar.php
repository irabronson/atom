<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package CleanSlate
 * @since CleanSlate 0.1
 */
?>

<div id="sidebar">
    
    <?php
        // Retrieve Tour Slideshow Widget from content-tour-slideshow.php
        get_template_part('content', 'tour-slideshow');
    ?>
    
    <!-- Writing Blog Callout -->
    <div>
        <p>Amy's Writing Site</p>
        <a href="http://www.amysciarrettowriter.com/">amysciarrettowriter.com</a>
        <p>Interviews, reviews, etc.</p>
    </div>
    
</div><!-- #sidebar -->