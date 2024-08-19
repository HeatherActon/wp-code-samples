<?php
/**
 * Patterns
 *
 * @package      TGAware24
 * @author       Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

namespace TGAware24\Patterns;

/**
 * Unregister Core Patterns
 */
function unregister_core_patterns() {
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\unregister_core_patterns' );
add_filter( 'should_load_remote_block_patterns', '__return_false' );