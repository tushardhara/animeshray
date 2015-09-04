<?php
$orientation = 'inline';

if ( thb_is_theme_layout_vertical() ) {
	$orientation = 'vertical';
}

?>

<?php thb_nav_before(); ?>

	<nav id="main-nav" class="main-navigation primary <?php echo esc_attr( $orientation ); ?>">
		<h2 class="hidden">
			<?php _e( 'Main navigation', 'thb_text_domain' ); ?>
		</h2>

		<?php thb_nav_start(); ?>

		<div class="thb-desktop-navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</div>

		<div class="thb-mobile-navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'mobile' ) ); ?>
		</div>

		<?php thb_nav_end(); ?>
	</nav>

<?php thb_nav_after(); ?>