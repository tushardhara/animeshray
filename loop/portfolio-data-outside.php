<a href="<?php echo thb_portfolio_item_permalink(); ?>" rel="bookmark" class="thb-work-thumb thb-block-type-element-thumb">
	<span class="thb-work-overlay thb-block-type-element-overlay"></span>
	<?php if( ! empty( $args['portfolio_images'] ) ) : ?>
		<img class="<?php echo $args['image_class']; ?>" src="<?php echo $args['thb_fi']; ?>" alt="" data-images="<?php echo esc_attr( implode( ',', $args['portfolio_images'] ) ); ?>">
	<?php endif; ?>
</a>

<div class="thb-block-type-element-data-wrapper">

	<h3>
		<a href="<?php echo thb_portfolio_item_permalink(); ?>" rel="bookmark">
			<?php echo $args['thb_title']; ?>
		</a>
	</h3>

	<?php if( $args['thb_subtitle'] != "" ) : ?>
		<p><?php echo $args['thb_subtitle']; ?></p>
	<?php endif; ?>

</div>