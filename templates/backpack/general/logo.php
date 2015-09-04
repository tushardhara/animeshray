<?php
	$mobile_logo = thb_image_get_size ( thb_get_option( 'mobile_logo' ) );
	$mobile_logo_retina = thb_image_get_size ( thb_get_option( 'mobile_logo_retina' ) );
	$media_size = '767px';
	$logo_url = apply_filters( 'thb_logo_url', home_url('/') );

	if ( thb_is_theme_layout_b() ) {
		$media_size = '800px';
	}
?>

<?php if( isset( $logo_metadata ) || ! empty( $mobile_logo ) || ! empty( $mobile_logo_retina ) ) : ?>
	<style type="text/css">
		<?php if ( isset( $logo_metadata ) ) : ?>
			@media all and (-webkit-min-device-pixel-ratio: 1.5) {

				.<?php echo $class; ?> a {
					background-position: top left;
					background-repeat: no-repeat;
					background-size: contain;
				}

				<?php if ( ! empty ( $logo_2x ) ) : ?>
					.<?php echo $class; ?> a {
						background-image: url('<?php echo $logo_2x; ?>');
					}

					<?php
						if ( isset( $logo_metadata ) ) {
							echo ".{$class} a {";
								echo "height: auto;";
								echo "width: {$logo_metadata['width']}px;";
							echo "}";
						}
					?>
				<?php endif; ?>

				.<?php echo $class; ?> a img { visibility: hidden; }
			}
		<?php endif; ?>

		<?php if ( ! empty( $mobile_logo ) ) : ?>
			@media screen and ( max-width: <?php echo $media_size; ?> ) {
				.<?php echo $class; ?> a {
					background-position: top left;
					background-repeat: no-repeat;
					background-size: contain;
				}

				.<?php echo $class; ?> a {
					background-image: url('<?php echo $mobile_logo; ?>');
				}

				.<?php echo $class; ?> a img.thb-standard-logo { display: none; }
				.<?php echo $class; ?> a img.thb-mobile-logo { display: none; visibility: hidden; }
				.<?php echo $class; ?> .thb-logo { display: none; }
				.<?php echo $class; ?> .thb-logo-tagline { display: none; }

				<?php
					$thb_mobile_metadata = wp_get_attachment_metadata( thb_get_option( 'mobile_logo' ) );

					if ( $thb_mobile_metadata ) {
						echo ".{$class} a {";
							echo "height: {$thb_mobile_metadata['height']}px;";
							echo "width: {$thb_mobile_metadata['width']}px;";
						echo "}";
					}
				?>
			}
		<?php endif; ?>

		<?php if ( ! empty( $mobile_logo_retina ) ) : ?>
			@media screen and ( max-width: <?php echo $media_size; ?> ) and ( -webkit-min-device-pixel-ratio: 1.5 ) {
				.<?php echo $class; ?> a {
					background-image: url('<?php echo $mobile_logo_retina; ?>');
				}
			}
		<?php endif; ?>
	</style>
<?php endif; ?>

<?php
$logo_tag = 'div';

if ( is_home() || is_front_page() ) {
	$logo_tag = 'h1';
}
?>

<<?php echo $logo_tag; ?> class="<?php echo $class; ?>">
	<?php if( ! empty( $logo ) ) : ?>
		<span class="hidden"><?php bloginfo( 'name' ); ?></span>
	<?php endif; ?>

	<a href="<?php echo esc_url( $logo_url ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
		<?php if( ! empty( $logo ) ) : ?>

			<?php if ( ! empty( $logo ) ) : ?>
				<img src="<?php echo $logo; ?>" alt="" class="thb-standard-logo">

				<?php
					if ( empty( $mobile_logo ) ) {
						$mobile_logo = $logo;
					}
				?>
				<img src="<?php echo $mobile_logo; ?>" alt="" class="thb-mobile-logo">
			<?php endif; ?>

		<?php else : ?>
			<span class="thb-logo"><?php bloginfo( 'name' ); ?></span>
			<?php if( ! empty( $description ) ) : ?>
				<span class="thb-logo-tagline"><?php echo $description; ?></span>
			<?php endif; ?>
		<?php endif; ?>
	</a>
</<?php echo $logo_tag; ?>>