<?php
/**
 * Add modals
 */
function be_modals() {
	?>
	<div id="modal-search" class="modal" data-nosnippet>
		<!-- Modal content -->
		<div class="modal-content">
			<span class="close">&times;</span>
			<?php echo be_render_search(); ?>
		</div>
	</div>

	<?php if ( ! is_page_template( 'template-quiz.php' ) ) { ?>
		<div id="modal-subscribe" class="modal" data-nosnippet>
			<!-- Modal content -->
			<div class="modal-content">
				<span class="close">&times;</span>
				<?php echo do_shortcode( '[gravityform id="1" title="true"]' ); ?>
				<figure class="wp-block-image size-full kytgs-subscribe--figure"><img
						src="/wp-content/uploads/2024/05/jeff-with-fcs.png" alt="" class="wp-image-737" />
					<figcaption class="wp-element-caption">Jeff,<br>Living with FCS</figcaption>
				</figure>
			</div>
		</div>
	<?php } ?>

	<div id="modal-leaving" class="modal" data-nosnippet>
		<div class="modal-content">
			<span class="close">&times;</span>
			<img src="<?php bloginfo( 'template_directory' ); ?>/assets/images/modal-logo.jpg" class="modal-logo" alt="">
			<h3>You are about to leave KnowYourTGs.com.</h3>
			<p>You will be taken to a website independently operated and not managed by Ionis Pharmaceuticals. </p>
			<p>Ionis Pharmaceuticals assumes no responsibility for the content of the site.</p>
			<p>Thank you for visiting KnowYourTGs.com</p>
			<br>
			<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
				<div class="wp-block-button">
					<a class="wp-block-button__link wp-element-button interstitial-button-leave" href="">Proceed</a>
				</div>
				<div class="wp-block-button is-style-outline">
					<button class="wp-block-button__link wp-element-button interstitial-close-trigger">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'tha_body_bottom', 'be_modals' );