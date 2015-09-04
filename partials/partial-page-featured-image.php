<?php

if ( !isset( $img_link ) ) {
	$img_link = true;
	$img_overlay = true;
}

$img_attr = array(
	'class' => 'rsImg'
);

$image_size           = 'large';
$show_slideshow       = false;
$featured_image       = thb_get_featured_image( $image_size, thb_get_page_ID() );
$thb_get_page_sidebar = thb_get_page_sidebar();

if ( ! empty( $thb_get_page_sidebar ) || is_home() ) {
	$image_size = 'medium';
}

if ( is_single() && thb_get_post_format() == 'image' ) {
	$featured_image_src = thb_get_post_format_image_src( $image_size );
	$featured_image = $featured_image_src['scaled'];
}

?>
<?php if( ! empty( $featured_image ) && thb_get_post_format() != 'gallery' ) : ?>
	<div class="thb-page-section thb-featured-image-section">
		<?php thb_featured_image( $image_size, array(
			'link_class' => 'item-thumb thb-page-featured-image',
		) ); ?>
	</div>
<?php endif; ?>