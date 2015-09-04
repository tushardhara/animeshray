<?php
/**
 * @package WordPress
 * @subpackage Superba
 * @since Superba 1.0
 */
thb_before_doctype();
global $post;
?>
<!doctype html>
<html <?php language_attributes(); ?> <?php thb_html_class(); ?>>
	<head>
		<?php thb_head_meta(); ?>

		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

		<?php if ( thb_is_slideshow_fullscreen() && ! thb_is_theme_layout_a() ) : ?>
			<span class="thb-fake-filler"></span>
		<?php endif; ?>

		<?php thb_body_start(); ?>

		<div id="thb-external-wrapper">

			<?php thb_get_template_part( 'partials/partial-header.php'); ?>

			<?php thb_slideshow_fullscreen_hook(); ?>

			<div id="thb-page-content-wrapper" class="thb-page-content <?php if ( thb_is_content_available( $post ) ) : ?>thb-content-available<?php endif; ?>">