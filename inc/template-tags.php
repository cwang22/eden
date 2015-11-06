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
	        	$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'eden' ), $category->name ) ) . '" class="label label-primary"><i class="fa fa-folder-open"></i> ' . esc_html( $category->name ) . '</a>' . $separator;
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
	        	$output .= '<a href="' . esc_url( get_category_link( $tag->term_id ) ) . '" alt="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'eden' ), $tag->name ) ) . '" class="label label-primary"><i class="fa fa-tag"></i> ' . esc_html( $tag->name ) . '</a>' . $separator;
			}
			echo '<div class="links tag-links">';
    		echo trim( $output, $separator );
    		echo '</div>';
		}
	}



	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

		?><div class="links comment-link"><a class="label label-primary" href="<?php the_permalink(); ?>#comments"><i class="fa fa-commenting"></i> <?php comments_number( '0', '1', '%' ); ?></a></div><?php

	}
	
	if(null != get_edit_post_link()) {

		?><div class="links edit-link"><a class="label label-primary" href="<?php echo get_edit_post_link(); ?>"><i class="fa fa-pencil"></i> <?php echo esc_html__( 'Edit', 'eden' ); ?></a></div><?php
	}	

}
endif;

if ( ! function_exists( 'eden_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return void
 */
function eden_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous col-xs-6"> <?php next_posts_link( __( '<i class="fa fa-chevron-left"></i> Older posts', 'eden' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next col-xs-6"><?php previous_posts_link( __( 'Newer posts <i class="fa fa-chevron-right"></i>', 'eden' ) ); ?> </div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'eden_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */
function eden_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="nav-links">
			<div class="nav-previous col-xs-6">
				<?php
				previous_post_link( '%link', _x( '<i class="fa fa-chevron-left"></i> %title', 'Previous post link', 'eden' ) );
				?>
			</div>
			<div class="nav-next col-xs-6">
				<?php
				next_post_link(     '%link',     _x( '%title <i class="fa fa-chevron-right"></i>', 'Next post link',     'eden' ) );
				?>
			</div>
			
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'eden_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function eden_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'eden' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'eden' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) { echo get_avatar( $comment, $args['avatar_size'] ); } ?>
					<?php printf( __( '%s', 'eden' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'eden' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit', 'eden' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'eden' ); ?></p>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>',
				) ) );
			?>
		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for eden_comment()


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
