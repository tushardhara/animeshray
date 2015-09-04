<a href="<?php echo thb_portfolio_item_permalink(); ?>" rel="bookmark" class="thb-work-thumb thb-block-type-element-thumb">

	<div class="thb-block-type-element-external-wrapper">

		<div class="thb-block-type-element-wrapper">
			<div class="thb-block-type-element-inner-wrapper">
				<div class="thb-block-type-element-data-wrapper">

					<h3>
						<?php echo $args['thb_title']; ?>
					</h3>

					<?php if( $args['thb_subtitle'] != "" ) : ?>
						<p><?php echo $args['thb_subtitle']; ?></p>
					<?php endif; ?>

				</div>
			</div>
		</div>

	</div>

	<?php if( ! empty( $args['portfolio_images'] ) ) : ?>
		<div class="thb-block-type-element-image-wrapper">
			<span class="thb-overlay"></span>
			<img class="<?php echo $args['image_class']; ?>" src="<?php echo $args['thb_fi']; ?>" alt="" data-images="<?php echo esc_attr( implode( ',', $args['portfolio_images'] ) ); ?>">
		</div>
	<?php endif; ?>
</a>