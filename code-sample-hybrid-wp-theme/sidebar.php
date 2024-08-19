<?php
/**
 * Sidebar
 *
 * @package      CodeSampleHybridWPTheme
 * @author       Bill Erickson / Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

use CodeSampleHybridWPTheme\Block_Areas;

if ( ! function_exists( 'be_page_layout' ) ) {
	return;
}

$layout = be_page_layout();
if ( ! is_singular( 'recipe' ) && ! is_post_type_archive( 'recipe' ) && ! is_post_type_archive( 'story' ) && ! in_array( $layout, array( 'content-sidebar', 'sidebar-content' ), true ) ) {
	return;
}

if ( ! apply_filters( 'be_display_sidebar', true ) ) {
	return;
}

tha_sidebars_before();

echo '<aside class="sidebar-primary" role="complementary">';
tha_sidebar_top();

// See which widgets were chosen on the page.
$id = 0;
if ( ( is_singular( 'recipe' ) || is_post_type_archive( 'recipe' ) ) && get_option( 'page_for_recipe' ) ) {
	$id = get_option( 'page_for_recipe' );
}
elseif ( is_post_type_archive( 'story' ) && get_option( 'page_for_story' ) ) {
	$id = get_option( 'page_for_story' );
}
elseif ( ( is_singular( 'post' ) || is_post_type_archive( 'post' ) ) && get_option( 'page_for_posts' ) ) {
	$id = get_option( 'page_for_posts' );
}
else {
	$id = get_the_ID();
}

if ( 0 !== $id ) {
	// See how many potential widgets we have.
	$block_areas = Block_Areas\block_areas();
	$count       = 0;
	foreach ( $block_areas as $block_area ) {
		if ( str_contains( $block_area, 'widget' ) ) {
			$count++;
		}
	}

	$widget_choices = array();
	for ( $i = 1; $i <= $count; $i++ ) {
		$widget_choices[] = get_post_meta( $id, 'be_widget_' . $i );
	}

	// Display only those widgets.
	if ( ! empty( $widget_choices ) ) {
		foreach ( $widget_choices as $key => $value ) {
			if ( array_key_exists( '0', $value ) && $value[0] ) {
				Block_Areas\show( $value[0] );
			}
		}
	}
}

tha_sidebar_bottom();
echo '</aside>';

tha_sidebars_after();
