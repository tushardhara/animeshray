<?php

if ( ! isset( $slides ) ) {
	$slides = '';
}

if ( ! isset( $image_size ) ) {
	$image_size = '';
}

if ( ! isset( $featured_image_config ) ) {
	$featured_image_config = '';
}

if ( ! isset( $slides_config ) ) {
	$slides_config = array();
}

$slides_display = thb_get_post_meta( thb_get_page_ID(), 'superba_single_work_display' );
$is_lightbox_disabled = false; // thb_get_post_meta( thb_get_page_ID(), 'disable_work_image_link' );

$slides_have_video = false;
$thb_details_btn = '<a href="#" class="thb-slideshow-gallery-open-details"></a>';

if ( ! empty( $slides ) ) {
	foreach ( $slides as $slide ) {
		if ( $slide['type'] != 'image' ) {
			$slides_have_video = true;
			break;
		}
	}
}

$is_slideshow = $slides_display == 'slideshow';
$is_mosaic = $slides_display == 'mosaic';
$is_stream = $slides_display == '';

if ( $is_lightbox_disabled ) {
	$slides_config['link'] = false;
}

$data_attrs = array();
$classes = array(
	'work-slides-container',
);

if ( $is_slideshow ) {
	$classes[] = 'thb-work-slideshow rsTHB';
}
elseif ( $is_mosaic ) {
	$classes[] = 'thb-superba-photoset-grid';

	$mosaic_module = thb_get_post_meta( thb_get_page_ID(), 'superba_single_work_mosaic_module' );
	$mosaic_gutter = thb_get_post_meta( thb_get_page_ID(), 'superba_single_work_mosaic_gutter' );
	$image_size = thb_get_post_meta( thb_get_page_ID(), 'superba_single_work_mosaic_image_size' );
	$mosaic_module_repeat = 1;

	if ( $mosaic_module != '' ) {
		$mosaic_module_count = array_sum( str_split( $mosaic_module ) );

		if ( $mosaic_module_count < count( $slides ) ) {
			$mosaic_module_repeat = absint( count( $slides ) / $mosaic_module_count );
			$mosaic_module_repeat += count( $slides ) % $mosaic_module_count;
		}
	}

	$data_attrs['layout'] = str_repeat( $mosaic_module, $mosaic_module_repeat );
	$data_attrs['gutter'] = $mosaic_gutter;
	$data_attrs['lightbox'] = '0';
}
else {
	$classes[] = 'thb-regular';
}

?>

<?php if ( ! empty( $slides ) ) : ?>
	<div class="thb-slideshow-wrapper">
		<?php
			if ( $is_slideshow ) {
				echo $thb_details_btn;
			}
		?>

		<div class="<?php thb_classes( $classes ); ?>" <?php thb_data_attributes( $data_attrs ); ?>>
			<?php
				foreach ( $slides as $i => $slide ) {
					if ( $is_slideshow || $is_stream ) {
						echo "<div class='slide thb-image-wrapper " . esc_attr( $slide['class'] ) . "' data-index='{$i}'>";
					}

					if ( $slide['type'] == 'image' ) {
						if ( ! isset( $slides_config['attr'] ) ) {
							$slides_config['attr'] = array();
						}

						if ( $is_slideshow ) {
							$slides_config['attr']['class'] = 'rsImg';
						}
						elseif ( $is_mosaic ) {
							$slides_config['attr']['data-index'] = $i;
							$slides_config['attr']['data-mfp-src'] = thb_image_get_size( $slide['id'] );
							$slides_config['attr']['title'] = $slide['caption'];
							$slides_config['link'] = false;
							$slides_config['overlay'] = false;
							$slides_config['lazy'] = true;
						}
						else {
							$slides_config['lazy'] = true;
							$slides_config['link'] = ! $is_lightbox_disabled;
							$slides_config['link_class'] = 'item-thumb';
						}

						thb_image( $slide['id'], $image_size, $slides_config );
					}
					else {
						$is_youtube = strpos($slide['id'], 'youtu') !== false;
						$is_vimeo = strpos($slide['id'], 'vimeo') !== false;
						$is_selfhosted = ! $is_youtube && ! $is_vimeo;

						if ( $is_stream ) {
							thb_video( $slide['id'], array( 'holder' => false ) );
						}
						elseif ( $is_mosaic ) {
							if ( $is_youtube || $is_vimeo ) {
								$thb_video_thumbnail = thb_get_video_thumbnail( $slide['id'], 'thumbnail_large' );

								echo '<img src="' . esc_url( $thb_video_thumbnail ) . '" data-index="' . $i . '">';
							}
						}
						else {
							if ( $is_youtube || $is_vimeo ) {
								if ( ! wp_is_mobile() ) {
									$thb_video_thumbnail = thb_get_video_thumbnail( $slide['id'], 'thumbnail_large' );

									echo '<a class="rsImg" data-rsVideo="' . esc_url( $slide['id'] ) . '" href="' . esc_url( $thb_video_thumbnail ) . '"></a>';
								}
							}
							else {
								if ( ! wp_is_mobile() ) {
									thb_video( $slide['id'] );
								}
							}
						}
					}

					if ( $is_stream ) {
						if ( $slide['caption'] != '' || $slide['gallery_title'] != '' ) {
							echo "<div class='thb-caption-content'>";
								if ( $slide['gallery_title'] != '' ) {
									echo '<h2>' . thb_text_format( $slide['gallery_title'] ) . '</h2>';
								}

								if ( $slide['caption'] != '' ) {
									echo thb_text_format( $slide['caption'], true );
								}
							echo "</div>";
						}
					}

					if ( $is_slideshow || $is_stream ) {
						echo "</div>";
					}
				}
			?>
		</div>
	</div>
<?php endif; ?>