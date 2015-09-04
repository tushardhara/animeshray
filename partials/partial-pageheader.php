<?php

$thb_format = '';
$thb_link_url = '';
$thb_quote_url = '';
$featured_image = '';
$page_title_class = 'thb-page-title';
$page_subtitle_attr = '';
$page_subtitle_classes = '';

if ( ! isset( $show_featured_image ) ) {
	$show_featured_image = true;
}

if ( ! thb_is_archive() && ! is_home() && ! thb_is_blog() ) {
	$featured_image = thb_get_featured_image( 'full', thb_get_page_ID() );

	if ( ! isset( $thb_title ) ) {
		$thb_title = get_the_title();
	}

	if ( ! isset( $thb_subtitle ) ) {
		$thb_subtitle = thb_get_page_subtitle();
	}
}
else {
	if ( ! isset( $thb_title ) ) {
		$thb_title = '';
	}

	if ( ! isset( $thb_subtitle ) ) {
		$thb_subtitle = '';
	}
}

if ( is_home() || thb_is_blog() ) {
	$show_featured_image = false;
}

if ( is_singular( 'post' ) ) {
	$thb_format = thb_get_post_format();

	if ( thb_get_post_subtitle() != '' ) {
		$thb_subtitle = thb_get_post_subtitle();
	} else {
		$thb_subtitle = get_the_date();
	}

	if ( $thb_format === 'link' ) {
		if ( thb_get_post_subtitle() != '' ) {
			$thb_subtitle = thb_get_post_subtitle();
		} else {
			$thb_subtitle = thb_get_post_format_link_url();
		}
	}
	elseif( $thb_format === 'quote' ) {
		$thb_title = thb_get_post_format_quote_text();
		$thb_quote_url = thb_get_post_format_quote_url();

		if ( thb_get_post_subtitle() != '' ) {
			$thb_subtitle = thb_get_post_subtitle();
		} else {
			$thb_subtitle = thb_get_post_format_quote_author();
		}
	}
}
elseif ( is_singular( 'works') ) {
	$show_featured_image = false;

	if ( thb_get_project_short_description() != '' ) {
		$thb_subtitle = thb_get_project_short_description();
	}
}

if ( thb_is_page_template( thb_get_theme_templates( 'gallery' ) ) ) {
	if ( thb_gallery_disable_featured_image() == 1 ) {
		$show_featured_image = false;
	}
}

$show_page_header = (
	! thb_page_header_disabled()
	&& ! ( thb_slideshow_has_slides() )
);

if( is_single() && post_password_required() ) {
	$show_featured_image = false;
}

if ( is_singular( 'post' ) ) {
	$page_title_class .= " entry-title";
	$page_subtitle_classes = "updated published";

	$timestamp = strtotime( get_the_date() );
	$microdate = date( 'Ymd', $timestamp );

	$page_subtitle_attr = 'title="' . $microdate . '"';
}

?>

<?php
	$page_header_classes = array();

	if ( ! $show_page_header ) {
		$page_header_classes[] = 'thb-page-section-disabled';
	}
?>

<div id="thb-page-header" class="thb-page-section thb-page-header-section <?php echo esc_attr( implode( ' ', $page_header_classes ) ); ?>">


	<div class="thb-page-header-section-inner-wrapper <?php if ( ! $show_page_header ) : ?>hidden<?php endif; ?>">

		<?php if ( thb_is_subtitle_position_bottom() ) : ?>
			<?php thb_page_title( $thb_title, $page_title_class ); ?>
		<?php endif; ?>

		<?php if( !empty($thb_subtitle) ) : ?>
			<p class="thb-page-subtitle <?php echo $page_subtitle_classes; ?>" <?php echo $page_subtitle_attr; ?>>
				<?php if ( $thb_format === 'link' && thb_get_post_subtitle() == '' ) : ?>
					<a href="<?php echo esc_url( $thb_subtitle ); ?>" target="_blank">
						<?php echo esc_url( $thb_subtitle ); ?>
					</a>
				<?php else : ?>
					<span><?php echo $thb_subtitle; ?></span>
				<?php endif; ?>
			</p>
		<?php endif; ?>

		<?php if ( thb_is_subtitle_position_top() ) : ?>
			<?php thb_page_title( $thb_title, $page_title_class ); ?>
		<?php endif; ?>

	</div>


</div>

<?php if ( $show_featured_image && ! thb_is_archive() && ! is_home() && ! thb_is_blog() ) : ?>
	<?php get_template_part( 'partials/partial-page-featured-image' ); ?>
<?php endif; ?>