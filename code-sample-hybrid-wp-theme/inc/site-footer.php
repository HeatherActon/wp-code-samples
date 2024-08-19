<?php
/**
 * Site Footer
 *
 * @package      CodeSampleHybridWPTheme
 * @subpackage   site-header/01
 * @author       Bill Erickson / Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

use CodeSampleHybridWPTheme\Blocks\Social_Links;

/**
 * Site Footer
 */
function be_site_footer() {
	// Footer bottom start.
	echo '<div class="footer-top">';

	// Logo
	echo '<a href="' . esc_url( home_url() ) . '" rel="home" class="site-footer__logo" aria-label="' . esc_attr( get_bloginfo( 'name' ) ) . ' Home">' . be_icon( [ 'icon' => 'logo-alt', 'size' => false, 'width' => 182, 'height' => 41 ] ) . '</a>';

	// Footer nav
	echo '<nav class="nav-menu" role="navigation">';
	if ( has_nav_menu( 'footer' ) ) {
		wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu', 'container_class' => 'nav-footer' ) );
	}
	echo '</nav>';

	echo '</div>'; // Footer top end.

	// Footer bottom start.
	echo '<div class="footer-bottom">';

	// Ionis Logo
	echo '<a href="' . esc_url( home_url() ) . '" rel="home" class="site-footer__logo" aria-label="' . esc_attr( get_bloginfo( 'name' ) ) . ' Home">' . be_icon( [ 'icon' => 'logo-partner', 'size' => false, 'width' => 115, 'height' => 40 ] ) . '</a>';

	// Social links
	$facebook_url  = get_field( 'codesample_facebook_profile_url', 'option' );
	$instagram_url = get_field( 'codesample_instagram_profile_url', 'option' );
	if ( $facebook_url || $instagram_url ) {
		echo '<div class="socials">';
		echo '<a href="' . esc_url( $facebook_url ) . '" target="_blank">' . be_icon( [ 'icon' => 'facebook', 'size' => 24 ] ) . '</a>';
		echo '<a href="' . esc_url( $instagram_url ) . '" target="_blank">' . be_icon( [ 'icon' => 'instagram', 'size' => 24 ] ) . '</a>';
		echo '</div>';
	}

	echo '<div class="footer-legal">';
	// Copyright
	echo '<p>&copy; ' . date( 'Y' ) . ' Ionis Pharmaceuticals&reg; is a registered trademark of Ionis Pharmaceuticals, Inc.</p>';
	echo '<p>All rights reserved. ' . esc_html( get_field( 'codesample_site_version', 'option' ) ) . '</p>';
	echo '<p>Unless otherwise noted, photographs are not of actual patients or doctors.</p>';

	// Footer legal nav
	echo '<nav class="nav-menu" role="navigation">';
	if ( has_nav_menu( 'footer-legal' ) ) {
		wp_nav_menu( array( 'theme_location' => 'footer-legal', 'menu_id' => 'footer-legal-menu', 'container_class' => 'nav-footer-legal' ) );
	}
	echo '</nav>';
	echo '</div>';



	echo '</div>'; // Footer bottom end.
}
add_action( 'tha_footer_top', 'be_site_footer' );
