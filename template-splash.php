<?php
/**
 * @package WordPress
 * @subpackage Superba
 * @since Superba 1.0
 * Template name: Splash page
 */

$splash_title = "";
$splash_subtitle = thb_get_splash_subtitle();

if ( thb_get_splash_title() != '' ) {
	$splash_title = thb_get_splash_title();
}

$overlay_color = thb_get_splash_overlay_color();
$overlay_opacity = thb_get_splash_overlay_opacity();

$splash_featured_image = thb_get_featured_image( 'full', thb_get_page_ID() );

$slide_attrs = 'background-image: url(' . $splash_featured_image . ')';

$skin = "";
if ( ! empty( $overlay_color ) ) {
	$skin = ' thb-skin-' . thb_color_get_opposite_skin( $overlay_color );
}

thb_before_doctype();
?>
<!doctype html>
<html <?php language_attributes(); ?> <?php thb_html_class(); ?>>
	<head>
		<?php thb_head_meta(); ?>

		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

	<?php thb_body_start(); ?>

		<div id="thb-external-wrapper">

			<div class="thb-splash-content-section <?php echo esc_attr( $skin ); ?>">

				<div class="thb-splash-content-section-inner-wrapper">

					<div class="thb-splash-content-data-wrapper">

						<?php thb_splash_logo(); ?>

						<?php if ( ! empty( $splash_title ) ): ?>
							<div class="thb-splash-title">
								<?php thb_page_title( $splash_title ); ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $splash_subtitle) ) : ?>
							<div class="thb-splash-subtitle">
								<p><?php echo esc_html( $splash_subtitle ); ?></p>
							</div>
						<?php endif; ?>

						<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

							<?php if ( get_the_content() || thb_check_action_hook_empty( 'the_content' ) ) : ?>
								<div class="thb-splash-description">
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

						<?php
							$call_to_label = thb_get_splash_action_label();
							$call_to_url = thb_get_splash_action_url();
							$rel_primary = "";

							if ( ! empty( $call_to_url ) && is_numeric( $call_to_url ) ) {
								$call_to_url = get_permalink( $call_to_url );
							} else {
								$call_to_url = untrailingslashit( $call_to_url );
								$home_url = untrailingslashit( home_url() );

								if ( ! thb_text_startsWith( $call_to_url, $home_url ) ) {
									$rel_primary = 'rel="nofollow"';
								}
							}
						?>

						<?php if ( ! empty( $call_to_url ) && ! empty( $call_to_label ) ) : ?>
							<div>
								<a class="thb-btn splash-call-to" href="<?php echo esc_url( $call_to_url ); ?>" <?php echo esc_attr( $rel_primary ); ?>>
									<?php echo esc_html( $call_to_label ); ?>
								</a>
							</div>
						<?php endif; ?>

					</div>

				</div>

				<?php thb_get_template_part( 'partials/partial-socials', array( 'post_meta' => true ) ); ?>

			</div>

			<div class="thb-splash-media-wrapper">
				<?php if ( !empty( $overlay_opacity ) ) : ?>
					<?php thb_overlay( $overlay_color, $overlay_opacity, 'thb-splash-overlay' ); ?>
				<?php endif; ?>
				<div class="thb-splash-image" style="<?php echo $slide_attrs; ?>"></div>
			</div>

		</div><!-- /#thb-external-wrapper -->

		<?php thb_body_end(); ?>

		<?php thb_footer(); ?>
		<?php wp_footer(); ?>

	</body>
</html>
