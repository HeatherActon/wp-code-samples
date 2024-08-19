<?php
/**
 * Template Name: Search
 *
 * @package      CodeSampleHybridWPTheme
 * @author       Heather Acton
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

$cs = isset( $_GET['cs'] ) ? $_GET['cs'] : false;
if ( ! $cs ) {
	wp_safe_redirect( '/' );
	exit;
}

$customSearch = new WP_Query( "s=$cs&showposts=-1" );

add_filter( 'be_page_layout', 'be_return_content' );

get_header();

tha_content_before();

echo '<div class="content-area">';
tha_content_wrap_before();
echo '<main class="site-main" role="main">';
tha_content_top();

if ( $customSearch->have_posts() ) :
	tha_content_while_before();
	/* Start the Loop */
	while ( $customSearch->have_posts() ) :
		$customSearch->the_post();
		tha_entry_before();
		$partial = 'archive';
		get_template_part( 'partials/content/' . $partial );
		tha_entry_after();
	endwhile;
	tha_content_while_after();

else :

	tha_entry_before();
	$context = apply_filters( 'be_empty_loop_partial_context', 'no-content' );
	get_template_part( 'partials/content/' . $context );
	tha_entry_after();

endif;

tha_content_bottom();
echo '</main>';
get_sidebar();
tha_content_wrap_after();
echo '</div>';
tha_content_after();

get_footer();