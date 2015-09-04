<?php
/**
 * @package WordPress
 * @subpackage Superba
 * @since Superba 1.0
 */
$thb_format = thb_get_post_format();
$thb_tags = get_the_tags();
$thb_category = get_the_category();
get_header(); ?>

<?php thb_post_before(); ?>

<div class="thb-content-section">

	<?php thb_post_start(); ?>

	<div class="thb-content-section-inner-wrapper">

		<?php thb_get_template_part( 'partials/partial-pageheader' ); ?>

		<?php thb_single_content_start(); ?>

		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

			<div id="thb-main-content" class="thb-page-section thb-page-content-wrapper">

				<?php thb_get_template_part('partials/partial-single-formats'); ?>

				<div <?php post_class('thb-text entry-content'); ?>>

					<?php the_content(); ?>

					<?php
						wp_link_pages(array(
							'pagelink' => '<span>%</span>',
							'before'   => '<div id="page-links"><p><span class="pages">'. __('Pages', 'thb_text_domain').'</span>',
							'after'    => '</p></div>'
						));
					?>

				</div>
			</div>

		<?php endwhile; endif; ?>

		<?php wp_reset_query(); ?>

		<?php thb_builder_hook(); ?>

		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

			<div class="thb-page-content-wrapper">

				<div class="thb-page-section meta details">
					<ul>
						<li>
							<?php _e('By', 'thb_text_domain'); ?>
							<?php the_author_posts_link(); ?>
						</li>
						<?php if( !empty($thb_category) ) : ?>
						<li>
							<span><?php _e('Filed under', 'thb_text_domain'); ?> <?php the_category(', '); ?>.</span>
						</li>
						<?php endif; ?>
						<?php if( !empty($thb_tags) ) : ?>
						<li>
							<span><?php _e('Tagged', 'thb_text_domain'); ?> <?php the_tags('', ', '); ?>.</span>
						</li>
						<?php endif; ?>
						<?php if( thb_is_blog_likes_active() ) : ?>
						<li>
							<span><?php _e('Liked', 'thb_text_domain'); ?> </span><?php thb_like(); ?> <span><?php _e('times', 'thb_text_domain'); ?> </span>
						</li>
						<?php endif; ?>
					</ul>

					<?php if ( thb_is_enable_social_share() ) : ?>
						<div class="meta social-actions">
							<?php if ( thb_is_enable_social_share() ) : ?>
								<?php thb_get_template_part('partials/partial-share'); ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

				<?php
					thb_pagination(
						array(
							'single_prev_template' => 'thb_single_prev_custom_pagination',
							'single_next_template' => 'thb_single_next_custom_pagination'
						)
					);
				?>

				<?php if( thb_author_block_enabled() ) : ?>
					<div class="thb-page-section meta author-block">
						<?php echo get_avatar( get_the_author_meta( 'ID' ) , 80 ); ?>

						<div class="author-block-wrapper vcard author">
							<p><span><?php _e('About', 'thb_text_domain'); ?></span> <span class="fn"><?php the_author_posts_link(); ?></span></p>

							<?php
								$author_description = get_the_author_meta('user_description');
								if( !empty($author_description) ) :
							?>
								<div class="thb-text">
									<?php echo thb_text_format($author_description, true); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if( thb_show_related() ) : ?>
					<section class="thb-page-section thb-related">
						<h3><span><?php _e('Related posts', 'thb_text_domain'); ?></span></h3>
						<?php thb_related_posts(); ?>
					</section>
				<?php endif; ?>

				<?php if( thb_show_comments() ) : ?>
					<section class="thb-page-section secondary">
					<?php if( thb_show_comments() ) : ?>
						<?php thb_comments( array('title_reply' => '<span>' . __('Leave a reply', 'thb_text_domain') . '</span>' )); ?>
					<?php endif; ?>
					</section>
				<?php endif; ?>

			</div>

		<?php endwhile; endif; ?>

	</div>

	<?php thb_page_sidebar(); ?>

<?php thb_post_end(); ?>

</div>

<?php thb_post_after(); ?>

<?php get_footer(); ?>