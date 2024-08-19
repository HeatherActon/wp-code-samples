<?php
/**
 * Single Post - Recipe
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
function be_after_story_post() {
	Block_Areas\show( 'after-story-post' );
}
add_action( 'tha_content_while_after', 'be_after_story_post', 8 );

// Content.
add_filter( 'be_page_layout', 'be_return_content' );

// Build the page.
require get_template_directory() . '/index.php';
