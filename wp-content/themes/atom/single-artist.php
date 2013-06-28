<?php
/**
 * The Template for displaying individual Artist pages
 *
 */

get_header(); ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->

					<?php // check if artist is on tour
						$customFields = get_post_custom();
						if(isset($customFields['on_tour'][0]) && $customFields['on_tour'][0] == 'on'): 
					?>
							<span id="on-tour">ON TOUR</span>
						<?php endif; ?> 

					<p><?php the_post_thumbnail(); ?>

					<div class="social-links">
						<?php 
							$listOfLinks = atom_get_artist_social_links();
							foreach($listOfLinks as $link) {
								if( !empty($customFields[$link][0]) ): ?>
									<span id="<?php echo $link; ?>"><a href="<?php echo $customFields[$link][0]; ?>"><?php echo $link; ?></a></span>
								<?php endif; 
							}
						?>
						<?php if(isset($customFields['official_site'][0])): ?>
							<span id="official-site">
								Official Site:
								<a href="http://<?php echo $customFields['official_site'][0]; ?>"><?php echo $customFields['official_site'][0]; ?></a>
							</span>
						<?php endif; ?>
					</div>

					<div class="about">
						<h2>About</h2>
						<?php the_content(); ?>
					</div>

					<?php the_content(); ?>

				</article><!-- #post -->

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>