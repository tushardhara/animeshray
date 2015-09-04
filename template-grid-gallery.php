<?php
/**
 * @package WordPress
 * @subpackage Superba
 * @since Superba 1.0
 * Template name: Album - grid
 */

$page_sidebar = thb_get_page_sidebar( thb_get_page_ID() );

$thb_grid_items = thb_superba_get_gallery_items();
$thb_grid_columns = thb_get_grid_columns();
$thb_grid_images_height = thb_get_grid_images_height();
$thb_gallery_pace = (int) thb_get_post_meta( thb_get_page_ID(), 'gallery_pace' );
$show_more_btn = $thb_gallery_pace < count( $thb_grid_items ) && $thb_gallery_pace > 0;
$thb_size = thb_get_grid_image_size( $thb_grid_columns, $thb_grid_images_height );

if ( empty( $thb_grid_columns ) ) {
	$thb_grid_columns = 3;
}

$thb_grid_classes = array(
	'thb-grid-layout',
	thb_get_grid_class_name( $thb_grid_columns, 'small' ),
	thb_get_gallery_grid_style()
);

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

<div id="thb-grid-gallery-container">
	<?php thb_superba_gallery_filter(); ?>

	<?php if ( ! empty( $thb_grid_items ) ) : ?>
		<ul class="<?php thb_classes( $thb_grid_classes ); ?>">
			<?php foreach( $thb_grid_items as $index => $grid_item ) : ?>

				<?php
					if ( $thb_gallery_pace && $index >= $thb_gallery_pace ) {
						break;
					}

					$grid_item_categories = explode( ',', $grid_item['gallery_category'] );
					$grid_item_filters = array();

					if( ! empty($grid_item_categories) ) {
						foreach( $grid_item_categories as $cat ) {
							$grid_item_filters['filter-' . $cat] = '';
						}
					}
				?>

				<li class="<?php echo thb_get_grid_layout_item_class(); ?>" <?php thb_data_attributes( $grid_item_filters ); ?>>
					<?php thb_get_template_part( 'loop/gallery-grid-a', array( 'grid_item' => $grid_item, 'thb_size' => $thb_size ) ); ?>
				</li>

			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<div class="thb-gallery-load-more-container" style="display: <?php echo $show_more_btn ? 'block' : 'none'; ?>">
		<a href="#" id="thb-gallery-load-more">
			<?php _e( 'Load more', 'thb_text_domain' ); ?>
		</a>
	</div>

</div>

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