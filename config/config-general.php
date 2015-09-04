<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

/**
 * Theme config.
 *
 * ---
 *
 * The Happy Framework: WordPress Development Framework
 * Copyright 2012, Andrea Gandino & Simone Maranzana
 *
 * Licensed under The MIT License
 * Redistribuitions of files must retain the above copyright notice.
 *
 * @package Config
 * @author The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright 2012, Andrea Gandino & Simone Maranzana
 * @link http://
 * @since The Happy Framework v 1.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$thb_theme = thb_theme();

/**
 * APPEARANCE
 * -----------------------------------------------------------------------------
 */

// Scripts and styles

thb_theme()->getFrontend()->addStyle(get_template_directory_uri() . '/css/theme-fonts.css', array(
	'name' => 'thb_theme_fonts'
));
thb_theme()->getFrontend()->addStyle(get_template_directory_uri() . '/css/layout.css', array(
	'name' => 'thb_layout'
));

if ( ! function_exists( 'thb_superba_frontend_scripts' ) ) {
	/**
	 * Array of scripts that are concatenated into a single file called js/script.compact.js, which
	 * can be loaded by checking the Compact frontend script option under the
	 * Framework Settings admin page.
	 *
	 * Used for development only.
	 *
	 * @param array $scripts
	 * @return array
	 */
	function thb_superba_frontend_scripts( $scripts ) {
		$scripts[] = THB_FRONTEND_JS_PATH . '/filter.js';
		$scripts[] = THB_FRONTEND_JS_PATH . '/isotope.js';
		$scripts[] = get_template_directory() . '/js/modernizr.min.js';
		$scripts[] = get_template_directory() . '/js/fastclick.js';
		$scripts[] = get_template_directory() . '/js/jquery.royalslider.min.js';
		$scripts[] = get_template_directory() . '/js/jquery.scrollTo.min.js';
		$scripts[] = get_template_directory() . '/js/isotope.pkgd.min.js';
		$scripts[] = get_template_directory() . '/js/jquery.fitvids.js';
		$scripts[] = get_template_directory() . '/js/nprogress.min.js';
		$scripts[] = get_template_directory() . '/js/slideshow.js';
		$scripts[] = get_template_directory() . '/js/sly.min.js';
		$scripts[] = get_template_directory() . '/js/jquery.iskip.js';
		$scripts[] = get_template_directory() . '/js/tiptop.js';
		$scripts[] = get_template_directory() . '/js/hammer.min.js';
		$scripts[] = get_template_directory() . '/js/cssua.min.js';
		$scripts[] = get_template_directory() . '/js/script.js';

		return $scripts;
	}
}

add_filter( 'thb_frontend_scripts', 'thb_superba_frontend_scripts' );

if ( thb_compress_frontend_scripts() ) {
	$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/script.compact.js' );
}
else {
	$thb_theme->getFrontend()->addScript( THB_FRONTEND_JS_URL . '/filter.js' );
	$thb_theme->getFrontend()->addScript( THB_FRONTEND_JS_URL . '/isotope.js' );
	$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/modernizr.min.js' );

	/* Mobile-only scripts. */
	if ( wp_is_mobile() ) {
		$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/fastclick.js' );
		$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/hammer.min.js' );
	}

	$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/jquery.royalslider.min.js' );
	$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/jquery.scrollTo.min.js' );
	$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/isotope.pkgd.min.js' );
	$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/jquery.fitvids.js' );
	$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/nprogress.min.js' );
	$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/slideshow.js' );
	$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/sly.min.js' );
	$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/jquery.iskip.js' );
	$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/tiptop.js' );
	$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/cssua.min.js' );

	$thb_theme->getFrontend()->addScript( get_template_directory_uri() . '/js/script.js' );
}

function thb_frontend_default_scripts( $scripts ) {
	$scripts[] = 'underscore';
	return $scripts;
}

add_filter( 'thb_frontend_default_scripts', 'thb_frontend_default_scripts' );

// Editor style

function thb_superba_add_editor_styles() {
    add_editor_style( 'css/editor-style.css' );
}
add_action( 'init', 'thb_superba_add_editor_styles' );

// Responsive

if( !function_exists('thb_html_class_filter') ) {
	function thb_html_class_filter( $classes ) {
		if( thb_get_option('enable_responsive_768') == 1 ) {
			$classes[] = 'responsive_768';
		}

		if( thb_get_option('enable_responsive_480') == 1 ) {
			$classes[] = 'responsive_480';
		}

		return $classes;
	}

	add_filter('thb_html_class', 'thb_html_class_filter');
}

// Theme meta data

if( !function_exists('thb_theme_meta') ) {
	function thb_theme_meta() {
		thb_meta('viewport', 'width=device-width, initial-scale=1.0, maximum-scale=1.0');
	}

	add_action( 'thb_head_meta', 'thb_theme_meta' );
}

if( !function_exists('thb_ie_fixes') ) {
	// IE Fix
	function thb_ie_fixes() {
		thb_ie();
	}

	add_action( 'wp_head', 'thb_ie_fixes', 9998 );
}

// The image sizes

add_image_size( 'micro', 80, 80, true ); // used for related posts
add_image_size( 'thumbnail', 160, 160, true ); // system image size used also on page/post builder blocks
add_image_size( 'large', 1160, null ); // system image size used in the single attachment page
add_image_size( 'large-cropped', 1160, 650, true ); // system image size used in the single attachment page
add_image_size( 'medium', 760, null ); // system image size used also on page/post builder blocks
add_image_size( 'medium-cropped', 760, 420, true ); // system image size used also on page/post builder blocks
add_image_size( 'carousel', null, 600 ); // used for the carousel gallery page template

add_image_size( 'grid-large', 360, null ); // used by the grid layouts (photgallery, portfolio) on 3 and 4 columns configuration with the "variable" height option set
add_image_size( 'grid-large-cropped', 360, 360, true ); // used by the grid layouts (photgallery, portfolio) on 3 and 4 columns configuration with the "fixed" height option set
add_image_size( 'grid-small', 200, null ); // used by the grid layouts (photgallery, portfolio) on 5 columns configuration with the "variable" height option set
add_image_size( 'grid-small-cropped', 200, 200, true ); // used by the grid layouts (photgallery, portfolio) on 5 columns configuration with the "fixed" height option set

// Menus

register_nav_menus(array(
	'primary' => __( 'Primary navigation', 'thb_text_domain' )
));

register_nav_menus(array(
	'mobile' => __( 'Mobile navigation', 'thb_text_domain' )
));

if( ! function_exists( 'thb_get_theme_templates' ) ) {
	/**
	 * Return the theme templates.
	 *
	 * @param boolean|string $key
	 * @return array
	 */
	function thb_get_theme_templates( $key = false ) {
		$templates = array(
			'*' => array(
				'single.php'
			),
			'templates' => array(
				'default',
				'template-blank.php'
			),
			'blog' => array(
				'template-blog.php',
				'template-blog-grid.php'
			),
			'gallery' => array(
				'template-grid-gallery.php',
				'template-slideshow-gallery.php',
				'template-carousel-gallery.php',
				'template-mosaic-gallery.php',
			),
			'projects' => array(
				'template-projects-grid.php',
				'single-works.php'
			)
		);

		if ( $key && isset( $templates[$key] ) ) {
			return $templates[$key];
		}

		$return = array();

		foreach ( $templates as $key => $tpls ) {
			foreach ( $tpls as $tpl ) {
				$return[] = $tpl;
			}
		}

		return array_unique( $return );
	}
}

if ( function_exists( 'is_woocommerce' ) ) {
	/**
	 * Define image sizes
	 * -------------------------------------------------------------------------
	 */

	if( !function_exists('thb_woocommerce_image_size_shop_single') ) {
		function thb_woocommerce_image_size_shop_single( $size ) {
			return array(
				'width' => 760,
				'height' => null,
				'crop' => false
			);
		}
	}

	if( !function_exists('thb_woocommerce_image_size_shop_catalog') ) {
		function thb_woocommerce_image_size_shop_catalog( $size ) {
			return array(
				'width' => 360,
				'height' => 360,
				'crop' => true
			);
		}
	}

	if( !function_exists('thb_woocommerce_image_size_shop_thumbnail') ) {
		function thb_woocommerce_image_size_shop_thumbnail( $size ) {
			return array(
				'width' => 80,
				'height' => 80,
				'crop' => true
			);
		}
	}

	add_filter('woocommerce_get_image_size_shop_thumbnail', 'thb_woocommerce_image_size_shop_thumbnail', 999);
	add_filter('woocommerce_get_image_size_shop_catalog', 'thb_woocommerce_image_size_shop_catalog', 999);
	add_filter('woocommerce_get_image_size_shop_single', 'thb_woocommerce_image_size_shop_single', 999);
}