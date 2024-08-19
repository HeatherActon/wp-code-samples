<?php
/**
 * Archive - Story
 *
 * @package      CodeSampleHybridWPTheme
 * @author       Bill Erickson / Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

use CodeSampleHybridWPTheme\Block_Areas;

/**
 * After Post
 */
function be_after_stories_archive() {
	Block_Areas\show( 'after-stories-archive' );
}
add_action( 'tha_content_bottom', 'be_after_stories_archive', 8 );

remove_action( 'tha_content_loop', 'be_default_loop' );
add_action( 'tha_content_loop', 'be_story_loop' );

// Content sidebar.
add_filter( 'be_page_layout', 'be_return_content_sidebar' );

/**
 * Body Class
 *
 * @param array $classes Body classes.
 */
function be_archive_body_class( $classes ) {
	$classes[] = 'archive';
	return $classes;
}
add_filter( 'body_class', 'be_archive_body_class' );

// Build the page.
require get_template_directory() . '/index.php';
