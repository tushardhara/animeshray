<?php
/**
 * @package WordPress
 * @subpackage Superba
 * @since Superba 1.0
 */

$thb_page_id = thb_get_page_ID();

$slides = thb_get_portfolio_item_slides( $thb_page_id );

if( !function_exists('thb_single_work_lightbox_class') ) {
	function thb_single_work_lightbox_class() {
		return 'thb-gallery-lightbox nothumb';
	}
}

add_filter( 'thb_lightbox_class', 'thb_single_work_lightbox_class', 20 );

$slides_config = array(
	'overlay'    => false,
	'link'       => false
);

$featured_image_config = array(
	'link'       => false,
	'overlay'    => false
);

$image_size = 'large';

$prj_info = thb_duplicable_get('prj_info', $thb_page_id);
$has_prj_info = !empty($prj_info);

$work_categories = wp_get_object_terms($thb_page_id, 'portfolio_categories');
$cats = array();
foreach( $work_categories as $cat ) {
	$cats[] = $cat->name;
}

$show_pagination = ( thb_post_has_previous() || thb_post_has_next() ) && thb_show_pagination();

get_header(); ?>

<?php thb_post_before(); ?>

<div class="thb-content-section">

	<?php thb_post_start(); ?>

	<div class="thb-content-section-inner-wrapper">

		<?php thb_get_template_part( 'partials/partial-pageheader' ); ?>

		<?php thb_single_content_start(); ?>

		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

			<div id="thb-main-content" class="thb-page-section thb-page-content-wrapper">

				<div id="single-work-container" <?php post_class(); ?>>

					<div class="single-work-secondary-data">

						<?php if ( get_the_content() != '' || apply_filters( 'the_content', '' ) ) : ?>

							<div class="thb-project-text">
								<div class="thb-text">
									<?php if ( get_the_content() ) : ?>
										<?php the_content(); ?>
									<?php else : ?>
										<?php echo apply_filters( 'the_content', '' ); ?>
									<?php endif; ?>
								</div>
							</div>

						<?php endif; ?>

						<aside class="thb-project-info">
							<?php if( $has_prj_info ) : ?>
								<?php foreach( $prj_info as $info ) : ?>
									<p>
										<?php if ( thb_text_startsWith( $info['value']['value'], 'http://' ) ) : ?>
											<a href="<?php echo esc_url( $info['value']['value'] ); ?>"><?php echo esc_url( $info['value']['key'] ); ?></a>
										<?php else : ?>
											<span class="thb-project-label"><?php echo $info['value']['key']; ?></span>
											<?php echo $info['value']['value']; ?>
										<?php endif; ?>
									</p>
								<?php endforeach; ?>
							<?php endif; ?>

							<?php if( ! empty($cats) ) : ?>
								<p><span class="thb-project-label"><?php _e( 'Project categories', 'thb_text_domain' ); ?>: </span><?php echo implode(', ', $cats); ?></p>
							<?php endif; ?>

							<?php if ( thb_portfolio_item_get_external_url() != '' ) : ?>
								<?php $external_url = thb_portfolio_item_get_external_url(); ?>
								<p><span class="thb-project-label"><?php _e( 'External URL', 'thb_text_domain' ); ?>: </span><a href="<?php echo $external_url; ?>" rel="external"><?php echo $external_url; ?></a></p>
							<?php endif; ?>

							<?php if ( thb_is_enable_social_share() ) : ?>
								<div class="meta social-actions">
									<?php if ( thb_is_enable_social_share() ) : ?>
										<?php thb_get_template_part('partials/partial-share'); ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<?php if ( thb_is_portfolio_likes_active() ) : ?>
								<?php thb_like(); ?>
							<?php endif; ?>

						</aside>

					</div>

					<?php thb_get_template_part( 'partials/partial-single-work-slides', array(
						'slides'                => $slides,
						'image_size'            => $image_size,
						'featured_image_config' => $featured_image_config,
						'slides_config'         => $slides_config
					) ); ?>

				</div>

			</div>

		<?php endwhile; endif; ?>

		<?php wp_reset_query(); ?>

		<?php
			remove_filter( 'thb_lightbox_class', 'thb_single_work_lightbox_class', 20 );
		?>

		<?php thb_builder_hook(); ?>

		<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

			<?php if ( $show_pagination || thb_show_comments() ) : ?>

				<div class="thb-page-content-wrapper">

					<div class="thb-page-section thb-project-footer">

						<div class="thb-project-footer-inner-wrapper">

						<?php if ( $show_pagination ) : ?>
							<div class="thb-project-footer-nav <?php if ( function_exists( 'thb_portfolio_loop' ) ) : ?>w-archive<?php endif; ?>">
								<h3><span><?php _e( 'Navigation', 'thb_text_domain' ); ?></span></h3>
								<?php
									add_action( 'thb_between_navigation', 'thb_portfolio_index' );

									thb_pagination(
										array(
											'single_prev'     => __( 'Previous', 'thb_text_domain' ),
											'single_next'     => __( 'Next', 'thb_text_domain' ),
										)
									);
								?>
							</div>
						<?php endif; ?>

					<?php if ( function_exists( 'thb_portfolio_loop' ) ) : ?>
						<?php
							thb_portfolio_query(
								array(
									'post__not_in' => array( thb_get_page_ID() ),
									'posts_per_page' => -1
								)
							);
						?>

						<?php if( have_posts() ) : ?>
							<div class="thb-project-footer-archive">
								<h3><span><?php _e( 'Projects archive', 'thb_text_domain' ); ?></span></h3>
								<ul class="thb-projects-archive">
									<?php while( have_posts() ) : ?>
										<?php the_post(); ?>

										<li id="post-<?php the_ID(); ?>" <?php thb_portfolio_post_class(); ?>>
											<article>
												<a href="<?php echo thb_portfolio_item_permalink(); ?>" rel="bookmark">
													<h3><?php the_title(); ?></h3>
												</a>
											</article>
										</li>

									<?php endwhile; ?>
								</ul>
							</div>
						<?php endif; ?>

						<?php wp_reset_query(); ?>

						<?php endif; ?>

						</div>

					</div>

					<?php if( thb_show_comments() ) : ?>
						<section class="thb-page-section secondary">
						<?php if( thb_show_comments() ) : ?>
							<?php thb_comments( array('title_reply' => '<span>' . __('Leave a reply', 'thb_text_domain') . '</span>' )); ?>
						<?php endif; ?>
						</section>
					<?php endif; ?>

				</div>

			<?php endif; ?>

		<?php endwhile; endif; ?>

	</div>

<?php thb_post_end(); ?>

</div>

<?php thb_post_after(); ?>

<?php get_footer(); ?>