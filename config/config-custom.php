<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

/**
 * Theme customizations.
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

if( !function_exists('thb_builder_hook') ) { function thb_builder_hook() { do_action('thb_builder_hook'); } }
if( !function_exists('thb_cart_hook') ) { function thb_cart_hook() { do_action('thb_cart_hook'); } }
if( !function_exists('thb_slideshow_fullscreen_hook') ) { function thb_slideshow_fullscreen_hook() { do_action('thb_slideshow_fullscreen_hook'); } }

if( ! function_exists('thb_comment_form_fields') ) {
	/**
	 * Customizations for the form
	 */
	function thb_comment_form_fields( $fields ) {
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$args = array(
			'format' => 'xhtml'
		);
		$html5 = 'html5' === $args['format'];
		$args = wp_parse_args( $args );

		if ( ! isset( $args['format'] ) )
			$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

		$fields['author'] = '<p class="comment-form-author">' . '<label for="author">' . __( 'Name','thb_text_domain' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' . '<input id="author" name="author" type="text" placeholder="' . __('Your name *', 'thb_text_domain') . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>';
		$fields['email'] = '<p class="comment-form-email"><label for="email">' . __( 'Email','thb_text_domain' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
						'<input id="email" name="email" placeholder="' . __('Your email *','thb_text_domain') . '" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';
		$fields['url'] = '<p class="comment-form-url"><label for="url">' . __( 'Website','thb_text_domain' ) . '</label> ' .
						'<input id="url" name="url" placeholder="' . __('Your website url', 'thb_text_domain') . '" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';

		return $fields;
	}

	add_filter('comment_form_default_fields','thb_comment_form_fields');
}

if( !function_exists('thb_password_form') ) {
	/**
	 * THB custom password protection form
	 */
	function thb_password_form() {
		 global $post;
	    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	    $o = '<p class="thb-password-protected-message">' . __( "This content is password protected", 'thb_text_domain') . '<span>' . __("to view it please enter your password below", 'thb_text_domain') . '</span></p>
	    <form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
			<label class="hidden" for="' . $label . '">' . __( "Password:",'thb_text_domain' ) . ' </label>
			<input name="post_password" placeholder="Password" id="' . $label . '" type="password" size="20" maxlength="20" />
			<input id="submit" type="submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" />
		</form>
	    ';
	    return $o;
	}
	add_filter( 'the_password_form', 'thb_password_form' );
}

if( !function_exists('thb_title_format') ) {
	/**
	 * Change the title for the protected content
	 */
	function thb_title_format($content) {
		return '%s';
	}

	add_filter('private_title_format', 'thb_title_format');
	add_filter('protected_title_format', 'thb_title_format');
}

if( !function_exists('thb_theme_body_classes') ) {
	/**
	 * THB custom body classes
	 */
	function thb_theme_body_classes( $classes ) {
		$thb_id = thb_get_page_ID();
		$header_inner_bg = get_theme_mod( 'header_panel_color' );

		$classes[] = thb_get_theme_layout();

		if ( thb_get_option( 'disable_contextmenu' ) == '1' ) {
			$classes[] = 'thb-disable-contextmenu';
		}

		if ( thb_is_enable_theme_animations() ) {
			$classes[] = 'thb-theme-animations-enabled';
		}

		if ( ! thb_is_preloader_disabled() ) {
			$classes[] = 'thb-preloader-enabled';
		}

		if ( thb_is_gallery_modal_disabled() ) {
			$classes[] = 'thb-gallery-modal-disabled';
		}

		if ( ! empty( $header_inner_bg ) ) {
			$classes[] = 'thb-header-inner-filled';
		}

		if ( thb_is_slideshow_fullscreen() ) {
			$classes[] = 'thb-slideshow-fullscreen';
		}

		if ( thb_is_page_template( 'template-splash.php' ) ) {
			$classes[] = thb_get_splash_subtitle_position();
			$classes[] = thb_get_splash_page_alignment();
		}

		if ( thb_get_theme_templates( 'gallery' ) || thb_is_page_template( 'single-works.php' ) ) {
			$classes[] = 'thb-' . thb_get_gallery_modal_skin();

			if ( thb_is_gallery_modal_details_opened() ) {
				$classes[] = 'thb-is-gallery-modal-details-opened';
			}

			if ( thb_is_gallery_modal_without_margins() ) {
				$classes[] = 'thb-is-gallery-without-margins';
			}
		}

		if ( thb_is_page_template( 'template-carousel-gallery.php' ) ) {
			if ( thb_is_carousel_highlight_active() ) {
				$classes[] = "thb-carousel-highlight-active";
			}
		}

		if ( empty( $thb_id ) ) {
			return $classes;
		}

		$classes[] = thb_get_page_width();
		$classes[] = thb_get_page_header_alignment();

		return $classes;
	}

	add_filter('body_class', 'thb_theme_body_classes');
}

if( ! function_exists('thb_theme_layout_options') ) {
	/**
	 * Page extra layout features
	 */
	function thb_theme_layout_options() {
		foreach( thb_theme()->getPublicPostTypes() as $post_type ) {
			if ( ! $thb_metabox = $post_type->getMetabox('layout') ) {
				return;
			}

			$all_templates = thb_get_theme_templates();

			$thb_container = $thb_metabox->getContainer( 'layout_container' );

			if( thb_is_admin_template( $all_templates ) ) {
				$thb_field = new THB_SelectField( 'superba_page_header_alignment' );
					$thb_field->setLabel( __( 'Page header alignment', 'thb_text_domain' ) );
					$thb_field->setOptions(array(
						'pageheader-alignment-left'   => __('Left', 'thb_text_domain'),
						'pageheader-alignment-center' => __('Center', 'thb_text_domain'),
						'pageheader-alignment-right'  => __('Right', 'thb_text_domain')
					));
				$thb_container->addField($thb_field);

				$thb_field = new THB_SelectField( 'superba_subtitle_position' );
					$thb_field->setLabel( __( 'Page subtitle position', 'thb_text_domain' ) );
					$thb_field->setOptions(array(
						'subtitle-bottom' => __('Bottom', 'thb_text_domain'),
						'subtitle-top' => __('Top', 'thb_text_domain')
					));
				$thb_container->addField($thb_field);
			}

			if( thb_is_admin_template( 'default' ) || thb_is_admin_template( 'template-blank.php' ) ) {

				$thb_field = new THB_SelectField( 'superba_page_width' );
					$thb_field->setLabel( __( 'Page width', 'thb_text_domain' ) );
					$thb_field->setOptions(array(
						'thb-page-width-large' => __('Large', 'thb_text_domain'),
						'thb-page-width-small' => __('Small', 'thb_text_domain')
					));
				$thb_container->addField($thb_field);

			}

			if( thb_is_admin_template( thb_get_theme_templates( 'gallery' ) ) ) {

				$thb_field = new THB_CheckboxField('gallery_disable_featured_image');
				$thb_field->setLabel( __('Disable page featured image', 'thb_text_domain') );
				$thb_field->setHelp( __('Check if you want to disable the featured image inside the page.', 'thb_text_domain') );
				$thb_container->addField($thb_field);

			}

			if( thb_is_admin_template( thb_get_theme_templates( 'gallery' ) ) || thb_is_admin_template( 'single-works.php' ) ) {

				$thb_field = new THB_SelectField( 'gallery_modal_skin' );
					$thb_field->setLabel( __( 'Choose the modal skin', 'thb_text_domain' ) );
					$thb_field->setOptions(array(
						'modal-skin-light' => __('Light', 'thb_text_domain'),
						'modal-skin-dark'  => __('Dark', 'thb_text_domain')
					));
				$thb_container->addField($thb_field);

				$thb_field = new THB_CheckboxField( 'gallery_modal_details_auto_open' );
					$thb_field->setLabel( __( 'Details panel expanded', 'thb_text_domain' ) );
					$thb_field->setHelp( __('Check if you want to open the gallery modal with the details panel already expanded.', 'thb_text_domain') );
				$thb_container->addField($thb_field);

				$thb_field = new THB_CheckboxField( 'gallery_modal_disable_margins' );
					$thb_field->setLabel( __( 'Disable margins on modal', 'thb_text_domain' ) );
					$thb_field->setHelp( __('Check if you want to disable the margins around images on modal view.', 'thb_text_domain') );
				$thb_container->addField($thb_field);

				$thb_field = new THB_CheckboxField( 'gallery_modal_disable' );
					$thb_field->setLabel( __( 'Disable gallery modal', 'thb_text_domain' ) );
					$thb_field->setHelp( __('Check this if you don\'t want the gallery lightbox modal to open when clicking on album images.', 'thb_text_domain') );
				$thb_container->addField($thb_field);

			}

			if( thb_is_admin_template( 'template-splash.php' ) ) {

				// $thb_tab = $thb_metabox->createTab( 'Logo' )

				$thb_container->setTitle( __( 'Logo', 'thb_text_domain' ) );

				$thb_field = new THB_UploadField('splash_logo');
				$thb_field->setLabel( __('Splash Logo', 'thb_text_domain') );
				$thb_field->setHelp( __('Upload an image to be used as a splash logo for your page. If this field is left empty, a simple text logo will be used. Please remember to load a properly dimensioned logo.', 'thb_text_domain') );
				$thb_container->addField($thb_field);

				$thb_field = new THB_UploadField('splash_logo_retina');
					$thb_field->setLabel( __('Retina logo', 'thb_text_domain') );
					$thb_field->setHelp( __('Upload an image to be used as a splash logo for your page for high definition screens. Please remember to load a properly dimensioned logo (usually you can double the size of the regular logo).', 'thb_text_domain') );
				$thb_container->addField($thb_field);

				$thb_field = new THB_TextField('splash_logo_url');
					$thb_field->setLabel( __('Splash logo URL', 'thb_text_domain') );
					$thb_field->setHelp( __('You can use a manual URL http:// or a post or page ID.', 'thb_text_domain'));
				$thb_container->addField($thb_field);

				$thb_container = $thb_metabox->createContainer( __( 'Headings', 'thb_text_domain' ), 'splash_headings_container' );

				$thb_field = new THB_TextField('splash_title');
				$thb_field->setLabel( __('Main heading', 'thb_text_domain') );
				$thb_container->addField($thb_field);

				$thb_field = new THB_TextField('splash_subtitle');
				$thb_field->setLabel( __('Sub heading', 'thb_text_domain') );
				$thb_container->addField($thb_field);

				$thb_field = new THB_SelectField( 'splash_subtitle_position' );
					$thb_field->setLabel( __( 'Sub heading position', 'thb_text_domain' ) );
					$thb_field->setOptions(array(
						'thb-splash-subtitle-bottom' => __('Bottom', 'thb_text_domain'),
						'thb-splash-subtitle-top' => __('Top', 'thb_text_domain')
					));
				$thb_container->addField($thb_field);

				$thb_field = new THB_SelectField( 'splash_page_alignment' );
					$thb_field->setLabel( __( 'Heading alignment', 'thb_text_domain' ) );
					$thb_field->setOptions(array(
						'thb-splash-align-left' => __('Left', 'thb_text_domain'),
						'thb-splash-align-center' => __('Center', 'thb_text_domain'),
						'thb-splash-align-right' => __('Right', 'thb_text_domain')
					));
				$thb_container->addField($thb_field);

				$thb_container = $thb_metabox->createContainer( __( 'Call to action', 'thb_text_domain' ), 'splash_callto_container' );

				$thb_field = new THB_TextField('splash_action_label');
					$thb_field->setLabel( __('Call to action label', 'thb_text_domain') );
					$thb_field->setHelp( __('Call to action button label. If left empty the call to action button will not be shown.', 'thb_text_domain') );
				$thb_container->addField($thb_field);

				$thb_field = new THB_TextField('splash_action_url');
					$thb_field->setLabel( __('Call to action URL', 'thb_text_domain') );
					$thb_field->setHelp( __('The call to action button URL. You can use a manual URL http:// or a post or page ID.', 'thb_text_domain'));
				$thb_container->addField($thb_field);

				$thb_container = $thb_metabox->createContainer( __( 'Social links', 'thb_text_domain' ), 'splash_social_container' );

					$thb_field = new THB_MultipleSelectField('social_networks');
						$thb_field->setLabel( __('Social networks', 'thb_text_domain') );
						$thb_field->setHelp( __('Social networks to be displayed in the page bottom.', 'thb_text_domain') );
						$thb_field->setOptions( thb_get_theme_social_options() );
					$thb_container->addField($thb_field);

				$thb_container = $thb_metabox->createContainer( __( 'Overlay', 'thb_text_domain' ), 'splash_overlay_container' );

					$thb_field = new THB_ColorField('splash_overlay_color');
						$thb_field->setLabel( __('Color', 'thb_text_domain') );
					$thb_container->addField($thb_field);

					$thb_field = new THB_NumberField('splash_overlay_opacity');
						$thb_field->setLabel( __('Opacity', 'thb_text_domain') );
						$thb_field->setMin(0);
						$thb_field->setMax(1);
						$thb_field->setStep(0.05);
					$thb_container->addField($thb_field);
			}

		}

		if( thb_is_admin_template( thb_get_theme_templates( 'gallery' ) ) ) {
			$thb_metabox = thb_theme()->getPostType( 'page' )->getMetabox( 'thb_builder' );
			$thb_container = $thb_metabox->createContainer( '', 'thb_builder_gallery_config', 0 );

			$thb_field = new THB_SelectField( 'builder_position_gallery_pages' );
				$thb_field->setLabel( __( 'Position', 'thb_text_domain' ) );
				$thb_field->setOptions( array(
					'top' => __( 'Above the gallery', 'thb_text_domain' ),
					'bottom' => __( 'Below the gallery', 'thb_text_domain' ),
				) );
			$thb_container->addField( $thb_field );
		}
	}

	add_action('wp_loaded', 'thb_theme_layout_options');
}

if( ! function_exists( 'thb_theme_portfolio_options' ) ) {
	/**
	 * Theme portfolio options.
	 */
	function thb_theme_portfolio_options() {

		if( thb_is_admin_template( 'template-projects-grid.php' ) ) {

			$thb_metabox = thb_theme()->getPostType( 'page' )->getMetabox( 'layout' );
			$thb_tab = $thb_metabox->getTab( 'portfolio_options' );
			$thb_container = $thb_tab->getContainer( 'portfolio_loop_container' );

			$thb_field = new THB_GraphicRadioField( 'superba_portfolio_styles' );
				$thb_field->setLabel( __( 'Item style', 'thb_text_domain' ) );
				$thb_field->setOptions(array(
					'thb-desc-outside' => get_template_directory_uri() . '/css/i/thb-desc-outside.png',
					'thb-desc-inside'  => get_template_directory_uri() . '/css/i/thb-desc-inside.png'
				));
			$thb_container->addField($thb_field);
		}

		if( thb_is_admin_template( 'single-works.php' ) ) {

			$thb_metabox = thb_theme()->getPostType( 'works' )->getMetabox( 'layout' );
			$thb_tab = $thb_metabox->getTab( 'extra' );
			$thb_container = $thb_tab->getContainer( 'data_details' );

				$thb_field = new THB_TextField( 'project_short_description' );
					$thb_field->setLabel( __('Project short description', 'thb_text_domain') );
					$thb_field->setHelp( __('You can place here a short description or the tagline for your project.', 'thb_text_domain') );
				$thb_container->addField($thb_field);

			$thb_container = $thb_tab->createContainer( __( 'Pictures appearance', 'thb_text_domain' ), 'pictures_appearance', 1 );

				$thb_field = new THB_SelectField( 'superba_single_work_display' );
					$thb_field->setLabel( __( 'Media display', 'thb_text_domain') );
					$thb_field->setHelp( __( 'Mosaic display will not work if when having both pictures and videos.', 'thb_text_domain' ) );
					$thb_field->setOptions( array(
						''          => __( 'Regular', 'thb_text_domain' ),
						'mosaic'    => __( 'Mosaic', 'thb_text_domain' ),
					) );
				$thb_container->addField($thb_field);

				$thb_field = new THB_TextField( 'superba_single_work_mosaic_module' );
				$thb_field->setLabel( __( 'Mosaic module', 'thb_text_domain' ) );
				$thb_field->setHelp( __( 'E.g. 231 will produce three rows, the 1st with two images, the 2nd with three, etc.', 'thb_text_domain' ) );
				$thb_container->addField( $thb_field );

				$thb_field = new THB_NumberField( 'superba_single_work_mosaic_gutter' );
				$thb_field->setLabel( __( 'Mosaic gutter', 'thb_text_domain' ) );
				$thb_field->setHelp( __( 'Space between images, in pixels.', 'thb_text_domain' ) );
				$thb_field->setMin( 0 );
				$thb_container->addField( $thb_field );

				$thb_field = new THB_SelectField( 'superba_single_work_mosaic_image_size' );
				$thb_field->setLabel( __( 'Mosaic image size', 'thb_text_domain' ) );
				$thb_field->setOptions( array(
					'large'     => __( 'Large', 'thb_text_domain' ),
					'medium'    => __( 'Medium', 'thb_text_domain' ),
					'thumbnail' => __( 'Small', 'thb_text_domain' ),
					'full'      => __( 'Full', 'thb_text_domain' ),
				) );
				$thb_container->addField( $thb_field );

		}
	}

	if ( function_exists( 'thb_portfolio_loop' ) ) {
		add_action( 'wp_loaded', 'thb_theme_portfolio_options' );
	}
}

if( !function_exists('thb_builder_load') ) {
	/**
	 * Attach the builder functionality to every page_end hook
	 */
	function thb_builder_load() {
		add_action( 'thb_builder_hook', 'thb_builder' );
	}

	add_action( 'thb_before_doctype', 'thb_builder_load' );
}

if( !function_exists('thb_single_next_custom_pagination') ) {
	/**
	 * Display a custom pagination in the single post
	 */
	function thb_single_next_custom_pagination() {
		$post = get_next_post();

		if ( $post == '' ) {
			return;
		}

		echo "<div class='thb-single-next-nav-wrapper'>";
			echo "<a href='" . get_permalink( $post->ID ) . "'>";
				echo "<span>" . __( 'Next post', 'thb_text_domain' ) . "</span>";
				echo "<p class='thb-single-nav-title'>" . thb_text_format( esc_html( $post->post_title ) ) . "</p>";
			echo "</a>";
		echo "</div>";
	}
}

if( !function_exists('thb_single_prev_custom_pagination') ) {
	/**
	 * Display a custom pagination in the single post
	 */
	function thb_single_prev_custom_pagination() {
		$post = get_previous_post();

		if ( $post == '' ) {
			return;
		}

		echo "<div class='thb-single-previous-nav-wrapper'>";
			echo "<a href='" . get_permalink( $post->ID ) . "'>";
				echo "<span>" . __( 'Previous post', 'thb_text_domain' ) . "</span>";
				echo "<p class='thb-single-nav-title'>" . thb_text_format( esc_html( $post->post_title ) ) . "</p>";
			echo "</a>";
		echo "</div>";
	}
}

if ( ! function_exists( 'thb_superba_gallery_details' ) ) {
	function thb_superba_gallery_details() {
		thb_get_template_part( 'partials/gallery-details' );
		thb_get_template_part( 'partials/gallery-item' );
	}

	add_action( 'wp_footer', 'thb_superba_gallery_details' );
}

if ( ! function_exists( 'thb_superba_localize_gallery_items' ) ) {
	function thb_superba_localize_gallery_items() {
		$gallery_templates = array(
			'template-grid-gallery.php',
			'template-carousel-gallery.php',
			'template-slideshow-gallery.php',
			'template-mosaic-gallery.php',
		);

		wp_localize_script( 'jquery', 'gallery_translation', array(
			'close'         => __( 'Close', 'thb_text_domain' ),
			'fullscreen'    => __( 'Full screen', 'thb_text_domain' ),
			'details'       => __( 'Details', 'thb_text_domain' ),
			'details_close' => __( 'Close details', 'thb_text_domain' ),
		) );

		if ( thb_is_page_template( $gallery_templates ) ) {
			$image_size = 'full';

			if ( thb_is_page_template( 'template-grid-gallery.php' ) ) {
				$thb_grid_columns = thb_get_grid_columns();
				$thb_grid_images_height = thb_get_grid_images_height();
				$image_size = thb_get_grid_image_size( $thb_grid_columns, $thb_grid_images_height );
			}
			elseif ( thb_is_page_template( 'template-slideshow-gallery.php' ) ) {
				$image_size = 'large';
			}
			elseif ( thb_is_page_template( 'template-carousel-gallery.php' ) ) {
				$image_size = 'carousel';

				$carousel_starts_from = thb_get_post_meta( thb_get_page_ID(), 'carousel_starts_from' );
				$carousel_alignment = thb_get_post_meta( thb_get_page_ID(), 'carousel_alignment' );

				if ( $carousel_starts_from === false || $carousel_starts_from === '' ) {
					$carousel_starts_from = 1;
				}

				if ( $carousel_alignment === false || $carousel_alignment === '' ) {
					$carousel_alignment = 'center';
				}

				wp_localize_script( 'jquery', 'thb_carousel_options', array(
					'carousel_starts_from' => (int) $carousel_starts_from,
					'carousel_alignment' => $carousel_alignment
				) );
			}

			wp_localize_script( 'jquery', 'gallery_items', thb_superba_get_gallery_items( thb_get_page_ID(), $image_size ) );
		}
		elseif( thb_is_page_template( 'single-works.php' ) ) {
			$display = thb_get_post_meta( thb_get_page_ID(), 'superba_single_work_display' );
			$image_size = 'large';

			if ( $display == 'mosaic' ) {
				$image_size = thb_get_post_meta( thb_get_page_ID(), 'superba_single_work_mosaic_image_size' );
			}

			wp_localize_script( 'jquery', 'gallery_items', thb_get_single_works_slides( thb_get_page_ID(), $image_size ) );
		}

		if ( thb_is_page_template( 'template-grid-gallery.php' ) ) {
			$thb_gallery_pace = (int) thb_get_post_meta( thb_get_page_ID(), 'gallery_pace' );

			if ( $thb_gallery_pace > 0 ) {
				wp_localize_script( 'jquery', 'gallery_pace', array(
					'pace'         => (int) $thb_gallery_pace,
					'current_page' => 0
				) );
			}
		}

		if ( thb_is_page_template( 'template-slideshow-gallery.php' ) ) {
			$effect = thb_get_post_meta( thb_get_page_ID(), 'slideshow_effect' );

			wp_localize_script( 'jquery', 'thb_slideshow', array(
				'effect'         => ! empty( $effect ) ? $effect : 'move'
			) );
		}
	}

	function thb_superba_localize_gallery_items_hook() {
		add_action( 'wp_enqueue_scripts', 'thb_superba_localize_gallery_items' );
	}

	add_action( 'thb_before_doctype', 'thb_superba_localize_gallery_items_hook' );

}

if ( ! function_exists( 'thb_disable_blocks' ) ) {
	function thb_disable_blocks() {
		if ( function_exists( 'thb_builder_instance' ) ) {
			thb_builder_instance()->getBlock( 'thb_radial_chart' )->deactivate();
			thb_builder_instance()->getBlock( 'thb_google_map' )->deactivate();
			// thb_builder_instance()->getBlock( 'thb_photogallery' )->deactivate();
		}
	}

	add_action( 'wp_loaded', 'thb_disable_blocks' );
}

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 */
function thb_superba_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'thb_text_domain' ), max( $paged, $page ) );
	}

	return $title;
}

add_filter( 'wp_title', 'thb_superba_wp_title', 10, 2 );

if( !function_exists('thb_disable_layout_default_options_splash_page') ) {
	/**
	 * Disable the subtitle and the page header disable options for the Splash page template
	 */
	function thb_disable_layout_default_options_splash_page() {
		if ( thb_get_admin_template() == 'template-splash.php' ) {
			$fields_container = thb_theme()->getPostType( 'page' )->getMetabox( 'layout' )->getContainer( 'layout_container' );
			$fields_container->removeField('subtitle');
			$fields_container->removeField('pageheader_disable');
		}
	}

	// add_filter( 'wp_loaded', 'thb_disable_layout_default_options_splash_page' );
}

if( !function_exists('thb_remove_blog_grid_options') ) {
	/**
	 * Remove a blog grid page template specific option
	 */
	function thb_remove_blog_grid_options() {
		if ( thb_get_admin_template() == 'template-blog-grid.php' ) {
			$fields_container = thb_theme()->getPostType( 'page' )->getMetabox( 'layout' )->getTab( 'blog_loop' )->getContainer( 'loop_container' );
			$fields_container->removeField( 'thumbnails_open_post' );
		}
	}

	add_filter( 'wp_loaded', 'thb_remove_blog_grid_options', 20 );
}

if( !function_exists('thb_curtain') ) {
	function thb_curtain() {
		thb_get_template_part( 'partials/partial-curtain' );
	}

	add_action( 'thb_body_end', 'thb_curtain' );
}

/**
 * Rename the featured image to album cover for album page templates.
 */

function thb_album_cover_metabox_title( $translated_text, $text, $domain ) {
	if ( thb_is_admin_template( thb_get_theme_templates( 'gallery' ) ) ) {
		if ( $text == 'Featured Image' ) {
			$translated_text = __( 'Album cover', 'thb_text_domain' );
		}
	}

	return $translated_text;
}

function thb_album_change_featured_image_metabox_content( $content, $post_id ) {
	$post_type = get_post_type( $post_id );

	if ( $post_type == 'page' ) {
		$gallery_templates = thb_get_theme_templates( 'gallery' );
		$page_template = thb_get_page_template( $post_id );

		if ( in_array( $page_template, $gallery_templates ) ) {
			$content = str_replace( __( 'Set featured Image' ), __( 'Set album cover', 'thb_text_domain' ), $content );
			$content = str_replace( __( 'Set featured image' ), __( 'Set album cover', 'thb_text_domain' ), $content );
			$content = str_replace( __( 'Remove featured image' ), __( 'Remove album cover', 'thb_text_domain' ), $content );
		}
	}

	return $content;
}

function thb_album_change_featured_image_media_strings( $strings, $post ) {
	if ( ! $post ) {
		return $strings;
	}

	$post_type = get_post_type( $post->ID );

	if ( $post_type == 'page' ) {
		$gallery_templates = thb_get_theme_templates( 'gallery' );
		$page_template = thb_get_page_template( $post->ID );

		if ( in_array( $page_template, $gallery_templates ) ) {
			$strings['setFeaturedImage'] = __( 'Set album cover', 'thb_text_domain' );
			$strings['setFeaturedImageTitle'] = __( 'Set album cover', 'thb_text_domain' );
		}
	}

	return $strings;
}

add_filter( 'gettext', 						'thb_album_cover_metabox_title', 20, 3 );
add_filter( 'admin_post_thumbnail_html', 	'thb_album_change_featured_image_metabox_content', 10, 2 );
add_filter( 'media_view_strings', 			'thb_album_change_featured_image_media_strings', 10, 2);

if( !function_exists('thb_social_nav') ) {
	/**
	 * Add the social icon partials to the main nav block
	 */
	function thb_social_nav() {
		thb_get_template_part( 'partials/partial-socials.php' );
	}

	if ( thb_is_theme_layout_a() ) {
		add_action( 'thb_nav_end', 'thb_social_nav' );
	}
	elseif ( thb_is_theme_layout_b() || thb_is_theme_layout_d() ) {
		add_action( 'thb_nav_end', 'thb_social_nav', 20 );
	}
	elseif ( thb_is_theme_layout_c() ) {
		add_action( 'thb_nav_start', 'thb_social_nav' );
	}
}

/**
 * Portfolio options.
 */
function thb_superba_extend_portfolio_options() {
	if ( thb_is_admin_template( 'template-projects-grid.php' ) ) {
		$thb_metabox = thb_theme()->getPostType( 'page' )->getMetabox( 'layout' );
		$thb_tab = $thb_metabox->getTab( 'portfolio_options' );
		$thb_container = $thb_tab->getContainer( 'portfolio_loop_container' );

		$thb_field = new THB_CheckboxField( 'portfolio_enable_slideviews' );
			$thb_field->setLabel( __( 'Enable slideviews', 'thb_text_domain' ) );
			$thb_field->setHelp( __( 'By checking this, you enable the iPhoto-like effect for the projects. Only applies if a "fixed" height grid is being used.', 'thb_text_domain' ) );
		$thb_container->addField( $thb_field );
	}

	if ( function_exists( 'thb_portfolio_loop' ) ) {
		add_action( 'wp_loaded', 'thb_superba_extend_portfolio_options', 20 );
	}
}

/**
 * Remove the page subtitle from the Splash page since it doesn't use it.
 */
function thb_superba_disable_splash_subtitle() {
	if ( thb_is_admin_template( 'template-splash.php' ) ) {
		$thb_metabox = thb_theme()->getPostType( 'page' )->getMetabox( 'layout' );
		$thb_container = $thb_metabox->getContainer( 'layout_container' );

		$thb_container->removeField( 'subtitle' );
	}
}

add_action( 'wp_loaded', 'thb_superba_disable_splash_subtitle' );