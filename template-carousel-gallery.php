<?php
/**
 * @package WordPress
 * @subpackage Superba
 * @since Superba 1.0
 * Template name: Album - carousel
 */
$page_sidebar = thb_get_page_sidebar( thb_get_page_ID() );

$thb_carousel_items = thb_superba_get_gallery_items();

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

	</div>

</div>

<?php
	$preload_num = 5;

	// if ( wp_is_mobile() ) {
	// 	$preload_num = 3;
	// }
?>

<?php if ( ! empty( $thb_carousel_items ) ) : ?>
	<div class="thb-page-section thb-carousel-gallery-outer-wrapper">
		<a href="#" class="thb-carousel-gallery-prev"><span><?php _e( 'Previous', 'thb_text_domain' ) ?></span></a>
		<a href="#" class="thb-carousel-gallery-next"><span><?php _e( 'Next', 'thb_text_domain' ) ?></span></a>

		<div id="thb-carousel-gallery-container">
			<div class="thb-carousel-gallery-container-inner">

				<?php foreach( $thb_carousel_items as $index => $grid_item ) : ?>
					<div class="thb-carousel-gallery-item <?php if ( $grid_item['type'] == 'embed' ) : ?>thb-video-gallery-item<?php endif; ?>">
						<?php if ( $grid_item['type'] == 'image' ) : ?>
							<div class="item-thumb-wrapper">
								<a class="item-thumb" href="<?php echo thb_image_get_size( $grid_item['id'] ); ?>">
									<span class="thb-overlay"></span>
									<?php if ( $index < $preload_num ) : ?>
										<img src="<?php echo thb_image_get_size( $grid_item['id'], 'carousel' ); ?>" alt="" class="">
									<?php else : ?>
										<img src="" data-src="<?php echo thb_image_get_size( $grid_item['id'], 'carousel' ); ?>" alt="" class="">
									<?php endif; ?>
								</a>
							</div>
						<?php else : ?>
							<?php thb_video( $grid_item['id'] ); ?>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>

			</div>
		</div>
	</div>
<?php endif; ?>

<?php if ( ! thb_is_builder_empty() && thb_is_builder_position_gallery_pages_bottom() ) : ?>
	<div class="thb-content-section thb-content-available">
		<div class="thb-content-section-inner-wrapper">
			<?php thb_builder_hook(); ?>
		</div>
	</div>
<?php endif; ?>

<div class="thb-content-section">

	<div class="thb-content-section-inner-wrapper">

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

	<?php thb_page_end(); ?>

</div>

<?php thb_page_after(); ?>

<?php get_footer(); ?>