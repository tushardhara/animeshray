<?php
/**
 * @package WordPress
 * @subpackage Superba
 * @since Superba 1.0
 * Template name: Blog grid
 */
$page_sidebar = thb_get_page_sidebar( thb_get_page_ID() );
get_header(); ?>

<?php thb_page_before(); ?>

<div class="thb-content-section">

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

		<?php thb_builder_hook(); ?>

		<?php get_template_part('loop/blog', 'masonry'); ?>
		<?php thb_numeric_pagination(); ?>

		<?php wp_reset_query(); ?>

	</div>

	<?php thb_page_end(); ?>

</div>

<?php thb_page_after(); ?>

<?php get_footer(); ?>