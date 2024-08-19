<?php
/**
 * Home
 *
 * @package      CodeSampleHybridWPTheme
 * @author       Bill Erickson / Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

/**
 * Home Content
 */
function be_home_content() {

	$page_id = get_option( 'page_for_posts' );
	if ( empty( $page_id ) ) {
		return;
	}

	$loop = new WP_Query( [ 'post_type' => 'page', 'p' => $page_id ] );
	if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ) {
			$loop->the_post();

			global $post;
			if ( ! empty( $post->post_content ) ) {
				echo '<div class="block-area block-area-home">';
				the_content();
				echo '</div>';
			}

		}
	}
	wp_reset_postdata();
}
add_action( 'tha_content_while_before', 'be_home_content', 20 );

function add_opening_div() {
	echo '<div class="post-loop">';
}
function add_closing_div() {
	echo '</div>';
}
add_action( 'tha_content_while_before', 'add_opening_div', 30 );
add_action( 'tha_content_while_after', 'add_closing_div', 1 );

// Build the page.
require get_template_directory() . '/archive.php';
