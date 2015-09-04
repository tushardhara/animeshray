<?php

/**
 * Load custom script for the WooCommerce customization
 */

thb_theme()->getFrontend()->addScript( get_template_directory_uri() . '/woocommerce/js/thb-theme-woocommerce.js' );

function thb_woocommerce_fonts() {
	if( thb_config( 'woocommerce', 'skin') ) {
		thb_theme()->getFrontend()->addStyle( THB_TEMPLATE_URL . '/woocommerce/css/woocommerce-fonts.css', array(
			'deps' => array(),
			'name' => 'thb_woocommerce_fonts'
		));
	}
}

add_action( 'thb_before_doctype', 'thb_woocommerce_fonts' );

if( !function_exists('thb_woocommerce_body_classes') ) {
	/**
	 * THB custom body classes
	 */
	function thb_woocommerce_body_classes( $classes ) {
		return $classes;
	}

	add_filter('body_class', 'thb_woocommerce_body_classes');
}

if ( ! function_exists( 'thb_woocommerce_page_ID' ) ) {
	/**
	 * Register the shop page as a valid THB page ID.
	 *
	 * @param integer $page_id
	 * @return integer
	 */
	function thb_woocommerce_page_ID( $page_id ) {
		if ( is_shop() ) {
			$page_id = wc_get_page_id( 'shop' );
		}

		return $page_id;
	}

	add_filter( 'thb_get_page_ID', 'thb_woocommerce_page_ID' );
}

if ( ! function_exists( 'thb_woocommerce_page_template' ) ) {
	/**
	 * Register the WooCommerce page templates.
	 *
	 * @param string $template
	 * @return string
	 */
	function thb_woocommerce_page_template( $template ) {
		$page_id = 0;

		if ( is_admin() ) {
			$page_id = thb_input_get( 'post', 'absint', 0 );
		}
		else {
			$page_id = thb_get_page_ID();
		}

		if ( $page_id == wc_get_page_id( 'shop' ) ) {
			$template = 'shop';
		}

		return $template;
	}

	add_filter( 'thb_get_page_template', 'thb_woocommerce_page_template' );
}

if ( ! function_exists( 'thb_woocommerce_deregister_archive' ) ) {
	function thb_woocommerce_deregister_archive( $is_archive ) {
		if ( is_shop() ) {
			$is_archive = false;
		}

		return $is_archive;
	}

	add_filter( 'thb_is_archive', 'thb_woocommerce_deregister_archive', 999 );
}

/**
 * Change the before and after WooCommerce hooks
 * -----------------------------------------------------------------------------
 */

if( !function_exists('thb_woocommerce_page_header') ) {
	function thb_woocommerce_page_header( $params ) {
		if ( is_shop() || is_tax( array( 'product_cat', 'product_tag' ) ) ) {
			$params['thb_title'] = thb_woo_get_page_title();
		}

		if ( is_tax( array( 'product_cat' ) ) ) {
			$params['thb_subtitle'] = __( 'Category', 'thb_text_domain' );
		}

		if ( is_tax( array( 'product_tag' ) ) ) {
			$params['thb_subtitle'] = __( 'Tag', 'thb_text_domain' );
		}

		if ( is_product() ) {
			add_filter( 'thb_pageheader_disable', '__return_true' );
			$params['show_featured_image'] = false;
		}

		return $params;
	}

	add_filter( 'thb_page_header', 'thb_woocommerce_page_header' );
}

if( !function_exists('thb_woocommerce_theme_before_content') ) {
	function thb_woocommerce_theme_before_content() { ?>
		<?php thb_page_before(); ?>
			<div class="thb-content-section">
				<?php thb_page_start(); ?>
					<div class="thb-content-section-inner-wrapper">
						<div id="thb-main-content" class="thb-page-section thb-page-content-wrapper">
	<?php }
}

if( !function_exists('thb_woocommerce_theme_after_content') ) {
	function thb_woocommerce_theme_after_content() { ?>
						</div><!-- /#thb-main-content -->
					</div><!-- /.thb-content-section-inner-wrapper -->
					<?php
						if ( is_shop() || is_tax() ) {
							thb_page_sidebar();
						}
					?>
				<?php thb_page_end(); ?>
			</div><!-- /.thb-content-section -->
		<?php thb_page_after(); ?>
	<?php }
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_filter( 'woocommerce_before_main_content', 'thb_woocommerce_theme_before_content', 10 );
add_filter( 'woocommerce_after_main_content', 'thb_woocommerce_theme_after_content', 20 );

/**
 * Remove the Shop default page title in the page content
 * -----------------------------------------------------------------------------
 */
add_filter('woocommerce_show_page_title', '__return_false', 99);

/**
 * Shop loop product wrapping
 * -----------------------------------------------------------------------------
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
// remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

if( !function_exists('thb_loop_product_start') ) {
	function thb_loop_product_start() {
		global $product;

		if ( $product->is_in_stock() ) {
			woocommerce_show_product_loop_sale_flash();
		}
		echo "<div class='thb-product-image-wrapper item-thumb'>";
			if ( ! $product->is_in_stock() ) {
				echo "<span class='thb-out-of-stock'>";
					_e('Out of stock', 'woocommerce');
				echo "</span>";
			}

			echo "<a href='". get_permalink() ."'>";
				echo "<span class='thb-product-overlay'></span>";
				woocommerce_template_loop_product_thumbnail();
			echo "</a>";
		echo "</div>";
		echo "<div class='thb-product-description'>";
	}

	add_action( 'woocommerce_before_shop_loop_item', 'thb_loop_product_start', 999 );
}
if( !function_exists('thb_loop_product_end') ) {
	function thb_loop_product_end() {
			global $post, $product;
			$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
			echo $product->get_categories( ', ', '<span class="posted_in">' . _n( '', '', $size, 'woocommerce' ) . ' ', '</span>' );

			woocommerce_template_loop_rating();

			echo '<div class="thb-add-to-cart-wrapper">';
				woocommerce_template_loop_price();
			echo "</div>";

			woocommerce_template_loop_add_to_cart();
		echo "</div>";
	}

	add_action( 'woocommerce_after_shop_loop_item', 'thb_loop_product_end', 999 );
}

/**
 * Cart
 * -----------------------------------------------------------------------------
 */

if( !function_exists('thb_woocommerce_cross_sells_columns_number') ) {
	function thb_woocommerce_cross_sells_columns_number() {
		return 3;
	}

	add_filter( 'woocommerce_cross_sells_columns', 'thb_woocommerce_cross_sells_columns_number' );
}

/**
 * Single product
 * -----------------------------------------------------------------------------
 */

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_product_tabs', 'woocommerce_product_description_tab', 10 );
remove_action( 'woocommerce_product_tab_panels', 'woocommerce_product_description_panel', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product_summary', 'thb_woocommerce_output_related_products', 20 );
add_action( 'woocommerce_before_single_product_summary', 'thb_woocommerce_before_single_product_summary', 10 );

if( !function_exists('thb_woocommerce_before_single_product_summary') ) {
	function thb_woocommerce_before_single_product_summary() {
		?>
		<div class="thb-product-header mobile">
			<?php
				thb_pagination();
				woocommerce_breadcrumb();
				woocommerce_template_single_title();
				woocommerce_template_loop_rating();
				woocommerce_template_single_price();
			?>
		</div>
		<?php
	}
}


if( !function_exists('thb_single_product_summary') ) {
	function thb_single_product_summary() {
		?>
		<div class="thb-product-header">
			<?php
				thb_pagination();
				woocommerce_breadcrumb();
				woocommerce_template_single_title();
				woocommerce_template_loop_rating();
				woocommerce_template_single_price();
			?>
		</div>
		<div class="thb-product-description">
			<?php
				woocommerce_template_single_excerpt();
				woocommerce_template_single_add_to_cart();
			?>
		</div>
		<?php
	}

	add_action('woocommerce_single_product_summary', 'thb_single_product_summary');
}

/**
 * Cart
 * -----------------------------------------------------------------------------
 */

if( !function_exists('thb_mini_cart_fragments') ) {
	function thb_mini_cart_fragments( $fragments ) {
		global $woocommerce;

		$cart_class = '';
		if( sizeof($woocommerce->cart->cart_contents) > 0 ) {
			$cart_class = 'minicart-full';
		}

		$fragments['.thb-product-numbers'] = "<span class='thb-product-numbers " . $cart_class . "'>" . $woocommerce->cart->cart_contents_count . "</span>";

		return $fragments;
	}

	add_filter('add_to_cart_fragments', 'thb_mini_cart_fragments');
}

if( !function_exists('thb_woo_cart') ) {
	function thb_woo_cart() {
		global $woocommerce, $cart_class;

		echo "<div class='thb-mini-cart-icon-wrapper'>";
			echo "<div class='thb-mini-cart-icon ". $cart_class ."'>";
				echo "<a href='" . $woocommerce->cart->get_cart_url() . "' class='thb-cart-trigger'><span class='thb-product-numbers'>" . $woocommerce->cart->cart_contents_count . "</span>" . __( 'Cart', 'thb_text_domain' ) . "</a>";
				echo "<div class='thb_mini_cart_wrapper'>";
					echo "<div class='widget_shopping_cart_content'>";
						woocommerce_mini_cart();
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	}
}

if( !function_exists('thb_woo_cart_inline') ) {
	function thb_woo_cart_inline() {
		global $woocommerce, $cart_class;

		echo "<div class='thb-cart-inline ". $cart_class ."'>";
			echo "<a href='" . $woocommerce->cart->get_cart_url() . "'>" . __( 'Cart', 'thb_text_domain' ) . "<span class='thb-product-numbers'>" . $woocommerce->cart->cart_contents_count . "</span></a>";
		echo "</div>";
	}
}

if( !function_exists('thb_woo_cart_actions') ) {
	function thb_woo_cart_actions() {
		if ( thb_get_option( 'hide_cart' ) ) {
			return false;
		}

		add_action( 'thb_cart_hook', 'thb_woo_cart' );

		if ( thb_is_theme_layout_a() ) {
			add_action( 'thb_nav_end', 'thb_woo_cart' );
		}
		elseif ( thb_is_theme_layout_b() || thb_is_theme_layout_d() ) {
			add_action( 'thb_nav_end', 'thb_woo_cart_inline' );
		}
		elseif ( thb_is_theme_layout_c() ) {
			add_action( 'thb_nav_start', 'thb_woo_cart' );
		}
	}

	add_action( 'wp_head', 'thb_woo_cart_actions' );
}

if( ! function_exists('thb_woo_cart_content') ) {
	function thb_woo_cart_content( $classes ) {
		global $woocommerce;

		if( sizeof( $woocommerce->cart->get_cart() ) == 0 ) {
			$classes[] = 'thb-woocommerce-cartempty';
		}

		return $classes;
	}

	add_filter('body_class', 'thb_woo_cart_content');
}

remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 10 );