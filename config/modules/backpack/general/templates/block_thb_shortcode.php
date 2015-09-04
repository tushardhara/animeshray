<?php thb_builder_fake_query(); ?>
<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

	<div class="thb-section-block-content">

		<div class="thb-text">
			<?php if ( $shortcode != '' ) : ?>
				<?php echo do_shortcode( $shortcode ); ?>
			<?php endif; ?>
		</div>

	</div>

<?php endwhile; endif; ?>

<?php wp_reset_query(); ?>