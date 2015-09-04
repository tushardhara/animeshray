<?php

if ( !isset( $args ) ) {
	$args = array();
}

if ( !isset( $params ) ) {
	$params = array();
}

if ( !isset( $layout ) ) {
	$layout = 'thb-desc-outside';
}

$classes = '';
$data_attrs = array();

if ( isset( $params['carousel'] ) && $params['carousel'] == '1' ) {
	$classes .= ' thb-carousel';
	$data_attrs = thb_get_carousel_attributes( $params );
}
else {
	$classes .= ' ' . thb_get_portfolio_classes( $columns, $gutter );
}

if ( empty( $columns ) ) {
	$columns = 3;
}

if ( empty( $images_height ) ) {
	$images_height = 'fixed';
}

$thb_size = thb_get_grid_image_size( $columns, $images_height );

$thb_item_extra_class = $layout;

if ( empty( $params ) ) {
	if ( thb_get_portfolio_styles() == 'thb-desc-inside' ) {
		$thb_item_extra_class = ' thb-desc-inside';
	} else {
		$thb_item_extra_class = ' thb-desc-outside';
	}
}

thb_portfolio_query( $args );

?>

<?php if( have_posts() ) : ?>

	<ul class="<?php echo esc_attr( $classes ); ?>" <?php thb_attributes( $data_attrs ); ?>>
		<?php while( have_posts() ) : ?>
			<?php the_post(); ?>

			<?php
				thb_portfolio_item( array(
					'portfolio_item_template' => $portfolio_item_template,
					'thb_size'                => $thb_size,
					'thb_item_extra_class'    => $thb_item_extra_class
				) );
			?>
		<?php endwhile; ?>
	</ul>

<?php endif; ?>