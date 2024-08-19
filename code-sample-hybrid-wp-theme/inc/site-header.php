<?php
/**
 * Site Header
 *
 * @package      CodeSampleHybridWPTheme
 * @subpackage   site-header/01
 * @author       Bill Erickson / Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

/**
 * Register nav menus
 */
function be_register_menus() {
	register_nav_menus(
		[
			'primary'      => esc_html__( 'Primary Navigation Menu', 'codesample' ),
			'secondary'    => esc_html__( 'Secondary Navigation Menu', 'codesample' ),
			'footer'       => esc_html__( 'Footer Navigation Menu', 'codesample' ),
			'footer-legal' => esc_html__( 'Legal Navigation Menu', 'codesample' ),
		]
	);

}
add_action( 'after_setup_theme', 'be_register_menus' );

/**
 * Site Header
 */
function be_site_header_top() {

	echo '<div id="header-top"><div class="wrap">';

	// Logo
	echo '<a href="' . esc_url( home_url() ) . '" rel="home" class="site-header__logo hidden-mobile" aria-label="' . esc_attr( get_bloginfo( 'name' ) ) . ' Home">' . be_icon( [ 'icon' => 'logo', 'size' => false, 'width' => 149, 'height' => 34 ] ) . '</a>';

	// Start right side, fluid width gridspace
	echo '<div id="header-top-right">';

	// Secondary nav
	echo '<nav class="nav-menu" role="navigation">';
	if ( has_nav_menu( 'secondary' ) ) {
		wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_id' => 'secondary-menu', 'container_class' => 'nav-secondary' ) );
	}
	echo '</nav>';

	// Search field
	echo be_render_search();

	// Social links
	$facebook_url  = get_field( 'codesample_facebook_profile_url', 'option' );
	$instagram_url = get_field( 'codesample_instagram_profile_url', 'option' );
	if ( $facebook_url || $instagram_url ) {
		echo '<div class="socials">';
		echo '<a href="' . esc_url( $facebook_url ) . '" target="_blank">' . be_icon( [ 'icon' => 'facebook', 'size' => 24 ] ) . '</a>';
		echo '<a href="' . esc_url( $instagram_url ) . '" target="_blank">' . be_icon( [ 'icon' => 'instagram', 'size' => 24 ] ) . '</a>';
		echo '</div>';
	}

	// End right side, fluid width gridspace
	echo '</div>';

	echo '</div></div>';
}
add_action( 'tha_header_top', 'be_site_header_top', 10 );
function be_site_header() {
	echo '<div id="header-bottom"><div class="wrap">';
	echo '<a href="' . esc_url( home_url() ) . '" rel="home" class="site-header__logo hidden-desktop" aria-label="' . esc_attr( get_bloginfo( 'name' ) ) . ' Home">' . be_icon( [ 'icon' => 'logo', 'size' => false, 'width' => 149, 'height' => 34 ] ) . '</a>';

	echo '<div class="site-header__toggles">';
	echo be_search_toggle();
	echo be_mobile_menu_toggle();
	echo '</div>';

	echo '<nav class="nav-menu" role="navigation">';
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container_class' => 'nav-primary' ) );
	}
	echo '</nav>';
	echo '</div></div>';
}
add_action( 'tha_header_bottom', 'be_site_header', 11 );

function be_featured_image() {
	if ( ( is_singular( 'post' ) || is_home() ) && get_option( 'page_for_posts' ) ) {
		$image_id = has_post_thumbnail( get_option( 'page_for_posts' ) ) ? get_post_thumbnail_id( get_option( 'page_for_posts' ) ) : get_option( 'options_be_default_image' );

		echo '<div class="featured-image">';
		echo wp_get_attachment_image( $image_id, 'full' );
		echo '</div>';
	}
	elseif ( ( is_singular( 'recipe' ) || is_post_type_archive( 'recipe' ) ) && get_option( 'page_for_recipe' ) ) {
		$image_id = has_post_thumbnail( get_option( 'page_for_recipe' ) ) ? get_post_thumbnail_id( get_option( 'page_for_recipe' ) ) : get_option( 'options_be_default_image' );

		echo '<div class="featured-image">';
		echo wp_get_attachment_image( $image_id, 'full' );
		echo '</div>';
	}
	elseif ( ( is_singular( 'story' ) || is_post_type_archive( 'story' ) ) && get_option( 'page_for_story' ) ) {
		$image_id = has_post_thumbnail( get_option( 'page_for_story' ) ) ? get_post_thumbnail_id( get_option( 'page_for_story' ) ) : get_option( 'options_be_default_image' );

		echo '<div class="featured-image">';
		echo wp_get_attachment_image( $image_id, 'full' );
		echo '</div>';
	}
	elseif ( is_singular() && has_post_thumbnail() ) {
		echo '<div class="featured-image">';
		echo wp_get_attachment_image( be_entry_image_id(), 'full' );
		echo '</div>';
	}
}
add_action( 'tha_header_after', 'be_featured_image', 100 );
/**
 * Search toggle
 */
function be_search_toggle() {
	$output = '<button aria-label="Search" id="launch-modal-search" class="search-toggle">';
	$output .= be_icon( array( 'icon' => 'search', 'class' => 'open' ) );
	$output .= be_icon( array( 'icon' => 'close', 'class' => 'close' ) );
	$output .= '</button>';
	return $output;
}

/**
 * Mobile menu toggle
 */
function be_mobile_menu_toggle() {
	$output = '<button aria-label="Menu" class="menu-toggle">';
	$output .= be_icon( array( 'icon' => 'menu', 'class' => 'open' ) );
	$output .= be_icon( array( 'icon' => 'close', 'class' => 'close' ) );
	$output .= '</button>';
	return $output;
}

/**
 * Add a dropdown icon to top-level menu items.
 *
 * @param string $output Nav menu item start element.
 * @param object $item   Nav menu item.
 * @param int    $depth  Depth.
 * @param object $args   Nav menu args.
 * @return string Nav menu item start element.
 * Add a dropdown icon to top-level menu items
 */
function be_nav_add_dropdown_icons( $output, $item, $depth, $args ) {

	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $output;
	}

	if ( isset( $args->depth ) && 1 === $args->depth ) {
		return $output;
	}

	if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {

		// Add SVG icon to parent items.
		$icon = be_icon( array( 'icon' => 'chevron-down-solid', 'size' => 12 ) );

		// Optional - two icons based on open/close state
		//$icon = be_icon( [ 'icon' => 'plus', 'class' => 'open' ] ) . be_icon( [ 'icon' => 'minus', 'class' => 'close' ] );

		$output .= sprintf(
			'<button aria-label="Submenu Dropdown" class="submenu-expand" tabindex="-1">%s</button>',
			$icon
		);
	}

	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'be_nav_add_dropdown_icons', 10, 4 );

/**
 * Filter breadcrumbs on patient stories.
 *
 * Format should be:
 * Home / Learn More / Patient Stories / {{title}}
 *
 * @param array $link The link array.
 * @param array $breadcrumb The breadcrumb item array.
 *
 * @return str  $link The link output.
 */
function codesample_add_text_to_breadcrumb( $link, $breadcrumb ) {

	if ( is_post_type_archive( 'story' ) || is_singular( 'story' ) ) {

		if ( array_key_exists( 'ptarchive', $breadcrumb ) ) {
			$link = '<span><a href="/learn-more/">Learn More</a></span> > <span><a href="/learn-more/patient-caregiver-stories/">Patient & Caregiver Stories</a></span>';
		}

	}

	if ( is_post_type_archive( 'recipe' ) || is_singular( 'recipe' ) ) {

		if ( array_key_exists( 'ptarchive', $breadcrumb ) ) {
			$link = '<span><a href="/nutrition-and-lifestyle/">FCS Nutrition & Lifestyle</a></span> > <span><a href="/nutrition-and-lifestyle/fcs-friendly-recipes/">FCS-Friendly Recipes</a></span>';
		}

	}

	return $link;
}
add_filter( 'wpseo_breadcrumb_single_link', 'codesample_add_text_to_breadcrumb', 10, 2 );

