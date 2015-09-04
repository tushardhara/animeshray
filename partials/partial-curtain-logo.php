<?php if( isset( $logo_metadata ) ) : ?>
	<style type="text/css">
		@media all and (-webkit-min-device-pixel-ratio: 1.5) {

			.thb-curtain-logo {
				background-position: center center;
				background-repeat: no-repeat;
				background-size: contain;
			}

			<?php if ( ! empty ( $logo_2x ) ) : ?>

				.thb-curtain-logo {
					background-image: url('<?php echo $logo_2x; ?>');
				}

			<?php endif; ?>

			.thb-curtain-logo img { visibility: hidden; }
		}
	</style>
<?php endif; ?>


<div class="thb-curtain-logo">
	<?php if( ! empty( $logo ) ) : ?>
		<span class="hidden"><?php bloginfo( 'name' ); ?></span>
	<?php endif; ?>

	<?php if( ! empty( $logo ) ) : ?>

		<?php if ( ! empty( $logo ) ) : ?>
			<img src="<?php echo $logo; ?>" alt="" class="thb-standard-logo">
		<?php endif; ?>

	<?php else : ?>
		<span class="thb-logo"><?php bloginfo( 'name' ); ?></span>
		<?php if( ! empty( $description ) ) : ?>
			<span class="thb-logo-tagline"><?php echo $description; ?></span>
		<?php endif; ?>
	<?php endif; ?>
</div>