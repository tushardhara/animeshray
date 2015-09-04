<?php
	$header_inner_bg = get_theme_mod( 'header_panel_color' );
	$header_inner_skin = '';

	if ( ! empty( $header_inner_bg ) ) {
		$header_inner_skin = 'thb-skin-' . thb_color_get_opposite_skin( $header_inner_bg );
	}
?>
<header id="thb-header" class="<?php echo esc_attr( $header_inner_skin ); ?>">

	<div class="thb-header-inner-wrapper">
		<?php thb_header_start(); ?>

		<?php thb_logo( 'thb-main-header-logo' ); ?>

		<a class="thb-mobile-nav-trigger" href="#">
			<span class="line line-1"></span>
			<span class="line line-2"></span>
			<span class="line line-3"></span>
		</a>

		<?php thb_cart_hook(); ?>

		<div class="thb-header-nav-wrapper">
			<?php thb_get_template_part( 'partials/partial-navigation.php' ); ?>

			<?php if ( thb_is_theme_layout_vertical() ) : ?>
				<?php thb_get_template_part( 'partials/partial-copyright' ); ?>
			<?php endif; ?>
		</div>

		<?php thb_header_end(); ?>
	</div>

</header>