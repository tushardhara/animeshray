<?php
	$album_id = $album_select;
	$thb_thumb_size = isset( $featured_image_size ) ? $featured_image_size : 'full';
	$thb_fi = thb_get_featured_image( $thb_thumb_size, $album_id );
	$enable_slideviews = isset( $enable_slideviews ) ? (bool) $enable_slideviews : false;
	$image_class = '';
	$link_iskip_class = '';

	if ( $enable_slideviews && thb_text_contains( 'cropped', $thb_thumb_size ) ) {
		$image_class = 'slideview';
		$link_iskip_class = 'thb-has-slideview';
	}

	$album = get_post( $album_id );
	$album_title     = $album->post_title;
	$album_permalink = get_permalink( $album_id );

	if ( ! isset( $show_images_count ) ) {
		$show_images_count = 0;
	}

	$items = thb_superba_get_gallery_items( $album_id );

	$album_items = (int) count( $items );
	$album_items .= ' ' . __( 'Items', 'thb_text_domain' );

	$album_images = array();

	if ( ! empty( $title ) ) {
		$album_title = $title;
	}

	if ( ! empty( $thb_fi ) ) {
		$album_images[] = $thb_fi;
	}

	if ( $enable_slideviews && thb_text_contains( 'cropped', $thb_thumb_size ) ) {
		shuffle( $items );
		$items = array_slice( $items, 0, 9 );

		foreach ( $items as $image ) {
			if ( $image['type'] == 'image' ) {
				$album_images[] = thb_image_get_size( $image['id'], $thb_thumb_size );
			}
		}
	}

?>

<a class="thb-album-wrapper thb-block-type-element-thumb <?php echo $link_iskip_class; ?>" href="<?php echo $album_permalink; ?>">

	<?php if ( $data_position == 'thb-desc-inside' ) : ?>
		<div class="thb-block-type-element-external-wrapper">
			<div class="thb-block-type-element-wrapper">
				<div class="thb-block-type-element-inner-wrapper">
					<div class="thb-block-type-element-data-wrapper">

						<h3 class="thb-album-title">
							<?php echo $album_title; ?>
						</h3>

						<?php if ( $show_images_count ) : ?>
							<p class="thb-album-count">
								<?php echo $album_items; ?>
							</p>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="thb-block-type-element-image-wrapper">
		<?php if ( $data_position == 'thb-desc-outside' ) : ?>
			<span class="thb-block-type-element-overlay"></span>
		<?php endif; ?>

		<?php if( ! empty( $album_images ) ) : ?>
			<?php if ( $data_position == 'thb-desc-inside' ) : ?>
				<span class="thb-overlay"></span>
			<?php endif; ?>
			<img class="<?php echo $image_class; ?>" src="<?php echo $album_images[0]; ?>" alt="" data-images="<?php echo esc_attr( implode( ',', $album_images ) ); ?>">
		<?php endif; ?>
	</div>

</a>

<?php if ( $data_position == 'thb-desc-outside' ) : ?>
	<div class="thb-block-type-element-data-wrapper">
		<h3 class="thb-album-title">
			<a href="<?php echo $album_permalink; ?>">
				<?php echo $album_title; ?>
			</a>
		</h3>

		<?php if ( $show_images_count ) : ?>
			<p class="thb-album-count">
				<?php echo $album_items; ?>
			</p>
		<?php endif; ?>
	</div>
<?php endif; ?>