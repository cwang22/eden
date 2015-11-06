<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package eden
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function eden_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'eden_body_classes' );

/**
 *
 */
function eden_content_more_link( $more ) {
    return '<div class="more"><a class="more-link btn btn-primary" href="'. get_permalink( get_the_ID() ) . '">Continue reading <i class="fa fa-chevron-right"></i></a></div>';
}
add_filter( 'the_content_more_link', 'eden_content_more_link' );

function eden_excerpt_more($more) {
    global $post;
    return '...<div class="more"><a class="more-link btn btn-primary" href="'. get_permalink($post->ID) . '">Continue reading <i class="fa fa-chevron-right"></i></a></div>';
}
add_filter('excerpt_more', 'eden_excerpt_more');