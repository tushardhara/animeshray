<?php

if ( $grid_item['type'] == 'image' ) {
	$cover = thb_image_get_size( $grid_item['id'], $thb_size );
}
else {
	$cover = $grid_item['url'];
}

?>

<a href="<?php echo esc_attr( $cover ); ?>" class="item-thumb">
	<span class="thb-overlay"></span>
	<img src="<?php echo esc_attr( $cover ); ?>" alt="">
</a>

<?php if ( $grid_item['title'] != '' || $grid_item['project'] != '' ) : ?>
	<div class="thb-gallery-data">
		<?php if ( $grid_item['title'] != '' ) : ?>
			<h3><?php echo thb_text_format( $grid_item['title'] ); ?></h3>
		<?php endif; ?>

		<?php if ( $grid_item['project'] ) : ?>
			<p>
				<a href="<?php echo esc_url( $grid_item['project']['permalink'] ); ?>"><?php echo $grid_item['project']['name']; ?></a>
			</p>
		<?php endif; ?>
	</div>
<?php endif; ?>