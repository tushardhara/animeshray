<?php
$thb_get_copyright = thb_get_copyright();
?>

<?php if ( ! empty( $thb_get_copyright ) ) : ?>

	<div class="thb-copyright">
		<div class="thb-copyright-inner-wrapper">
			<div class="thb-page-section">
				<?php thb_copyright(); ?>
			</div>
		</div>
	</div>

<?php endif; ?>