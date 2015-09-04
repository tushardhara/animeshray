<?php
/**
 * @package WordPress
 * @subpackage Superba
 * @since Superba 1.0
 */
get_header();


if( is_category() ) {
	$thb_pagetitle = single_cat_title( '', false );
	$thb_subtitle = __("Articles from this Category", 'thb_text_domain');
}
elseif( is_tag() ) {
	$thb_pagetitle = single_cat_title( '', false );
	$thb_subtitle = __("Articles from this Tag", 'thb_text_domain');
}
elseif( is_tax() ) {
	$thb_pagetitle = single_cat_title( '', false );
	$thb_subtitle = __("Articles from this Taxonomy", 'thb_text_domain');
}
elseif( is_search() ) {
	$thb_subtitle = __( 'Search Results', 'thb_text_domain' );
	$thb_pagetitle = ' &ldquo;' . get_search_query() . '&rdquo;';
}
elseif( is_author() ) {
	if(have_posts()) {
		the_post();
		$thb_pagetitle = get_the_author();
		$thb_subtitle = __("Author archive", 'thb_text_domain');
		rewind_posts();
	}
}
elseif ( is_day() ) {
	$thb_pagetitle = get_the_date();
	$thb_subtitle = __("Archives", 'thb_text_domain');
}
elseif ( is_month() ) {
	$thb_pagetitle = get_the_date( 'F Y' );
	$thb_subtitle = __("Archives", 'thb_text_domain');
}
elseif ( is_year() ) {
	$thb_pagetitle = get_the_date( 'Y' );
	$thb_subtitle = __("Archives", 'thb_text_domain');
}

?>

<?php thb_page_before(); ?>

<div class="thb-content-section">

	<?php thb_page_start(); ?>

	<div class="thb-content-section-inner-wrapper">

		<?php thb_get_template_part('partials/partial-pageheader', array( 'thb_title' => $thb_pagetitle, 'thb_subtitle' => $thb_subtitle, 'show_featured_image' => false ) ); ?>

		<div id="thb-main-content" class="thb-page-content-wrapper">

			<?php
				rewind_posts();
				get_template_part('loop/archive');
			?>

		</div>

	</div>

	<?php thb_archives_sidebar(); ?>

	<?php thb_page_end(); ?>

</div>

<?php thb_page_after(); ?>

<?php get_footer(); ?>