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
be_post_summary_image( 'featured-cpt-archives' );

echo '<div class="post-summary__content">';
be_post_summary_title();
echo '</div>';

echo '</article>';
