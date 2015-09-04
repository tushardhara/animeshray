<?php
	$splash_url = thb_get_splash_logo_url();
	$rel_primary = "";

	if ( ! empty( $splash_url ) && is_numeric( $splash_url ) ) {
		$splash_url = get_permalink( $splash_url );
	} else {
		$splash_url = untrailingslashit( $splash_url );
		$home_url = untrailingslashit( home_url() );

		if ( ! thb_text_startsWith( $splash_url, $home_url ) ) {
			$rel_primary = 'rel="nofollow"';
		}
	}
?>

<?php if( isset( $splash_logo_metadata ) ) : ?>
	<style type="text/css">
		@media all and (-webkit-min-device-pixel-ratio: 1.5) {

			#splash-logo {
				background-position: center center;
				background-repeat: no-repeat;
				background-size: contain;
			}

			<?php if ( ! empty ( $logo_2x ) ) : ?>

				#splash-logo {
					background-image: url('<?php echo $logo_2x; ?>');
				}

			<?php endif; ?>

			#splash-logo img { visibility: hidden; }
		}
	</style>
<?php endif; ?>

<?php if( ! empty( $logo ) ) : ?>
	<div id="splash-logo">


		<?php if ( !empty( $splash_url ) ) : ?>
			<a href="<?php echo $splash_url; ?>">
		<?php endif; ?>

			<?php if ( ! empty( $logo ) ) : ?>
				<img src="<?php echo $logo; ?>" alt="" class="thb-splash-logo">
			<?php endif; ?>

		<?php if ( !empty( $splash_url ) ) : ?>
			</a>
		<?php endif; ?>

	</div>
<?php endif; ?>