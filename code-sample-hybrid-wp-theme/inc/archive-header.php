<?php
/**
 * Archive Header
 *
 * @package      CodeSampleHybridWPTheme
 * @subpackage   archive-header/1
 * @author       Bill Erickson / Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

/**
 * Archive Header
 */
function be_archive_header() {

	if ( is_singular() && ! is_page_template( 'search.php' ) ) {
		return;
	}

	$title       = false;
	$description = false;
	$image       = false;

	if ( is_home() && get_option( 'page_for_posts' ) ) {
		$post_id = get_option( 'page_for_posts' );
		$title   = get_post_meta( $post_id, 'be_archive_title', true );
		if ( empty( $title ) ) {
			$title = get_the_title( $post_id );
		}
		$description = get_post_meta( $post_id, 'be_archive_description', true );
	}
	elseif ( is_search() ) {
		$title       = 'Search Results';
		$description = 'Search results for "' . get_search_query() . '"';
	}
	elseif ( is_page_template( 'search.php' ) ) {
		$title       = 'Search Results';
		$cs          = isset( $_GET['cs'] ) ? $_GET['cs'] : '';
		$description = 'Search results for "' . esc_html( $cs ) . '"';
	}
	elseif ( is_post_type_archive( 'recipe' ) && get_option( 'page_for_recipe' ) ) {

		$post_id             = get_option( 'page_for_recipe' );
		$archive_page        = get_post( $post_id );
		$archive_page_blocks = parse_blocks( $archive_page->post_content );

		foreach ( $archive_page_blocks as $block ) {

			if ( ! array_key_exists( 'attrs', $block ) ) {
				continue;
			}
			if ( ! array_key_exists( 'metadata', $block['attrs'] ) ) {
				continue;
			}
			if ( ! array_key_exists( 'name', $block['attrs']['metadata'] ) ) {
				continue;
			}

			if ( $block['attrs']['metadata']['name'] === 'Archive Title' ) {
				$title = render_block( $block );
				continue;
			}
			if ( $block['attrs']['metadata']['name'] === 'Archive Description' ) {
				$description = render_block( $block );
			}
		}

	}
	elseif ( is_post_type_archive( 'story' ) && get_option( 'page_for_story' ) ) {

		$post_id             = get_option( 'page_for_story' );
		$archive_page        = get_post( $post_id );
		$archive_page_blocks = parse_blocks( $archive_page->post_content );

		foreach ( $archive_page_blocks as $block ) {

			if ( ! array_key_exists( 'attrs', $block ) ) {
				continue;
			}
			if ( ! array_key_exists( 'metadata', $block['attrs'] ) ) {
				continue;
			}
			if ( ! array_key_exists( 'name', $block['attrs']['metadata'] ) ) {
				continue;
			}

			if ( $block['attrs']['metadata']['name'] === 'Archive Title' ) {
				$title = render_block( $block );
				continue;
			}
			if ( $block['attrs']['metadata']['name'] === 'Archive Description' ) {
				$description = render_block( $block );
			}
		}

	}
	elseif ( is_archive() ) {
		$title = false;
		if ( is_category() || is_tag() ) {
			$title = get_term_meta( get_queried_object_id(), 'be_archive_headline', true );
			$image = get_term_meta( get_queried_object_id(), 'image', true );
		}
		if ( empty( $title ) ) {
			$title = get_the_archive_title();
		}
		if ( ! get_query_var( 'paged' ) ) {
			$description = get_the_archive_description();
		}
	}

	if ( empty( $title ) && empty( $description ) ) {
		return;
	}

	echo '<div class="archive-header"><div class="wrap">';
	do_action( 'be_archive_header_before' );

	echo '<div class="archive-header__inner">';
	if ( ! empty( $title ) ) {
		echo '<h1 class="archive-title">' . esc_html( wp_strip_all_tags( $title ) ) . '</h1>';
	}
	if ( ! empty( $description ) ) {
		echo '<div class="archive-description">' . wp_kses_post( apply_filters( 'be_the_content', $description ) ) . '</div>';
	}
	if ( is_search() ) {
		echo be_render_search();
	}
	echo '</div>';

	do_action( 'be_archive_header_after' );
	echo '</div></div>';

}
add_action( 'tha_content_top', 'be_archive_header', 16 );

function codesample_show_recipes_legend() {
	if ( is_post_type_archive( 'recipe' ) ) {
		$terms = get_terms( array(
			'taxonomy'   => 'recipe-type',
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'DESC'
		) );
		if ( $terms ) {
			echo '<div class="recipe-terms">';
			foreach ( $terms as $term ) {
				echo '<div class="recipe-type-marker recipe-type--' . esc_html( $term->slug ) . '">' . esc_html( $term->name ) . '</div>';
			}
			echo '</div>';
		}
	}
}
add_action( 'be_archive_header_after', 'codesample_show_recipes_legend' );
