<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

if( ! function_exists( 'thb_page_password_protected' ) ) {
	/**
	 * Handle password-protected pages and posts.
	 */
	function thb_page_password_protected() {
		if ( post_password_required() ) {
			get_template_part('partials/partial-pass-protected');
			get_footer();
			die();
		}
	}

	add_action( 'thb_page_before', 'thb_page_password_protected' );
	add_action( 'thb_post_before', 'thb_page_password_protected' );
}

if( ! function_exists( 'thb_get_social_networks' ) ) {
	/**
	 * Get a list of the defined social networks available for the theme.
	 * Filters empty social networks.
	 *
	 * @return array
	 */
	function thb_get_social_networks( $post_meta = false ) {

		if ( $post_meta == true ) {
			$social_networks = thb_get_post_meta( thb_get_page_ID(), 'social_networks' );
		} else {
			$social_networks = thb_get_option('social_networks');
		}

		if ( ! empty( $social_networks ) ) {
			$social_networks_array = array();

			foreach ( explode( ',', $social_networks ) as $social_network ) {
				if ( thb_get_social_network_url( $social_network ) != '' ) {
					$social_networks_array[] = $social_network;
				}
			}

			return $social_networks_array;
		}

		return array();
	}
}

if( ! function_exists( 'thb_get_theme_social_options' ) ) {
	/**
	 * Get the social options for the theme.
	 *
	 * @return array
	 */
	function thb_get_theme_social_options() {
		$thb_page = thb_theme()->getAdmin()->getMainPage();
		$thb_container = $thb_page->getTab('social')->getContainer('social_options');
		$options = array();

		foreach( $thb_container->getFields() as $field ) {
			$options[$field->getName()] = $field->getLabel();
		}

		return $options;
	}
}

if( ! function_exists( 'thb_get_social_network_url' ) ) {
	/**
	 * Get the URL of a specific social network service.
	 *
	 * @param string $social_network The social network key.
	 * @return string
	 */
	function thb_get_social_network_url( $social_network ) {
		$value = thb_get_option( $social_network );

		if ( $social_network == 'social_email' ) {
			$value = 'mailto:' . $value;
			$value = esc_attr( $value );
		}
		elseif ( $social_network == 'social_skype' ) {
			$value = 'skype:' . $value . '?add';
			$value = esc_attr( $value );
		}
		else {
			$value = esc_url( $value );
		}

		return $value;

	}
}

if( !function_exists('thb_is_enable_social_share') ) {
	/**
	 * Check if the social share option is checked
	 * @return boolean
	 */
	function thb_is_enable_social_share() {
		if ( thb_get_option( 'enable_social_share' ) == 1 ) {
			return true;
		}
		return false;
	}
}

if( ! function_exists( 'thb_is_blog_likes_active' ) ) {
	/**
	 * Check if likes have been activated for Blog posts.
	 *
	 * @return boolean
	 */
	function thb_is_blog_likes_active() {
		return (int) thb_get_option( 'thb_blog_likes_active' ) == 1;
	}
}

if( ! function_exists( 'thb_is_gallery_modal_share_active' ) ) {
	/**
	 * Check if sharing has been enabled for albums gallery modals.
	 *
	 * @return boolean
	 */
	function thb_is_gallery_modal_share_active() {
		return (int) thb_get_option( 'gallery_modal_enable_social_share' ) == 1;
	}
}

if( !function_exists('thb_get_theme_layout') ) {
	/**
	 * Return the theme layout option
	 * @return string
	 */
	function thb_get_theme_layout() {
		$thb_theme_layout = thb_get_option( 'theme_layout' );

		if( empty( $thb_theme_layout ) ) {
			$thb_theme_layout = 'thb-theme-layout-a';
		}

		$thb_theme_layout = apply_filters( 'thb_theme_layout', $thb_theme_layout );
		return $thb_theme_layout;
	}
}

if( !function_exists('thb_is_theme_layout_a') ) {
	/**
	 * Check if the theme layout is "A"
	 *
	 * @return boolean
	 */
	function thb_is_theme_layout_a() {
		if ( thb_get_theme_layout() === 'thb-theme-layout-a' ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_is_theme_layout_b') ) {
	/**
	 * Check if the theme layout is "B"
	 *
	 * @return boolean
	 */
	function thb_is_theme_layout_b() {
		if ( thb_get_theme_layout() === 'thb-theme-layout-b' ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_is_theme_layout_c') ) {
	/**
	 * Check if the theme layout is "C"
	 *
	 * @return boolean
	 */
	function thb_is_theme_layout_c() {
		if ( thb_get_theme_layout() === 'thb-theme-layout-a thb-theme-layout-right' ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_is_theme_layout_d') ) {
	/**
	 * Check if the theme layout is "D"
	 *
	 * @return boolean
	 */
	function thb_is_theme_layout_d() {
		if ( thb_get_theme_layout() === 'thb-theme-layout-b thb-theme-layout-right' ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_is_theme_layout_horizontal') ) {
	/**
	 * Check if the theme layout is horizontal
	 *
	 * @return boolean
	 */
	function thb_is_theme_layout_horizontal() {
		if ( thb_get_theme_layout() === 'thb-theme-layout-a' || thb_get_theme_layout() === 'thb-theme-layout-a thb-theme-layout-right' ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_is_theme_layout_vertical') ) {
	/**
	 * Check if the theme layout is vertical
	 *
	 * @return boolean
	 */
	function thb_is_theme_layout_vertical() {
		if ( thb_get_theme_layout() === 'thb-theme-layout-b' || thb_get_theme_layout() === 'thb-theme-layout-b thb-theme-layout-right' ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_get_subtitle_position') ) {
	/**
	 * Get the subtitle position
	 * @return string
	 */
	function thb_get_subtitle_position( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		$subtitle_position = thb_get_post_meta( $id, 'superba_subtitle_position' );
		$subtitle_position = apply_filters( 'subtitle_position', $subtitle_position );

		if ( empty( $subtitle_position ) ) {
			return 'subtitle-bottom';
		}

		return $subtitle_position;
	}
}

if( !function_exists('thb_is_subtitle_position_top') ) {
	/**
	 * Check if the subtitle position is top
	 * @return boolean
	 */
	function thb_is_subtitle_position_top() {
		if ( thb_get_subtitle_position() == 'subtitle-top' ) {
			return true;
		}
		return false;
	}
}

if( !function_exists('thb_is_subtitle_position_bottom') ) {
	/**
	 * Check if the subtitle position is bottom
	 * @return boolean
	 */
	function thb_is_subtitle_position_bottom() {
		if ( thb_get_subtitle_position() == 'subtitle-bottom' ) {
			return true;
		}
		return false;
	}
}

if( !function_exists('thb_get_page_width') ) {
	/**
	 * Get the page width value
	 * @return string
	 */
	function thb_get_page_width( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		$page_width = thb_get_post_meta( $id, 'superba_page_width' );
		$page_width = apply_filters( 'page_width', $page_width );

		if ( empty( $page_width ) ) {
			return 'thb-page-width-large';
		}

		return $page_width;
	}
}

if( !function_exists('thb_get_img_exif') ) {
	/**
	 * Extract exif data from an post_id
	 */
	function thb_get_img_exif( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		$exif = array();

		if ( wp_attachment_is_image( $id ) ) {
			$thb_metadata = wp_get_attachment_metadata( $id );

			$glossary = array();

			if ( $thb_metadata && is_array( $thb_metadata ) && isset( $thb_metadata['image_meta'] ) ) {
				$thb_image_meta = $thb_metadata['image_meta'];
				$glossary = array(
					'created_timestamp' => __( 'Taken on', 'thb_text_domain' ),
					'camera'            => __( 'Camera', 'thb_text_domain' ),
					'focal_length'      => __( 'Focal length', 'thb_text_domain' ),
					'aperture'          => __( 'Aperture', 'thb_text_domain' ),
					'iso'               => __( 'ISO', 'thb_text_domain' ),
					'shutter_speed'     => __( 'Shutter speed', 'thb_text_domain' ),
					'copyright'         => __( 'Copyright', 'thb_text_domain' ),
					'credit'            => __( 'Credit', 'thb_text_domain' ),
				);
			}

			$glossary = apply_filters( 'thb_superba_exif_glossary', $glossary );

			foreach ( $glossary as $key => $glossary_term ) {
				$value = isset( $thb_image_meta[$key] ) ? $thb_image_meta[$key] : '';

				if ( ! empty( $value ) && $key != 'orientation' ) {

					if ( $key == 'created_timestamp' ) {
						$value = date( get_option('date_format'), $value );
					}
					else if ( $key == 'shutter_speed' ) {
						if ((1 / $value) > 1) {
							if ((number_format((1 / $value), 1)) == 1.3
							or number_format((1 / $value), 1) == 1.5
							or number_format((1 / $value), 1) == 1.6
							or number_format((1 / $value), 1) == 2.5) {
								$value = "1/" . number_format((1 / $value), 1, '.', '') . ' ' . __( 'second', 'thb_text_domain' );
							} else {
								$value = "1/" . number_format((1 / $value), 0, '.', '') . ' ' . __( 'second', 'thb_text_domain' );
							}
						} else {
							$value = $value . ' ' . __( 'seconds', 'thb_text_domain' );
						}
					}
					else if ( $key == 'aperture' ) {
						$value = 'f/' . $value;
					}

					$label = isset( $glossary[$key] ) ? $glossary[$key] : $key;
					$exif[$label] = $value;
				}
			}
		}

		return $exif;
	}
}

if( !function_exists('thb_get_hide_featured_image') ) {
	/**
	 * Return the hide featured image checkbox value
	 */
	function thb_get_hide_featured_image( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		return thb_get_post_meta( $id, 'hide_featured_image' );
	}
}

if( !function_exists('thb_get_disable_work_image_link') ) {
	/**
	 * Return the disable work image link checkbox value
	 */
	function thb_get_disable_work_image_link( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		return thb_get_post_meta( $id, 'disable_work_image_link' );
	}
}

if( ! function_exists( 'thb_is_portfolio_likes_active' ) ) {
	/**
	 * Check if likes have been activated for Portfolio items.
	 *
	 * @return boolean
	 */
	function thb_is_portfolio_likes_active() {
		return (int) thb_get_option( 'thb_portfolio_likes_active' ) == 1;
	}
}

if( !function_exists('thb_get_project_short_description') ) {
	/**
	 * Get the project short description
	 *
	 * @return string
	 */
	function thb_get_project_short_description( $id = null ) {
		if ( ! $id ) {
			global $post;
			$id = thb_get_page_ID();
		}

		return thb_get_post_meta( $id, 'project_short_description' );
	}
}

if( !function_exists('thb_get_project_url') ) {
	/**
	 * Get the project URL
	 *
	 * @return string
	 */
	function thb_get_project_url() {
		return thb_get_post_meta( thb_get_page_ID(), 'project_url' );
	}
}

if( !function_exists('thb_get_gallery_grid_style') ) {
	/**
	 * Get the gallery grid style value
	 * @return string
	 */
	function thb_get_gallery_grid_style( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		$gallery_grid_style = thb_get_post_meta( $id, 'superba_gallery_grid_style' );
		$gallery_grid_style = apply_filters( 'gallery_grid_style', $gallery_grid_style );

		if ( empty( $gallery_grid_style ) ) {
			return 'thb-gallery-style-a';
		}

		return $gallery_grid_style;
	}
}

if( !function_exists('thb_is_gallery_grid_style_a') ) {
	/**
	 * Check if the gallery grid style is "A", text outside
	 * @return boolean
	 */
	function thb_is_gallery_grid_style_a() {
		if ( thb_get_gallery_grid_style() == 'thb-gallery-style-a' ) {
			return true;
		}
		return false;
	}
}

if( !function_exists('thb_get_page_header_alignment') ) {
	/**
	 * Get the page header alignment option value
	 *
	 * @return string
	 */
	function thb_get_page_header_alignment() {
		$thb_get_page_header_alignment = thb_get_post_meta( thb_get_page_ID(), 'superba_page_header_alignment' );

		if( empty( $thb_get_page_header_alignment ) ) {
			if ( is_archive() || is_search() ) {
				return 'pageheader-alignment-center';
			} else {
				return 'pageheader-alignment-left';
			}
		}

		return apply_filters( 'thb_get_page_header_alignment', $thb_get_page_header_alignment );
	}
}

if( !function_exists( 'thb_portfolio_index' ) ) {
	/**
	 * Print the back to portfolio link
	 *
	 * @return html
	 */
	function thb_portfolio_index() {
		$thb_portfolio_index = thb_portfolio_get_index( thb_get_page_ID() );
	?>
		<?php if ( !empty( $thb_portfolio_index ) ) : ?>
			<a class="back-to-portfolio" href="<?php echo get_permalink( $thb_portfolio_index ); ?>">
				<span><?php _e('Back to Portfolio', 'thb_text_domain' ); ?></span>
			</a>
		<?php endif; ?>
	<?php }
}

/**
 * Create a definition list containing EXIF data of featured image (if exists)
 *
 * @param	string		$post ID
 * @return 	echo definition list
 */
function pa_the_post_thumbnail_exif_data($postID = NULL) {
	// if $postID not specified, then get global post and assign ID
	if (!$postID) {
		global $post;
		$postID = $post->ID;
	}
	if (has_post_thumbnail($postID)) {
		// get the meta data from the featured image
		$postThumbnailID = get_post_thumbnail_id( $postID );
		$photoMeta = wp_get_attachment_metadata( $postThumbnailID );

		// if the shutter speed is not equal to 0
		if ($photoMeta['image_meta']['shutter_speed'] != 0) {

			// Convert the shutter speed to a fraction
			if ((1 / $photoMeta['image_meta']['shutter_speed']) > 1) {
				if ((number_format((1 / $photoMeta['image_meta']['shutter_speed']), 1)) == 1.3
				or number_format((1 / $photoMeta['image_meta']['shutter_speed']), 1) == 1.5
				or number_format((1 / $photoMeta['image_meta']['shutter_speed']), 1) == 1.6
				or number_format((1 / $photoMeta['image_meta']['shutter_speed']), 1) == 2.5) {
					$photoShutterSpeed = "1/" . number_format((1 / $photoMeta['image_meta']['shutter_speed']), 1, '.', '') . " second";
				} else {
					$photoShutterSpeed = "1/" . number_format((1 / $photoMeta['image_meta']['shutter_speed']), 0, '.', '') . " second";
				}
			} else {
				$photoShutterSpeed = $photoMeta['image_meta']['shutter_speed'] . " seconds";
			}
			// print our definition list
		?>
			<dl>
				<dt>Date Taken</dt>
				<dd><?php echo date("d M Y, H:i:s", $photoMeta['image_meta']['created_timestamp']); ?></dd>
				<dt>Camera</dt>
				<dd><?php echo $photoMeta['image_meta']['camera']; ?></dd>
				<dt>Focal Length</dt>
				<dd><?php echo $photoMeta['image_meta']['focal_length']; ?>mm</dd>
				<dt>Aperture</dt>
				<dd>f/<?php echo $photoMeta['image_meta']['aperture']; ?></dd>
				<dt>ISO</dt>
				<dd><?php echo $photoMeta['image_meta']['iso']; ?></dd>
				<dt>Shutter Speed</dt>
				<dd><?php echo $photoShutterSpeed; ?></dd>
			</dl>
		<?php
		// if shutter speed exif is 0 then echo error message
		} else {
			echo '<p>EXIF data not found</p>';
		}
	// if no featured image, echo error message
	} else {
		echo '<p>Featured image not found</p>';
	}
}

/**
 * Splash page helpers
 * -----------------------------------------------------------------------------
 */

if( !function_exists('thb_get_splash_title') ) {
	/**
	 * Get the splash page title
	 *
	 * @return string
	 */
	function thb_get_splash_title( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		return thb_get_post_meta( $id, 'splash_title' );
	}
}

if( !function_exists('thb_get_splash_subtitle') ) {
	/**
	 * Get the splash page subtitle
	 *
	 * @return string
	 */
	function thb_get_splash_subtitle( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		return thb_get_post_meta( $id, 'splash_subtitle' );
	}
}

if( !function_exists('thb_get_splash_subtitle_position') ) {
	/**
	 * Get the splash page subtitle position
	 *
	 * @return string
	 */
	function thb_get_splash_subtitle_position( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		$splash_subtitle_position = thb_get_post_meta( $id, 'splash_subtitle_position' );
		$splash_subtitle_position = apply_filters( 'splash_subtitle_position', $splash_subtitle_position );

		if ( empty( $splash_subtitle_position ) ) {
			return 'thb-splash-subtitle-bottom';
		}

		return $splash_subtitle_position;
	}
}

if( !function_exists('thb_get_splash_page_alignment') ) {
	/**
	 * Get the splash page text alignment
	 *
	 * @return string
	 */
	function thb_get_splash_page_alignment( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		$splash_alignment = thb_get_post_meta( $id, 'splash_page_alignment' );
		$splash_alignment = apply_filters( 'splash_page_alignment', $splash_alignment );

		if ( empty( $splash_alignment ) ) {
			return 'thb-splash-align-left';
		}

		return $splash_alignment;
	}
}

if( !function_exists('thb_get_splash_logo') ) {
	/**
	 * Get the splash page logo image
	 *
	 * @return ID
	 */
	function thb_get_splash_logo( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		return thb_get_post_meta( $id, 'splash_logo' );
	}
}

if( !function_exists('thb_get_splash_logo_retina') ) {
	/**
	 * Get the splash page retina logo image
	 *
	 * @return ID
	 */
	function thb_get_splash_logo_retina( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		return thb_get_post_meta( $id, 'splash_logo_retina' );
	}
}

if( !function_exists('thb_splash_logo') ) {
	/**
	 * Return the splash page logo markup
	 */
	function thb_splash_logo() {
		$logo             = apply_filters( 'thb_logo', thb_get_splash_logo() );
		$logo_2x          = apply_filters( 'thb_logo_2x', thb_get_splash_logo_retina() );

		$args = array(
			'logo'          => thb_image_get_size( $logo ),
			'logo_2x'       => thb_image_get_size( $logo_2x )
		);

		if ( ! empty( $args['logo'] ) && ! empty( $args['logo_2x'] ) ) {
			$args['splash_logo_metadata'] = wp_get_attachment_metadata( $logo );
		}

		return thb_get_template_part( 'partials/partial-splash-logo', $args );
	}
}

if( !function_exists('thb_splash_html_class') ) {
	function thb_splash_html_class( $classes ) {

		if ( thb_is_page_template( 'template-splash.php' ) ) {
			$classes[] = "thb-splash-page";

			if ( apply_filters( 'show_admin_bar', true ) && is_user_logged_in() ) {
				$classes[] = "thb-admin-bar";
			}
		}

		return $classes;
	}

	add_filter('thb_html_class', 'thb_splash_html_class');
}

if( !function_exists('thb_get_splash_action_label') ) {
	/**
	 * Get the splash page subtitle
	 *
	 * @return string
	 */
	function thb_get_splash_action_label( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		return thb_get_post_meta( $id, 'splash_action_label' );
	}
}

if( !function_exists('thb_get_splash_action_url') ) {
	/**
	 * Get the splash call to action url
	 *
	 * @return string
	 */
	function thb_get_splash_action_url( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		return thb_get_post_meta( $id, 'splash_action_url' );
	}
}

if( !function_exists('thb_get_splash_overlay_color') ) {
	/**
	 * Get the splash overlay color
	 *
	 * @return string
	 */
	function thb_get_splash_overlay_color( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		return thb_get_post_meta( $id, 'splash_overlay_color' );
	}
}

if( !function_exists('thb_get_splash_overlay_opacity') ) {
	/**
	 * Get the splash overlay opacity
	 *
	 * @return string
	 */
	function thb_get_splash_overlay_opacity( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		return thb_get_post_meta( $id, 'splash_overlay_opacity' );
	}
}

if( !function_exists('thb_get_splash_logo_url') ) {
	/**
	 * Get the splash logo url
	 *
	 * @return string
	 */
	function thb_get_splash_logo_url( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		return thb_get_post_meta( $id, 'splash_logo_url' );
	}
}

/**
 * Curtain helpers
 * -----------------------------------------------------------------------------
 */

if( !function_exists('thb_curtain_logo') ) {
	/**
	 * Return the splash page logo markup
	 */
	function thb_curtain_logo() {
		$main_logo       = apply_filters( 'thb_logo', thb_get_option( 'main_logo' ) );
		$main_logo_2x    = apply_filters( 'thb_logo_2x', thb_get_option( 'main_logo_retina' ) );
		$curtain_logo    = apply_filters( 'thb_curtain_logo', thb_get_option( 'curtain_logo' ) );
		$curtain_logo_2x = apply_filters( 'thb_curtain_logo_2x', thb_get_option( 'curtain_logo_retina' ) );

		$logo_description = apply_filters( 'thb_logo_description', get_bloginfo( 'description' ) );

		$logo = $main_logo;
		$logo_2x = $main_logo_2x;

		if ( ! empty( $curtain_logo ) ) {
			$logo = $curtain_logo;
		}

		if ( ! empty( $curtain_logo_2x ) ) {
			$logo_2x = $curtain_logo_2x;
		}

		$args = array(
			'logo'            => thb_image_get_size( $logo ),
			'logo_2x'         => thb_image_get_size( $logo_2x ),
			'description'     => $logo_description,
		);

		if ( ! empty( $args['logo'] ) && ! empty( $args['logo_2x'] ) ) {
			$args['logo_metadata'] = wp_get_attachment_metadata( $logo );
		}

		return thb_get_template_part( 'partials/partial-curtain-logo', $args );
	}
}

if( !function_exists('thb_gallery_disable_featured_image') ) {
	/**
	 * Check if the gallery disable featured image is checked
	 *
	 * @return boolean
	 */
	function thb_gallery_disable_featured_image( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		if ( thb_get_post_meta( $id, 'gallery_disable_featured_image' ) == 1 ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_get_gallery_modal_skin') ) {
	/**
	 * Get the modal skin
	 * @return string
	 */
	function thb_get_gallery_modal_skin( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		$modal_skin = thb_get_post_meta( $id, 'gallery_modal_skin' );
		$modal_skin = apply_filters( 'gallery_modal_skin', $modal_skin );

		if ( empty( $modal_skin ) ) {
			return 'modal-skin-light';
		}

		return $modal_skin;
	}
}

if( !function_exists('thb_is_gallery_modal_details_opened') ) {
	/**
	 * Check if the gallery_modal_details_auto_open option is enabled
	 *
	 * @return boolean
	 */
	function thb_is_gallery_modal_details_opened( $id = null) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		if ( thb_get_post_meta( $id, 'gallery_modal_details_auto_open' ) == 1 ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_is_gallery_modal_without_margins') ) {
	/**
	 * Check if the gallery_modal_disable_margins option is enabled and as such
	 * the gallery modal displays no margins around images.
	 *
	 * @return boolean
	 */
	function thb_is_gallery_modal_without_margins( $id = null) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		if ( thb_get_post_meta( $id, 'gallery_modal_disable_margins' ) == 1 ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_is_gallery_modal_disabled') ) {
	/**
	 * Check if the gallery modal is enabled.
	 *
	 * @return boolean
	 */
	function thb_is_gallery_modal_disabled( $id = null) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		if ( thb_get_post_meta( $id, 'gallery_modal_disable' ) == 1 ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_is_content_available') ) {
	function thb_is_content_available( $post ) {
		if ( ! $post || ! is_object( $post ) ) {
			return false;
		}

		$content = apply_filters( 'the_content', $post->post_content );
		$show_page_content = ! empty( $content );

		$show_page_header = (
			! thb_page_header_disabled()
			&& ! ( thb_slideshow_has_slides() )
		);

		$is_footer_sidebar_active = thb_footer_active();

		if ( ! thb_is_builder_empty() || $show_page_content == true || $show_page_header || $is_footer_sidebar_active ) {
			return true;
		}

		return false;
	}
}

if( !function_exists('thb_get_portfolio_styles') ) {
	/**
	 * Get the 'superba_portfolio_styles' portfolio meta value
	 *
	 * @return string
	 */
	function thb_get_portfolio_styles( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		$thb_get_portfolio_styles = thb_get_post_meta( $id, 'superba_portfolio_styles' );
		$thb_get_portfolio_styles = apply_filters( 'thb_get_portfolio_styles', $thb_get_portfolio_styles );


		if( empty( $thb_get_portfolio_styles ) ) {
			return 'thb-desc-outside';
		}

		return $thb_get_portfolio_styles;
	}
}

if( ! function_exists( 'thb_is_enable_theme_animations' ) ) {
	/**
	 * Check if the theme animations are enabled.
	 *
	 * @return boolean
	 */
	function thb_is_enable_theme_animations() {
		return (int) thb_get_option( 'enable_theme_animations' ) == 1;
	}
}

if( ! function_exists( 'thb_is_preloader_disabled' ) ) {
	/**
	 * Check if the theme preloader is disabled.
	 *
	 * @return boolean
	 */
	function thb_is_preloader_disabled() {
		return (int) thb_get_option( 'disable_preloader' ) == 1;
	}
}

if( ! function_exists( 'thb_is_slideshow_fullscreen' ) ) {
	/**
	 * Check if the slideshow is full screen
	 *
	 * @return boolean
	 */
	function thb_is_slideshow_fullscreen( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		if ( thb_get_post_meta( $id, 'slideshow_fullscreen' ) == 1 && thb_is_page_template( 'template-slideshow-gallery.php', $id ) ) {
			return true;
		}

		return false;
	}
}

/**
 * Get the image size used in the slideshow album display.
 *
 * @param integer $id
 * @return string
 */
function thb_get_slideshow_image_size( $id = null ) {
	if ( ! $id ) {
		$id = thb_get_page_ID();
	}

	$image_size = thb_get_post_meta( $id, 'slideshow_image_size' );

	if ( $image_size == '' ) {
		$image_size = 'large';
	}

	return apply_filters( 'thb_slideshow_image_size', $image_size );
}

if ( ! function_exists( 'thb_get_builder_position' ) ) {
	/**
	 * Get the builder position in the page.
	 *
	 * @return string
	 */
	function thb_get_builder_position_gallery_pages() {
		$builder_position_gallery_pages = thb_get_post_meta( thb_get_page_ID(), 'builder_position_gallery_pages' );
		$builder_position_gallery_pages = apply_filters( 'thb_get_builder_position_gallery_pages', $builder_position_gallery_pages );

		if ( empty( $builder_position_gallery_pages ) ) {
			$builder_position_gallery_pages = 'top';
		}

		return $builder_position_gallery_pages;
	}
}

if ( ! function_exists( 'thb_is_builder_position_gallery_pages_top' ) ) {
	/**
	 * Check if the builder section should be placed above the gallery.
	 *
	 * @return boolean
	 */
	function thb_is_builder_position_gallery_pages_top() {
		return thb_get_builder_position_gallery_pages() == 'top';
	}
}

if ( ! function_exists( 'thb_is_builder_position_gallery_pages_bottom' ) ) {
	/**
	 * Check if the builder section should be placed below the gallery.
	 *
	 * @return boolean
	 */
	function thb_is_builder_position_gallery_pages_bottom() {
		return ! thb_is_builder_position_gallery_pages_top();
	}
}

if ( ! function_exists( 'thb_archive_thumbnails_open_post' ) ) {
	/**
	 * Check if post thumbnails in Archive loops should link to the post page instead
	 * of opening their image or lightbox.
	 *
	 * @return boolean
	 */
	function thb_archive_thumbnails_open_post() {
		return thb_get_option( 'archive_thumbnails_open_post' ) == '1';
	}
}