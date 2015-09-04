<?php
$thb_columns_classes = explode( ',', thb_get_footer_layout() );
?>

<?php thb_footer_sidebar_before(); ?>

<aside id="thb-footer-sidebar" class="thb-footer-sidebar-external-wrapper">

	<div class="thb-footer-sidebar-section">

		<?php thb_footer_sidebar_start(); ?>

		<div class="thb-footer-sidebar-section-inner-wrapper sidebar">

			<?php $thb_i=0; foreach( $thb_columns_classes as $class ) : ?>
				<?php if( is_active_sidebar('footer-sidebar-' . $thb_i) ) : ?>
					<div class="col <?php echo $class; ?>">
						<?php dynamic_sidebar( 'footer-sidebar-' . $thb_i ); ?>
					</div>
				<?php endif; ?>
			<?php $thb_i++; endforeach; ?>

		</div>

		<?php thb_footer_sidebar_end(); ?>

	</div>

</aside>

<?php thb_footer_sidebar_after(); ?>