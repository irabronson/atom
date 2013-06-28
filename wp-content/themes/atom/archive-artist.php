<?php
/**
 * The template for displaying all artists
 */

get_header(); 

$query = new WP_Query( 
				array(
					'post_type' => 'artist' 
					, 'orderby' => 'title'
					, 'order' => 'ASC' 
				) 
			);

?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( $query->have_posts() ) : ?>
			<header>
				<h1>Artists</h1>
			</header>

			<?php
			/* Start the Loop */
			while ( $query->have_posts() ) : $query->the_post(); ?>
				<div style="float: left;">
					<a href="<?php echo get_permalink(); ?>">
						<?php the_post_thumbnail('medium'); ?>
						<br><?php echo the_title(); ?>
					</a>
					<?php // check if artist is on tour
						$customFields = get_post_custom();
						if(isset($customFields['on_tour'][0]) && $customFields['on_tour'][0] == 'on'): 
					?>
							<span id="on-tour">ON TOUR</span>
						<?php endif; ?> 
				</div>
			<?php endwhile; ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_template_part( 'content', 'twitter' ); ?>
<?php get_footer(); ?>