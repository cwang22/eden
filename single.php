<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package eden
 */

get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-9 col-sm-12">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'single' ); ?>

					<?php eden_post_nav(); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // End of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div>
		<div class="col-lg-3 col-md-3 col-lg-3 col-sm-12">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
