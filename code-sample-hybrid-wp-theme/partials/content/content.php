<?php
/**
 * Singular partial
 *
 * @package      CodeSampleHybridWPTheme
 * @author       Bill Erickson / Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

echo '<article class="' . esc_attr( join( ' ', get_post_class() ) ) . '">';

if ( be_has_action( 'tha_entry_top' ) ) {
	echo '<header class="entry-header">';
	tha_entry_top();
	echo '</header>';
}

echo '<div class="entry-content">';
tha_entry_content_before();
the_content( '', true );

wp_link_pages(
	[
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'codesample' ),
		'after'  => '</div>',
	]
);

tha_entry_content_after();
echo '</div>';

if ( be_has_action( 'tha_entry_bottom' ) ) {
	echo '<footer class="entry-footer">';
	tha_entry_bottom();
	echo '</footer>';
}

echo '</article>';
