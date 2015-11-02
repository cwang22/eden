<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package eden
 */

?>

	</div><!-- #content -->
    
	<footer id="colophon" class="site-footer container" role="contentinfo">
        <div class="row">
            <div class="col-lg-12">
                <div class="site-info">
                    <?php printf( esc_html__( 'Theme %1$s by %2$s.', 'eden' ), 'eden', '<a href="http://seewang.me" rel="designer">seewang.me</a>' ); ?>
                </div><!-- .site-info -->
            </div>
        </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
