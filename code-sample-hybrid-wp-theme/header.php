<?php
/**
 * Site Header
 *
 * @package      CodeSampleHybridWPTheme
 * @author       Bill Erickson / Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

echo '<!DOCTYPE html>';
tha_html_before();
echo '<html ' . get_language_attributes( 'html' ) . '>';

echo '<head>';
tha_head_top();
wp_head();
tha_head_bottom();
echo '</head>';

echo '<body class="' . esc_attr( join( ' ', get_body_class() ) ) . '" id="top">';
wp_body_open();
tha_body_top();
echo '<div class="site-container">';
echo '<a class="skip-link screen-reader-text" href="#main-content">' . esc_html__( 'Skip to content', 'codesample' ) . '</a>';

tha_header_before();
echo '<header class="site-header" role="banner">';
tha_header_top();
tha_header_bottom();
echo '</header>';
tha_header_after();
echo '<div class="site-inner" id="main-content">';
