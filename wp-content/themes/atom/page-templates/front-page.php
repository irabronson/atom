<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
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
				$homepageCustomFields = get_post_custom();
			?>


				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post -->

				<?php if( isset($homepageCustomFields['tagline']) ) : ?>
						<div id="tagline">
							<?php echo $homepageCustomFields['tagline'][0]; ?>
						</div>
				<?php endif; ?>
				
			<?php endwhile; // end of the loop. ?>

			<div id="artists-list">
				<h2>List of Artists</h2>
				<ul>
				<?php 
					$args = array(
							'post_type' => 'artist'
						);
					$artistsQuery = new WP_Query($args);

					$anyOnTour = null;
					while ( $artistsQuery->have_posts() ) : $artistsQuery->the_post(); 
						$customFields = get_post_custom();
					?>
						<li>
							<a href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a>
							<?php if( isset($customFields['on_tour'][0]) && $customFields['on_tour'][0] == 'on') {
								$anyOnTour = true;
							?>
								<span id="on-tour">ON TOUR</span>
							<?php } ?>
						</li>

				<?php endwhile; // end of the loop. ?>
				</ul>
				<?php if($anyOnTour == true): ?>
					<p>On tour notation here
				<?php endif; ?>
			</div>

			<p>Services/About/Blog

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_template_part( 'content', 'twitter' ); ?>
<?php get_footer(); ?>