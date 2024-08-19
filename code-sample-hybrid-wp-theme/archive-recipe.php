<?php
/**
 * Archive - Recipe
 *
 * @package      CodeSampleHybridWPTheme
 * @author       Bill Erickson / Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

remove_action( 'tha_content_loop', 'be_default_loop' );
add_action( 'tha_content_loop', 'be_recipe_loop' );

add_action( 'tha_content_bottom', 'be_recipe_archive_bottom' );
function be_recipe_archive_bottom() {
	?>
	<div style="grid-column-start: 1; grid-column-end: 4; margin-top: var(--wp--custom--layout--block-gap-medium);"
		class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
		<div class="wp-block-button is-style-outline" style="text-transform:capitalize"><a
				class="wp-block-button__link wp-element-button" href="/your-healthcare-team/">What Is a Healthcare Team and
				Why Is It Important to My Care? &gt;</a></div>
	</div>
	<?php
}
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
