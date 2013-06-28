<?php
/**
 * Template Name: About Page
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); 
?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php 
				while ( have_posts() ) : the_post();
				$aboutPageCustomFields = get_post_custom();
			?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php if( isset($aboutPageCustomFields['intro']) ) : ?>
						<div id="tagline">
							<?php echo $aboutPageCustomFields['intro'][0]; ?>
						</div>
				<?php endif; ?>
				
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->
	<div id="latest-blog-post">
		<h2>Latest Blog Post</h2>
		<?php 
			$args = array('numberposts' => '1');
			$latestPosts = wp_get_recent_posts($args); 
			foreach( $latestPosts as $latestPost ): 
		?>
				<a href="<?php echo get_permalink($latestPost["ID"]); ?>" title="<?php echo esc_attr($latestPost["post_title"]); ?>">
					<?php echo $latestPost["post_title"]; ?>
				</a>
			<?php endforeach; ?>
	</div>

	<div class="on-tour-widget">
	</div>

	<p>LINK TO WRITING SITE

<?php get_template_part( 'content', 'twitter' ); ?>
<?php get_footer(); ?>