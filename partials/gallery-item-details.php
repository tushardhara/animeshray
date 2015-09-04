<?php if ( ! empty( $item['title'] ) || ! empty( $item['description'] ) ) : ?>
	<div class="thb-gallery-item-details">

		<a href="#" class="thb-gallery-item-details-toggle"><?php _e( 'Details', 'thb_text_domain' ); ?></a>

		<div class="thb-gallery-item-details-wrapper">
			<?php if ( ! empty( $item['title'] ) ) : ?>
				<p class="thb-gallery-item-details-title"><?php echo thb_text_format( $item['title'], false ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $item['description'] ) ) : ?>
				<?php echo thb_text_format( $item['description'], true ); ?>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>