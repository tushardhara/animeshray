<?php
/**
 * @package WordPress
 * @subpackage Superba
 * @since Superba 1.0
 * Template name: Album - mosaic
 */

$data_attrs = array();
$classes = array(
	'thb-page-section',
	'mosaic-album-media-container',
	'thb-superba-photoset-grid'
);

$mosaic_module        = thb_get_post_meta( thb_get_page_ID(), 'superba_gallery_mosaic_module' );
$mosaic_gutter        = thb_get_post_meta( thb_get_page_ID(), 'superba_gallery_mosaic_gutter' );
$image_size           = thb_get_post_meta( thb_get_page_ID(), 'superba_gallery_mosaic_image_size' );
$slides       		  = thb_superba_get_gallery_items( thb_get_page_ID(), $image_size );
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

if( !function_exists('thb_mosaic_lightbox_class') ) {
	function thb_mosaic_lightbox_class() {
		return 'thb-gallery-lightbox nothumb';
	}
}

add_filter( 'thb_lightbox_class', 'thb_mosaic_lightbox_class', 20 );

global $post;

get_header(); ?>

<?php thb_page_before(); ?>

<div class="thb-content-section <?php if ( thb_is_content_available( $post ) ) : ?>thb-content-available<?php endif; ?>">

	<?php thb_page_start(); ?>

	<div class="thb-content-section-inner-wrapper">

		<?php thb_get_template_part( 'partials/partial-pageheader' ); ?>

		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

			<?php if ( get_the_content() || thb_check_action_hook_empty( 'the_content' ) ) : ?>
				<div id="thb-main-content" class="thb-page-section thb-page-content-wrapper">

					<div class="thb-text">
						<?php if ( get_the_content() ) : ?>
							<?php the_content(); ?>
						<?php else : ?>
							<?php echo apply_filters( 'the_content', '' ); ?>
						<?php endif; ?>

					</div>

				</div>
			<?php endif; ?>

		<?php endwhile; endif; ?>

		<?php wp_reset_query(); ?>

		<?php if ( thb_is_builder_position_gallery_pages_top() ) : ?>
			<?php thb_builder_hook(); ?>
		<?php endif; ?>

		<div class="thb-page-content-wrapper">
			<?php if ( ! empty( $slides ) ) : ?>
				<div class="<?php thb_classes( $classes ); ?>" <?php thb_data_attributes( $data_attrs ); ?>>
					<?php
						foreach ( $slides as $i => $slide ) {
							if ( $slide['type'] == 'image' ) {
								if ( ! isset( $slides_config['attr'] ) ) {
									$slides_config['attr'] = array();
								}

								$slides_config['attr']['data-index']   = $i;
								$slides_config['attr']['data-mfp-src'] = thb_image_get_size( $slide['id'] );
								$slides_config['attr']['title']        = $slide['description'];
								$slides_config['link']                 = wp_is_mobile();
								$slides_config['link_class']           = 'nothumb';
								$slides_config['overlay']              = false;
								$slides_config['lazy']                 = true;

								thb_image( $slide['id'], $image_size, $slides_config );
							}
							else {
								$is_youtube = strpos($slide['id'], 'youtu') !== false;
								$is_vimeo = strpos($slide['id'], 'vimeo') !== false;

								if ( $is_youtube || $is_vimeo ) {
									$thb_video_thumbnail = thb_get_video_thumbnail( $slide['id'], 'thumbnail_large' );

									echo '<img src="' . esc_url( $thb_video_thumbnail ) . '" data-index="' . $i . '">';
								}
							}
						}
					?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( thb_is_builder_position_gallery_pages_bottom() ) : ?>
			<?php thb_builder_hook(); ?>
		<?php endif; ?>

		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
			<?php if( thb_show_comments() ) : ?>

				<div class="thb-page-content-wrapper">

					<section class="thb-page-section secondary">
					<?php if( thb_show_comments() ) : ?>
						<?php thb_comments( array('title_reply' => '<span>' . __('Leave a reply', 'thb_text_domain') . '</span>' )); ?>
					<?php endif; ?>
					</section>

				</div>

			<?php endif; ?>
		<?php endwhile; endif; ?>

	</div>

	<?php thb_page_sidebar(); ?>

	<?php thb_page_end(); ?>

</div>

<?php thb_page_after(); ?>

<?php get_footer(); ?>