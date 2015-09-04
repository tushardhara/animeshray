<?php
	$thb_slideshow_items = thb_superba_get_gallery_items();
?>

<?php if ( ! empty( $thb_slideshow_items ) ) : ?>
	<div id="thb-slideshow-gallery-container" class="thb-page-section thb-slideshow-wrapper">
		<div class="thb-slideshow thb-main-slideshow rsTHB">
			<?php foreach ( $thb_slideshow_items as $item ) : ?>

				<?php
					$slide_attrs = array();
					$slide_attrs['class'] = 'slide';
				?>

				<?php if ( $item['type'] == 'image' ) : ?>
					<div <?php thb_attributes( $slide_attrs ); ?>>
						<a href="#" class="thb-slideshow-gallery-open-details">
							<?php
								thb_image( $item['id'], thb_get_slideshow_image_size(), array(
									'attr' => array(
										'class' => 'rsImg'
									)
								) );
							?>
						</a>

							<?php
								$title = $item['title'];
								$description = $item['description'];
								$exif = $item['exif'];

								if ( ! empty( $title ) || ! empty( $description ) || ! empty( $exif ) ) {
									echo '<a href="#" class="thb-toggle-caption"></a>';

									echo '<div class="thb-toggle-caption-content">';

										if ( ! empty( $title ) ) {
											printf( '<p class="thb-slide-caption-title">%s</p>', $title );
										}

										if ( ! empty( $description ) ) {
											printf( '<div class="thb-slide-caption-description">%s</div>', thb_text_format( $description, true ) );
										}

										if ( ! empty( $exif ) ) {
											echo '<div class="thb-exif-container"><ul>';
												foreach ( $exif as $key => $value ) {
													printf( '<li><span>%s</span>%s</li>', $key, $value );
												}
											echo '</ul></div>';
										}

									echo '</div>';
								}
							?>
					</div>
				<?php else : ?>
					<?php
						$is_youtube = strpos($item['id'], 'youtu') !== false;
						$is_vimeo = strpos($item['id'], 'vimeo') !== false;
						$is_selfhosted = ! $is_youtube && ! $is_vimeo;

						if ( $is_youtube ) {
							$item['id'] = 'http://www.youtube.com/watch?v=' . thb_get_video_code($item['id']);
						}

						if ( $is_youtube || $is_vimeo ) {
							$slide_data['embed-iframe'] = '1';
						}

						$thb_video_thumbnail = $item['url'];

						if ( ! empty( $thb_video_thumbnail ) && ( $is_selfhosted || wp_is_mobile() ) ) {
							if ( ! isset( $slide_attrs['style'] ) ) {
								$slide_attrs['style'] = '';
							}

							$slide_attrs['style'] .= ' background-image: url(' . $thb_video_thumbnail . ')';

							if ( $is_selfhosted ) {
								$slide_data['poster-image'] = '1';
							}
						}
					?>

					<div <?php thb_attributes( $slide_attrs ); ?> <?php thb_data_attributes( $slide_data ); ?>>
						<?php if ( $is_youtube || $is_vimeo ) : ?>
							<?php if ( ! wp_is_mobile() ) : ?>
								<a class="rsImg" data-rsVideo="<?php echo $item['id']; ?>" href="<?php echo $thb_video_thumbnail; ?>"></a>
							<?php endif; ?>
						<?php else : ?>
							<?php
								if ( ! wp_is_mobile() ) {
									thb_video( $item['id'], $video_atts );
								}
							?>
						<?php endif; ?>

					</div>
				<?php endif; ?>

			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>