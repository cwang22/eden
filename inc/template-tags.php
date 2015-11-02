<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package eden
 */

if ( ! function_exists( 'eden_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function eden_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'eden' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> ' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( '%s', 'post author', 'eden' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> ' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'eden_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function eden_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {

		
		$categories = get_the_category();
		$separator = '';
		$output = '';
		if ( ! empty( $categories ) ) {
			
	    	foreach( $categories as $category ) {
	        	$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'eden' ), $category->name ) ) . '" class="label label-primary"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>' . esc_html( $category->name ) . '</a>' . $separator;
			}
			echo '<div class="links category-links">';
    		echo trim( $output, $separator );
    		echo '</div>';
		}
		
		

		$tags = get_the_tags();
		$separator = '';
		$output = '';
		if ( ! empty( $tags ) ) {
	    	foreach( $tags as $tag ) {
	        	$output .= '<a href="' . esc_url( get_category_link( $tag->term_id ) ) . '" alt="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'eden' ), $tag->name ) ) . '" class="label label-primary"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span>' . esc_html( $tag->name ) . '</a>' . $separator;
			}
			echo '<div class="links tag-links">';
    		echo trim( $output, $separator );
    		echo '</div>';
		}
	}



	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

		?><div class="links comment-link"><a class="label label-primary" href="<?php the_permalink(); ?>#comments"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span><?php comments_number( '0', '1', '%' ); ?></a></div><?php

	}
	
	if(null != get_edit_post_link()) {

		?><div class="links edit-link"><a class="label label-primary" href="<?php echo get_edit_post_link(); ?>"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span><?php echo esc_html__( 'Edit', 'eden' ); ?></a></div><?php
	}	

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function eden_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'eden_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'eden_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so eden_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so eden_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in eden_categorized_blog.
 */
function eden_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'eden_categories' );
}
add_action( 'edit_category', 'eden_category_transient_flusher' );
add_action( 'save_post',     'eden_category_transient_flusher' );
