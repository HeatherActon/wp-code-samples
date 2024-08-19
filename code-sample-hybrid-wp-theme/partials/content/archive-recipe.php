<?php
/**
 * Archive partial
 *
 * @package      CodeSampleHybridWPTheme
 * @author       Bill Erickson / Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

$terms = get_the_terms( get_the_ID(), 'recipe-type' );
if ( $terms && ! is_wp_error( $terms ) ) :

	$recipe_types = array();

	foreach ( $terms as $term ) {
		$recipe_types[] = 'recipe-type--' . $term->slug;
	}

	$recipe_types = join( " ", $recipe_types );
endif;

echo '<article class="post-summary ' . $recipe_types . '">';
be_post_summary_image( 'featured-cpt-archives' );

echo '<div class="post-summary__content">';
be_post_summary_title();
echo '</div>';

echo '</article>';
