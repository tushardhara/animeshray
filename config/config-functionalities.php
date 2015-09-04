<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

/**
 * Theme functionalities.
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

require_once dirname( __FILE__ ) . '/helpers.php';
require_once dirname( __FILE__ ) . '/gallery/module.php';

$thb_theme = thb_theme();

$thb_theme->loadModule('backpack', array(
	'layout' => array(
		'options_logo_position' => false,
		'grid_columns' => array(
			'3' => array( 'fixed' => 'grid-large-cropped', 'variable' => 'grid-large' ),
			'4' => array( 'fixed' => 'grid-large-cropped', 'variable' => 'grid-large' ),
			'5' => array( 'fixed' => 'grid-small-cropped', 'variable' => 'grid-small' )
		),
		'meta_options_pageheader_disable' => thb_get_theme_templates()
	),
	'blog' => array(
		'enable_author_block' => true,
		'sidebars' => true,
		'templates' => array(
			'template-blog.php',
			'template-blog-grid.php',
		),
		'builder_blog_layouts' => array(
			'classic'  => __( 'Classic', 'thb_text_domain' ),
			'masonry'  => __( 'Masonry', 'thb_text_domain' ),
		),
		'subtitle' => true
	),
	'like' => array(),
	'sidebars' => array(
		'templates' => array(
			'default',
			'template-blank.php',
			'single.php'
		)
	),
	'photogallery' => array(
		'templates' => array(),
		'builder_block_columns' => array(
			'3' => '3',
			'4' => '4',
			'5' => '5'
		)
	),
	'builder' => array(
		'templates' => array(
			'default',
			'single.php',
			'single-works.php',
			'template-blog.php',
			'template-blog-grid.php',
			'template-carousel-gallery.php',
			'template-grid-gallery.php',
			'template-mosaic-gallery.php',
			'template-slideshow-gallery.php',
			'template-projects-grid.php',
			'template-blank.php'
		),
		'advanced_markup' => true,
		'options' => false,
		'appearance_width' => false
	),
	'general' => array(
		'builder_text_box_layout_styles' => array(
			'layout-style-a' => __('Standard header', 'thb_text_domain'),
			'layout-style-b' => __('Small header', 'thb_text_domain'),
			'layout-style-c' => __('Medium header', 'thb_text_domain'),
			'layout-style-d' => __('Big header', 'thb_text_domain')
		),
		'analytics' => false
	)
) );

if( ! function_exists( 'thb_superba_portfolio_config' ) ) {
	/**
	 * Portfolio configuration.
	 *
	 * @param array $config
	 * @return array
	 */

	function thb_superba_portfolio_options_tab_title( $title ) {
		return __( 'Projects', 'thb_text_domain' );
	}

	add_filter( 'thb_portfolio_options_tab_title', 'thb_superba_portfolio_options_tab_title' );

	function thb_superba_portfolio_index_options( $templates ) {
		return array(
			'template-projects-grid.php'
		);
	}

	add_filter( 'thb_portfolio_index_options', 'thb_superba_portfolio_index_options' );

	function thb_superba_portfolio_config( $config ) {
		$config['works_default_slug'] = 'project';
		$config['templates'] = array(
			'template-projects-grid.php'
		);
		$config['ajax'] = array('template-projects-grid.php');
		$config['work_slides'] = true;
		$config['works_navigation'] = true;
		$config['single'] = false;
		$config['work_details'] = 'keyvalue';
		$config['grid_templates'] = array('template-projects-grid.php');
		$config['grid_templates_columns'] = array(
			'template-projects-grid.php' => array(
				'3' => '3',
				'4' => '4',
				'5' => '5'
			)
		);
		$config['grid_builder_columns'] = array(
			'3' => '3',
			'4' => '4',
			'5' => '5'
		);

		$config['builder_portfolio_layouts'] = array(
			'thb-desc-outside' => get_template_directory_uri() . '/css/i/thb-desc-outside.png',
			'thb-desc-inside'  => get_template_directory_uri() . '/css/i/thb-desc-inside.png'
		);

		return $config;
	}

	add_filter( 'thb_portfolio_config', 'thb_superba_portfolio_config' );
}

$thb_theme->loadModule( 'woocommerce', array(
	'skin'             => true,
	'sidebar_product'  => false,
	'hide_cart_option' => true
) );

/**
 * Theme style customization
 */
require_once dirname( __FILE__ ) . '/customization.php';