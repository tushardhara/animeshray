<?php
	if ( !isset( $args ) ) {
		$args = array();
	}

	$thb_thumbnails_open_post = thb_thumbnails_open_post();

	if ( isset( $_block_data ) ) {
		$thb_thumbnails_open_post = thb_isset( $_block_data, 'thumbnails_open_post', false );
	}

	$thb_get_page_sidebar = thb_get_page_sidebar();

	thb_post_query( $args );

	$is_carousel = isset( $args['carousel'] ) && $args['carousel'] == '1';
	$class = $is_carousel ? 'thb-carousel' : 'thb-masonry-container';
	$attrs = array();

	if ( $is_carousel ) {
		$attrs = thb_get_carousel_attributes( $args );
	}
?>

<div class="<?php echo esc_attr( $class ); ?>" <?php thb_attributes( $attrs ); ?>>

	<?php if( have_posts() ) : $i=1; while( have_posts() ) : the_post(); ?>
		<?php thb_loop_post_before(); ?>
		<?php
			$thb_post_id = get_the_ID();
			$thb_post_classes = thb_get_post_classes( $i, array('item list'), 2 );
			$thb_post_classes[] = 'masonry';
			$thb_thumb_size = 'grid-large-cropped';
		?>

		<article <?php post_class( $thb_post_classes ); ?>>
			<?php thb_loop_post_start(); ?>
				<?php
					thb_get_template_part( 'loop/formats/masonry', array(
						'thb_thumb_size' => $thb_thumb_size,
						'thb_thumbnails_open_post' => $thb_thumbnails_open_post
					) );
				?>
			<?php thb_loop_post_end(); ?>
		</article>

		<?php thb_loop_post_after(); ?>
	<?php $i++; endwhile; ?>

</div>

<?php else : ?>

	<div class="notice warning">
		<p><?php _e( 'Sorry, there aren\'t posts to be shown!', 'thb_text_domain' ); ?></p>
	</div>

<?php endif; ?>