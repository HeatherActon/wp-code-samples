<?php
/**
 * Template Tags
 *
 * @package      CodeSampleHybridWPTheme
 * @author       Bill Erickson / Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

/**
 * Entry Category
 *
 */
function be_entry_category() {
	$term = be_first_term();
	if ( ! empty( $term ) && ! is_wp_error( $term ) )
		echo '<p class="entry-category"><a href="' . get_term_link( $term, 'category' ) . '">' . $term->name . '</a></p>';
}

/**
 * Post Summary Title
 *
 */
function be_post_summary_title() {
	global $wp_query;
	$tag = ( is_singular() || -1 === $wp_query->current_post ) ? 'h3' : 'h2';
	echo '<' . $tag . ' class="post-summary__title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></' . $tag . '>';
}

/**
 * Post Summary Image
 *
 */
function be_post_summary_image( $size = 'thumbnail_medium' ) {
	echo '<a class="post-summary__image" href="' . get_permalink() . '" tabindex="-1" aria-hidden="true">' . wp_get_attachment_image( be_entry_image_id(), $size ) . '</a>';
}


/**
 * Entry Image ID
 *
 */
function be_entry_image_id() {
	return has_post_thumbnail() ? get_post_thumbnail_id() : get_option( 'options_be_default_image' );
}

/**
 * Entry Author
 *
 */
function be_entry_author() {
	$id = (int) get_the_author_meta( 'ID' );
	echo '<p class="entry-author"><a href="' . get_author_posts_url( $id ) . '" aria-hidden="true" tabindex="-1">' . get_avatar( $id, 40 ) . '</a><em>by</em> <a href="' . get_author_posts_url( $id ) . '">' . get_the_author() . '</a></p>';
}

/**
 * Entry Date
 *
 */
function be_entry_date() {
	echo '<time datetime="' . get_the_date( 'c' ) . '" class="wp-block-latest-posts__post-date">' . get_the_date() . '</time>';
}