<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

$thb_customizer = thb_theme()->setCustomizer( new THB_Customizer() );

	// -------------------------------------------------------------------------
	// Font families
	// -------------------------------------------------------------------------

	$thb_global_families = $thb_customizer->addSection( 'families', __( 'Font families', 'thb_text_domain' ) );

	// -------------------------------------------------------------------------
	// Global
	// -------------------------------------------------------------------------

		$primary = '.thb-page-title, .thb-splash-title, .item.list .item-header h1, .widget .widgettitle, .author-block .author-block-wrapper > p a, .thb-related li .item-title h1, .comment .comment_rightcol .comment_head .user, .thb-details-container .thb-details-title, .thb-gallery-style-a .thb-gallery-data h3, .thb-gallery-item-details .thb-gallery-item-details-title, #thb-portfolio-container .thb-desc-outside.item .thb-block-type-element-data-wrapper h3, .thb-section-column-block-thb_portfolio .thb-desc-outside.item .thb-block-type-element-data-wrapper h3, .thb-section-column-block-thb_text_box .thb-section-block-header .thb-section-block-title, .thb-section-column-block-thb_image .thb-section-block-header .thb-section-block-title, .thb-section-column-block-thb_video .thb-section-block-header .thb-section-block-title, .thb-section-column-block-thb_blog .thb-section-block-header .thb-section-block-title, .thb-section-column-block-thb_list .thb-section-block-header .thb-section-block-title, .thb-section-column-block-thb_portfolio .thb-section-block-header .thb-section-block-title, .thb-section-column-block-thb_progress_bar .thb-section-block-header .thb-section-block-title, .thb-section-column-block-thb_photogallery .thb-section-block-header .thb-section-block-title, .thb-section-column-block-thb_page .thb-section-block-header .thb-section-block-title, .thb-section-column-block-thb_album.thb-desc-outside .thb-block-type-element-data-wrapper h3, .thb-related h3, #reply-title, #comments-title, .thb-project-footer-inner-wrapper > div > h3, #thb-portfolio-container .thb-desc-inside.item .thb-block-type-element-data-wrapper h3, .thb-section-column-block-thb_portfolio .thb-desc-inside.item .thb-block-type-element-data-wrapper h3, .thb-section-column-block-thb_album.thb-desc-inside .thb-block-type-element-data-wrapper h3, .thb-single-previous-nav-wrapper .thb-single-nav-title, .thb-single-next-nav-wrapper .thb-single-nav-title, .thb-curtain-logo-inner-wrapper .thb-curtain-logo .thb-logo, .thb-section-column-block-thb_counter .thb-counter-inner-wrapper .thb-counter-value-wrapper, .thb-section-column-block-thb_text_box .thb-section-block-header thb-section-block-title, .thb-section-column-block-thb_pricingtable .thb-pricingtable-type, .thb-section-column-block-thb_pricingtable .thb-pricingtable-price';
		$secondary = '.thb-page-subtitle, .thb-splash-subtitle, .thb-single-previous-nav-wrapper span, .thb-single-next-nav-wrapper span, .item.list .loop-post-meta, .item.list .item-header .thb-post-date, .author-block .author-block-wrapper > p span, .thb-related li .item-title p, .comment .comment_rightcol .comment_head .date, .thb-details-container .thb-details-description, .thb-gallery-counter-nav div, .thb-grid-gallery-filter, .thb-gallery-style-a .thb-gallery-data p, .thb-portfolio-filter, .thb-section-column-block-thb_pricingtable .thb-pricingtable-description, .thb-section-column-block-thb_counter .thb-counter-inner-wrapper .thb-counter-value-wrapper + .thb-counter-label-wrapper, .thb-section-column-block-thb_text_box .thb-section-block-header p, .thb-text blockquote, .comment_body blockquote, .thb-curtain-logo-inner-wrapper .thb-curtain-logo .thb-logo-tagline, .wp-caption .wp-caption-text, .comment .comment_rightcol .comment_head .comment-reply-link, .thb-project-footer-archive .thb-projects-archive li h3, .thb-section-column-block-thb_testimonial .thb-testimonial-wrapper .thb-testimonial-quote';

		if ( function_exists( 'is_woocommerce' ) && function_exists( 'thb_woocommerce_check' ) ) {
			$primary .= ', .woocommerce-page.single-product .thb-product-header .product_title, .widget_shopping_cart_content .total, .thb_mini_cart_wrapper .total, ul.cart_list li a, ul.product_list_widget li a, .woocommerce-page .cart-collaterals .cart_totals h2, .woocommerce .cart-collaterals .cart_totals h2, .woocommerce-page .thb-checkout-billing h3, .woocommerce-page .thb-checkout-shipping h3, .woocommerce-page #payment h3, .woocommerce .thb-checkout-billing h3, .woocommerce .thb-checkout-shipping h3, .woocommerce #payment h3, .woocommerce-page #order_review_heading, .woocommerce #order_review_heading, .woocommerce-page .cross-sells h2, .woocommerce .cross-sells h2, .woocommerce-page .woocommerce-tabs .panel h2, .woocommerce .woocommerce-tabs .panel h2, .woocommerce-page.woocommerce-account .thb-text .woocommerce h2, .woocommerce-page.woocommerce-account .thb-text .woocommerce h3, .woocommerce.woocommerce-account .thb-text .woocommerce h2, .woocommerce.woocommerce-account .thb-text .woocommerce h3, .woocommerce-page .products ul li.product .thb-product-description > a h3, .woocommerce-page ul.products li.product .thb-product-description > a h3, .woocommerce .products ul li.product .thb-product-description > a h3, .woocommerce ul.products li.product .thb-product-description > a h3, .woocommerce-page .upsells.products h2, .woocommerce-page .related.products h2, .woocommerce .upsells.products h2, .woocommerce .related.products h2, .woocommerce-page .price, .woocommerce .price, .woocommerce-page .onsale, .woocommerce-page .thb-out-of-stock, .woocommerce-page .out-of-stock, .woocommerce .onsale, .woocommerce .thb-out-of-stock, .woocommerce .out-of-stock';
			$secondary .= ', .woocommerce-page .woocommerce-result-count, .woocommerce .woocommerce-result-count, .woocommerce-page .products ul li.product .thb-product-description .posted_in, .woocommerce-page ul.products li.product .thb-product-description .posted_in, .woocommerce .products ul li.product .thb-product-description .posted_in, .woocommerce ul.products li.product .thb-product-description .posted_in';
		}

		$thb_global_families
			->addSetting( new THB_CustomizerFontSetting( 'global_primary', __( 'Primary', 'thb_text_domain' ) ) )
				->setDefault( 'Montserrat' )
				->setDefaultVariants( array( '700' ) )
				->addRule( 'font-family', $primary );

		$thb_global_families
			->addSetting( new THB_CustomizerFontSetting( 'global_secondary', __( 'Secondary', 'thb_text_domain' ) ) )
				->setDefault( 'Merriweather' )
				->setDefaultVariants( array( '300,300italic,400,italic' ) )
				->addRule( 'font-family', $secondary );

		$thb_global_families
			->addSetting( new THB_CustomizerFontSetting( 'global_text', __( 'Text', 'thb_text_domain' ) ) )
				->setDefault( 'Open+Sans' )
				->setDefaultVariants( array( '400,italic,700,700italic' ) )
				->addRule( 'font-family', 'body' );

	// ---------------------------------------------------------------------
	// Logo
	// ---------------------------------------------------------------------

	$thb_logo_panel = $thb_customizer->addPanel( 'logo', __( 'Logo', 'thb_text_domain' ) );

		$thb_logo = $thb_logo_panel->addSection( 'logo_appearance', __( 'Logo appearance', 'thb_text_domain' ) );

		$thb_logo
			->addSetting( new THB_CustomizerFontSetting( 'logo', __( 'Logo family', 'thb_text_domain' ) ) )
				->setDefault( 'Montserrat' )
				->setDefaultVariants( array( '700' ) )
				->addRule( 'font-family', '.thb-main-header-logo .thb-logo, .thb-curtain-logo-inner-wrapper .thb-curtain-logo .thb-logo' );

		$thb_logo
			->addSetting( new THB_CustomizerSelectSetting( 'logo_style', __( 'Style', 'thb_text_domain' ) ) )
				->setDefault( 'normal' )
				->setOptions( array(
					'normal' => __( 'Normal', 'thb_text_domain' ),
					'italic' => __( 'Italic', 'thb_text_domain' )
				) )
				->addRule( 'font-style', '.thb-main-header-logo .thb-logo, .thb-curtain-logo-inner-wrapper .thb-curtain-logo .thb-logo' );

		$thb_logo
			->addSetting( new THB_CustomizerSelectSetting( 'logo_case', __( 'Case', 'thb_text_domain' ) ) )
				->setDefault( 'none' )
				->setOptions( array(
					'none' => __( 'Regular', 'thb_text_domain' ),
					'uppercase' => __( 'Uppercase', 'thb_text_domain' ),
					'lowercase' => __( 'Lowercase', 'thb_text_domain' ),
					'capitalize' => __( 'Capitalize', 'thb_text_domain' ),
				) )
				->addRule( 'text-transform', '.thb-main-header-logo .thb-logo, .thb-curtain-logo-inner-wrapper .thb-curtain-logo .thb-logo' );

	// -------------------------------------------------------------------------
	// Tagline
	// -------------------------------------------------------------------------

		$thb_tagline = $thb_logo_panel->addSection( 'tagline_appearance', __( 'Tagline appearance', 'thb_text_domain' ) );

		$thb_tagline
			->addSetting( new THB_CustomizerFontSetting( 'tagline', __( 'Tagline family', 'thb_text_domain' ) ) )
				->setDefault( 'Merriweather' )
				->setDefaultVariants( array( '400' ) )
				->addRule( 'font-family', '.thb-main-header-logo .thb-logo-tagline, .thb-curtain-logo-inner-wrapper .thb-curtain-logo .thb-logo-tagline' );

		$thb_tagline
			->addSetting( new THB_CustomizerSelectSetting( 'tagline_style', __( 'Style', 'thb_text_domain' ) ) )
				->setDefault( 'italic' )
				->setOptions( array(
					'normal' => __( 'Normal', 'thb_text_domain' ),
					'italic' => __( 'Italic', 'thb_text_domain' )
				) )
				->addRule( 'font-style', '.thb-main-header-logo .thb-logo-tagline, .thb-curtain-logo-inner-wrapper .thb-curtain-logo .thb-logo-tagline' );

		$thb_tagline
			->addSetting( new THB_CustomizerSelectSetting( 'tagline_case', __( 'Case', 'thb_text_domain' ) ) )
				->setDefault( 'none' )
				->setOptions( array(
					'none' => __( 'Regular', 'thb_text_domain' ),
					'uppercase' => __( 'Uppercase', 'thb_text_domain' ),
					'lowercase' => __( 'Lowercase', 'thb_text_domain' ),
					'capitalize' => __( 'Capitalize', 'thb_text_domain' ),
				) )
				->addRule( 'text-transform', '.thb-main-header-logo .thb-logo-tagline, .thb-curtain-logo-inner-wrapper .thb-curtain-logo .thb-logo-tagline' );


	// -------------------------------------------------------------------------
	// Colors
	// -------------------------------------------------------------------------

	$thb_colors = $thb_customizer->addSection( 'colors', __( 'Colors', 'thb_text_domain' ) );

		$color = '.splash-call-to:hover, .main-navigation.inline .thb-desktop-navigation ul ul li a:hover, .main-navigation.vertical .thb-desktop-navigation ul li ul li a:hover, .main-navigation.vertical .thb-desktop-navigation ul li ul li a:active, a:hover, form [type="submit"]:hover, .thb-liked .thb-likes-count:before, .format-quote.masonry.item.list .post-wrapper .item-header a:hover, .author-block .author-block-wrapper > p a:hover, .thb-modal-skin-dark .thb-gallery-controls a:hover, .thb-modal-skin-dark .thb-gallery-duplicated-controls a:hover, .thb-modal-skin-dark .thb-gallery-counter-nav a:hover, .thb-grid-gallery-filter li.active span, .thb-gallery-style-a .thb-gallery-data p a:hover, #thb-gallery-load-more:hover, .thb-portfolio-filter li.active span, .thb-section-column-block-thb_divider .thb-go-top:hover, .thb-section-column-block-thb_page .thb-read-more:hover, .thb-section-column-block-thb_accordion .thb-toggle-trigger:hover, .thb-section-column-block-thb_accordion .thb-toggle-trigger:hover:before, .thb-tab-horizontal.thb-section-column-block-thb_tabs .thb-tabs-nav li.open a, .thb-tab-vertical.thb-section-column-block-thb_tabs .thb-tabs-nav li.open a, .thb-tab-vertical.thb-section-column-block-thb_tabs .thb-tabs-nav li.open a:after, .thb-tab-vertical.thb-section-column-block-thb_tabs .thb-tabs-nav li.open a:hover:after, .icon-style-a.thb-section-column-block-thb_text_box .thb-section-block-icon, .icon-style-b.thb-section-column-block-thb_text_box .thb-section-block-icon, .icon-style-e.thb-section-column-block-thb_text_box .thb-section-block-icon, .thb-section-column-block-thb_text_box .thb-section-block-call-to .action-primary:hover, .thb-section-column-block-thb_text_box .thb-section-block-call-to .action-secondary:hover, .thb-section-column-block-thb_pricingtable .thb-featured.thb-pricingtable-cell .thb-pricingtable-action a:hover, .thb-section-column-block-thb_pricingtable .thb-pricingtable-action a:hover, .owl-buttons div:hover';
		$background_color = '.thb-mobile-nav-trigger:hover .line, .comment.bypostauthor .comment_rightcol .comment_head:after, #nprogress .bar, .thb-section-column-block-thb_progress_bar.progress-style-b .thb-meter .thb-meter-bar-progress, .thb-section-column-block-thb_progress_bar.progress-style-a .thb-meter-bar-progress, .icon-style-c.thb-section-column-block-thb_text_box .thb-section-block-icon, .icon-style-d.thb-section-column-block-thb_text_box .thb-section-block-icon, .thb-section-column-block-thb_text_box .thb-section-block-call-to .action-primary, .thb-section-column-block-thb_pricingtable .thb-featured.thb-pricingtable-cell .thb-pricingtable-action a, .thb-section-column-block-thb_pricingtable .thb-pricingtable-featured';
		$border_color = '.thb-text a:hover, .comment_body a:hover, .item.list .loop-post-meta li.category a:hover, .thb-project-footer-archive .thb-projects-archive li a:hover, .splash-call-to:hover, body.thb-mobile-menu .main-navigation.inline .thb-desktop-navigation ul li a.open, .main-navigation.vertical .thb-desktop-navigation ul li a.open, .thb-mobile-navigation ul li a.open, form [type="submit"]:hover, .thb-grid-gallery-filter li.active span, #thb-gallery-load-more:hover, .thb-portfolio-filter li.active span, .thb-section-column-block-thb_page .thb-read-more:hover, .thb-tab-horizontal.thb-section-column-block-thb_tabs .thb-tabs-nav li.open a, .icon-style-c.thb-section-column-block-thb_text_box .thb-section-block-icon, .icon-style-d.thb-section-column-block-thb_text_box .thb-section-block-icon, .thb-section-column-block-thb_text_box .thb-section-block-call-to .action-primary, .thb-section-column-block-thb_text_box .thb-section-block-call-to .action-secondary:hover, .thb-section-column-block-thb_pricingtable .thb-featured.thb-pricingtable-cell .thb-pricingtable-wrapper, .thb-section-column-block-thb_pricingtable .thb-featured.thb-pricingtable-cell .thb-pricingtable-action a, .thb-section-column-block-thb_pricingtable .thb-pricingtable-action a:hover';

		$color .= ', #main-nav.inline .thb-desktop-navigation ul ul li a:hover, .thb-modal-skin-dark .thb-content-share ul li a:hover';
		$border_color .= ', .thb-skin-dark .thb-section-column-block-thb_text_box .thb-section-block-call-to .action-secondary:hover, .thb-skin-light .thb-skin-dark .thb-section-column-block-thb_text_box .thb-section-block-call-to .action-secondary:hover, .thb-skin-dark .thb-skin-light .splash-call-to:hover, .thb-skin-light .splash-call-to:hover, .thb-skin-dark .thb-skin-light .thb-section-column-block-thb_text_box .thb-section-block-call-to .action-secondary:hover, .thb-skin-light .thb-section-column-block-thb_text_box .thb-section-block-call-to .action-secondary:hover';
		$border_color .= ', .thb-skin-light .thb-skin-dark .thb-section-column-block-thb_pricingtable .thb-pricingtable-action a:hover, .thb-skin-dark .thb-section-column-block-thb_pricingtable .thb-pricingtable-action a:hover';

		if ( function_exists( 'is_woocommerce' ) && function_exists( 'thb_woocommerce_check' ) ) {
			$color .= ', .woocommerce-page.single-product .thb-product-header .woocommerce-breadcrumb a:hover, .thb_mini_cart_wrapper a:hover, .woocommerce-page .woocommerce-tabs .tabs li.active a, .woocommerce .woocommerce-tabs .tabs li.active a, .woocommerce-page .products ul li.product .thb-product-description > a h3:hover, .woocommerce-page ul.products li.product .thb-product-description > a h3:hover, .woocommerce .products ul li.product .thb-product-description > a h3:hover, .woocommerce ul.products li.product .thb-product-description > a h3:hover, .woocommerce-page .products ul li.product .thb-product-description .add_to_cart_button:hover, .woocommerce-page ul.products li.product .thb-product-description .add_to_cart_button:hover, .woocommerce .products ul li.product .thb-product-description .add_to_cart_button:hover, .woocommerce ul.products li.product .thb-product-description .add_to_cart_button:hover';
			$background_color .= ', .thb-product-numbers, .widget_shopping_cart_content .buttons .button:hover, .thb_mini_cart_wrapper .buttons .button:hover, .widget_shopping_cart_content .buttons .button.checkout:hover, .thb_mini_cart_wrapper .buttons .button.checkout:hover';
			$border_color .= ', .woocommerce-page .woocommerce-tabs .tabs li.active a, .woocommerce .woocommerce-tabs .tabs li.active a, .woocommerce-page .products ul li.product .thb-product-description .add_to_cart_button:hover, .woocommerce-page ul.products li.product .thb-product-description .add_to_cart_button:hover, .woocommerce .products ul li.product .thb-product-description .add_to_cart_button:hover, .woocommerce ul.products li.product .thb-product-description .add_to_cart_button:hover';
		}

		$thb_colors
			->addSetting( new THB_CustomizerColorSetting( 'highlight_color', __( 'Highlight color', 'thb_text_domain' ) ) )
				->setDefault( '#ec008c' )
				->addRule( 'color', $color )
				->addRule( 'border-color', $border_color )
				->addRule( 'border-top-color', '#thb-gallery-load-more.thb-ajax-loading:hover:after' )
				->addRule( 'border-left-color', '#thb-gallery-load-more.thb-ajax-loading:hover:after' )
				->addRule( 'background-color', '::-webkit-selection' )
				->addRule( 'background-color', '::-moz-selection' )
				->addRule( 'background-color', '::selection' )
				->addRule( 'background-color', $background_color );

		$thb_colors
			->addSetting( new THB_CustomizerColorSetting( 'header_panel_color', __( 'Header panel color', 'thb_text_domain' ) ) )
				->setDefault( '' )
				->addRule( 'background-color', '#thb-header:after' );