<?php
/**
 * @package WordPress
 * @subpackage Superba
 * @since Superba 1.0
 */
$page_sidebar = thb_get_page_sidebar( thb_get_page_ID() );
get_header(); ?>

<?php thb_page_before(); ?>

<div class="thb-content-section">

	<?php thb_page_start(); ?>

	<div class="thb-content-section-inner-wrapper">

		<div id="thb-main-content" class="thb-page-content-wrapper">

			<?php
				rewind_posts();
				get_template_part('loop/attachments');
			?>

		</div>

	</div>

	<?php thb_page_end(); ?>

</div>

<?php thb_page_after(); ?>

<?php get_footer(); ?>