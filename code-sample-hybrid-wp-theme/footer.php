<?php
/**
 * Site Footer
 *
 * @package      CodeSampleHybridWPTheme
 * @author       Bill Erickson / Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

use CodeSampleHybridWPTheme\Block_Areas;

echo '</div>'; // .site-inner

Block_Areas\show( 'before-footer' );

tha_footer_before();
echo '<footer class="site-footer" role="contentinfo"><div class="wrap">';
tha_footer_top();
tha_footer_bottom();
echo '</div></footer>';
tha_footer_after();

echo '</div>';
tha_body_bottom();
wp_footer();

echo '</body></html>';
