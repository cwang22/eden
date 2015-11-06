<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package eden
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</div><!-- .entry-header -->
	<div class="entry-meta">
		<?php eden_posted_on(); ?>
	</div><!-- .entry-meta -->
	<div class="entry-content">
		
		<?php
			the_content();
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eden' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php eden_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
