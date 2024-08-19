<?php
/**
 * Archive partial
 *
 * @package      CodeSampleHybridWPTheme
 * @author       Bill Erickson / Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

echo '<article class="post-summary">';
if ( ! is_page_template( 'search.php' ) ) {
	be_post_summary_image();
}

echo '<div class="post-summary__content">';
be_post_summary_title();
echo '<div class="post-summary__excerpt">';
the_excerpt();
echo '</div>';
if ( ! is_page_template( 'search.php' ) ) {
	be_entry_date();
}
echo '</div>';

echo '</article>';
