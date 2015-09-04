<?php
/**
 * @package WordPress
 * @subpackage Superba
 * @since Superba 1.0
 * Template name: Album - slideshow
 */
$page_sidebar = thb_get_page_sidebar( thb_get_page_ID() );

global $post;

function thb_slideshow_template_load() {
	echo '<span class="thb-fake-filler"></span>';
	thb_get_template_part( 'partials/partial-slideshow' );
}

if ( ! wp_is_mobile() && thb_is_slideshow_fullscreen() && thb_is_theme_layout_a() ) {
	add_action( 'thb_slideshow_fullscreen_hook', 'thb_slideshow_template_load' );
}

get_header(); ?>

<?php thb_page_before(); ?>

<?php if ( ! wp_is_mobile() && thb_is_slideshow_fullscreen() && ! thb_is_theme_layout_a() ) : ?>
	<?php thb_get_template_part( 'partials/partial-slideshow' ); ?>
<?php endif; ?>

<div class="thb-content-section <?php if ( thb_is_content_available( $post ) ) : ?>thb-content-available<?php endif; ?>">

	<?php thb_page_start(); ?>

	<div class="thb-content-section-inner-wrapper">

		<?php thb_get_template_part( 'partials/partial-pageheader' ); ?>

		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

			<?php if ( get_the_content() || thb_check_action_hook_empty( 'the_content' ) ) : ?>
				<div id="thb-main-content" class="thb-page-section thb-page-content-wrapper">

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

		<?php wp_reset_query(); ?>

		<?php if ( thb_is_builder_position_gallery_pages_top() ) : ?>
			<?php thb_builder_hook(); ?>
		<?php endif; ?>

	</div>

</div>

<?php if ( wp_is_mobile() || ! thb_is_slideshow_fullscreen() ) {
	thb_get_template_part( 'partials/partial-slideshow' );
} ?>

<?php if ( ! thb_is_builder_empty() && thb_is_builder_position_gallery_pages_bottom() ) : ?>
	<div class="thb-content-section thb-content-available">
		<div class="thb-content-section-inner-wrapper">
			<?php thb_builder_hook(); ?>
		</div>
	</div>
<?php endif; ?>

<div class="thb-content-section">

	<div class="thb-content-section-inner-wrapper">

		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
			<?php if( thb_show_comments() ) : ?>

				<div class="thb-page-content-wrapper">

					<section class="thb-page-section secondary">
					<?php if( thb_show_comments() ) : ?>
						<?php thb_comments( array('title_reply' => '<span>' . __('Leave a reply', 'thb_text_domain') . '</span>' )); ?>
					<?php endif; ?>
					</section>

				</div>

			<?php endif; ?>
		<?php endwhile; endif; ?>

	</div>

	<?php thb_page_end(); ?>

</div>

<?php thb_page_after(); ?>

<?php get_footer(); ?>