<?php

/* Gallery media taxonomy. */
require_once dirname( __FILE__ ) . '/taxonomy.php';

/**
 * Admin styles.
 */
thb_theme()->getAdmin()->addStyle( get_template_directory_uri() . '/config/gallery/admin.css' );

/**
 * Alter the Portfolio plugin labels.
 *
 * @param array $labels
 * @return array
 */
function thb_superba_works_labels( $labels ) {
	return array(
		'name'               => __( 'Projects', 'thb_text_domain' ),
		'singular_name'      => __( 'Project', 'thb_text_domain' ),
		'add_new'            => __( 'Add new', 'thb_text_domain' ),
		'add_new_item'       => __( 'Add new Project', 'thb_text_domain' ),
		'edit'               => __( 'Edit', 'thb_text_domain' ),
		'edit_item'          => __( 'Edit Project', 'thb_text_domain' ),
		'new_item'           => __( 'New Project', 'thb_text_domain' ),
		'view'               => __( 'View Project', 'thb_text_domain' ),
		'view_item'          => __( 'View Project', 'thb_text_domain' ),
		'search_items'       => __( 'Search Projects', 'thb_text_domain' ),
		'not_found'          => __( 'No Projects found', 'thb_text_domain' ),
		'not_found_in_trash' => __( 'No Projects found in Trash', 'thb_text_domain' ),
		'parent'             => __( 'Parent Project', 'thb_text_domain' )
	);
}

add_filter( 'thb_works_labels', 'thb_superba_works_labels' );

/**
 * Alter the Portfolio Categories configuratio.
 *
 * @param array $config
 * @return array
 */
function thb_superba_portfolio_categories_args( $config ) {
	$config['labels']['name']              = __( 'Project Categories', 'thb_text_domain' );
	$config['labels']['singular_name']     = __( 'Project Category', 'thb_text_domain' );
	$config['labels']['search_items']      = __( 'Search Project Categories', 'thb_text_domain' );
	$config['labels']['all_items']         = __( 'All Project Categories', 'thb_text_domain' );
	$config['labels']['parent_item']       = __( 'Parent Project Category', 'thb_text_domain' );
	$config['labels']['parent_item_colon'] = __( 'Parent Project Category:', 'thb_text_domain' );
	$config['labels']['edit_item']         = __( 'Edit Project Category', 'thb_text_domain' );
	$config['labels']['update_item']       = __( 'Update Project Category', 'thb_text_domain' );
	$config['labels']['add_new_item']      = __( 'Add New Project Category', 'thb_text_domain' );
	$config['labels']['new_item_name']     = __( 'New Project Category Name', 'thb_text_domain' );
	$config['labels']['menu_name']         = __( 'Project Categories', 'thb_text_domain' );

	return $config;
}

add_filter( 'thb_portfolio_categories_args', 'thb_superba_portfolio_categories_args' );

/**
 * Check if we're in a gallery template on admin.
 *
 * @return boolean
 */
function thb_superba_is_gallery_admin_template() {
	$thb_admin_gallery_template = array(
		'template-grid-gallery.php',
		'template-carousel-gallery.php',
		'template-slideshow-gallery.php',
		'template-mosaic-gallery.php',
	);

	return thb_is_admin_template( $thb_admin_gallery_template );
}

/**
 * Get a list of gallery categories.
 *
 * @return array
 */
function thb_superba_get_gallery_categories() {
	$terms = array();

	$terms_args = array(
		'hide_empty' => false
	);

	foreach ( get_terms( 'superba_gallery_categories', $terms_args ) as $term ) {
		$terms[$term->term_id] = $term->name;
	}

	return $terms;
}

if( ! function_exists( 'thb_superba_extend_work_slides' ) ) {
	/**
	 * Add the required fields to the work slides modals.
	 *
	 * @param THB_SlideField $slide
	 * @return THB_SlideField
	 */
	function thb_superba_extend_work_slides( $slide ) {
		$thb_modal_image = $slide->getModal( 'edit_slide_image' );
		$thb_modal_image_container = $thb_modal_image->getContainer( 'edit_slide_image_container' );

		$thb_modal_video = $slide->getModal( 'edit_slide_video' );
		$thb_modal_video_container = $thb_modal_video->getContainer( 'edit_slide_video_container' );

			$thb_field = new THB_MultipleSelectField( 'gallery_category' );
				$thb_field->setInvisibleIfEmpty(false);
				$thb_field->setLabel( __( 'Category', 'thb_text_domain' ) );
				$thb_field->setOptions( thb_superba_get_gallery_categories() );
			$thb_modal_image_container->addField( $thb_field, 0 );
			$thb_modal_video_container->addField( $thb_field, 0 );

			$thb_field = new THB_TextField( 'gallery_title' );
				$thb_field->setLabel( __( 'Title', 'thb_text_domain' ) );
			$thb_modal_image_container->addField( $thb_field, 1 );
			$thb_modal_video_container->addField( $thb_field, 1 );

		return $slide;
	}

	add_filter( 'thb_work_slide', 'thb_superba_extend_work_slides' );
	add_filter( 'thb_gallery_media', 'thb_superba_extend_work_slides' );
}

if ( ! function_exists( 'thb_superba_extend_gallery_slides' ) ) {
	/**
	 * Alter the data of gallery slides.
	 *
	 * @param THB_SlideField $slide
	 * @return THB_SlideField
	 */
	function thb_superba_extend_gallery_slides( $slide ) {
		$thb_modal_video = $slide->getModal( 'edit_slide_video' );
		$thb_modal_image = $slide->getModal( 'edit_slide_image' );
		$thb_modal_video_container = $thb_modal_video->getContainer( 'edit_slide_video_container' );
		$thb_modal_image_container = $thb_modal_image->getContainer( 'edit_slide_image_container' );

		$thb_modal_video_container->getField( 'id' )->setHelp( __( 'Only YouTube and Vimeo are supported.', 'thb_text_domain' ) );

		$thb_modal_image_container->removeField( 'class' );
		$thb_modal_video_container->removeField( 'class' );
		$thb_modal_video_container->removeField( 'autoplay' );
		$thb_modal_video_container->removeField( 'loop' );
		$thb_modal_video_container->removeField( 'fit' );

		return $slide;
	}

	add_filter( 'thb_gallery_media', 'thb_superba_extend_gallery_slides' );
	add_filter( 'thb_work_slide', 'thb_superba_extend_gallery_slides' );
}

if ( ! function_exists( 'thb_superba_gallery_page_template' ) ) {
	function thb_superba_gallery_page_template() {
		$thb_pages = thb_theme()->getPostType( 'page' );

		$slide_field = new THB_SlideField( 'media' );
		$slide_field->setLabel( __( 'Media', 'thb_text_domain' ) );
		$slide_field = apply_filters( 'thb_gallery_media', $slide_field );

		$thb_admin_gallery_template = array(
			'template-grid-gallery.php',
			'template-carousel-gallery.php',
			'template-slideshow-gallery.php',
			'template-mosaic-gallery.php',
		);

		$thb_metabox = $thb_pages->getMetabox('layout');

		if ( thb_is_admin_template( $thb_admin_gallery_template ) ) {
			$thb_tab = $thb_metabox->createTab( __( 'Gallery', 'thb_text_domain' ), 'contents' );
			$thb_tab->setIcon( 'screenoptions' );

			/**
			 * Gallery category selection container.
			 */
			$thb_container = $thb_tab->createContainer( __( 'Gallery', 'thb_text_domain' ), 'gallery_selection' );

			if ( thb_is_admin_template( 'template-carousel-gallery.php' ) ) {
				$thb_field = new THB_SelectField( 'carousel_alignment' );
					$thb_field->setLabel( __( 'Carousel alignment', 'thb_text_domain' ) );
					$thb_field->setOptions( array(
						'center' => __( 'Centered', 'thb_text_domain' ),
						'left' => __( 'Left', 'thb_text_domain' ),
					) );
				$thb_container->addField( $thb_field );

				$thb_field = new THB_SelectField( 'carousel_starts_from' );
					$thb_field->setLabel( __( 'Carousel starts from', 'thb_text_domain' ) );
					$thb_field->setOptions( array(
						'1' => __( 'Second slide', 'thb_text_domain' ),
						'0' => __( 'First slide', 'thb_text_domain' ),
					) );
				$thb_container->addField( $thb_field );

				$thb_field = new THB_CheckboxField( 'carousel_highlight_active' );
					$thb_field->setLabel( __( 'Highlight only the active carousel slide.', 'thb_text_domain' ) );
				$thb_container->addField( $thb_field );
			}

			if ( thb_is_admin_template( 'template-mosaic-gallery.php' ) ) {
				$thb_field = new THB_TextField( 'superba_gallery_mosaic_module' );
				$thb_field->setLabel( __( 'Mosaic module', 'thb_text_domain' ) );
				$thb_field->setHelp( __( 'E.g. 231 will produce three rows, the 1st with two images, the 2nd with three, etc.', 'thb_text_domain' ) );
				$thb_container->addField( $thb_field );

				$thb_field = new THB_NumberField( 'superba_gallery_mosaic_gutter' );
				$thb_field->setLabel( __( 'Mosaic gutter', 'thb_text_domain' ) );
				$thb_field->setHelp( __( 'Space between images, in pixels.', 'thb_text_domain' ) );
				$thb_field->setMin( 0 );
				$thb_container->addField( $thb_field );

				$thb_field = new THB_SelectField( 'superba_gallery_mosaic_image_size' );
				$thb_field->setLabel( __( 'Mosaic image size', 'thb_text_domain' ) );
				$thb_field->setOptions( array(
					'large'     => __( 'Large', 'thb_text_domain' ),
					'medium'    => __( 'Medium', 'thb_text_domain' ),
					'thumbnail' => __( 'Small', 'thb_text_domain' ),
					'full'      => __( 'Full', 'thb_text_domain' ),
				) );
				$thb_container->addField( $thb_field );
			}

			if ( thb_is_admin_template( 'template-slideshow-gallery.php' ) ) {
				$thb_field = new THB_SelectField('slideshow_effect');
				$thb_field->setLabel( __('Slideshow effect', 'thb_text_domain') );
				$thb_field->setOptions( array(
					'move'  => __('Slide', 'thb_text_domain'),
					'fade' => __('Fade', 'thb_text_domain')
				) );
				$thb_container->addField($thb_field);

				$thb_field = new THB_CheckboxField( 'slideshow_fullscreen' );
					$thb_field->setLabel( __( 'Enable full screen display', 'thb_text_domain' ) );
				$thb_container->addField( $thb_field );

				$thb_field = new THB_SelectField( 'slideshow_image_size' );
					$thb_field->setLabel( __( 'Image size', 'thb_text_domain' ) );
					$thb_field->setOptions( array(
						'large'     => __( 'Large', 'thb_text_domain' ),
						'medium'    => __( 'Medium', 'thb_text_domain' ),
						'full'      => __( 'Full', 'thb_text_domain' ),
					) );
				$thb_container->addField( $thb_field );
			}

			if ( thb_is_admin_template( 'template-grid-gallery.php' ) ) {
				thb_grid_layout_add_fields( $thb_container, array(
					'3' => '3',
					'4' => '4',
					'5' => '5',
				) );

				$thb_field = new THB_NumberField( 'gallery_pace' );
					$thb_field->setLabel( __( 'Items loaded at a time', 'thb_text_domain' ) );
					$thb_field->setHelp( __( 'This helps to reduce the page load, if you have lots of media.', 'thb_text_domain' ) );
					$thb_field->setMin( '-1' );
				$thb_container->addField( $thb_field );
			}

			$thb_field = new THB_CheckboxField( 'gallery_from_projects_and_albums' );
				$label = __( 'Include images & videos from other albums', 'thb_text_domain' );

				if ( defined( 'THB_PORTFOLIO_KEY' ) ) {
					$label = __( 'Include images & videos from projects and other albums', 'thb_text_domain' );
				}

				$thb_field->setLabel( $label );
			$thb_container->addField( $thb_field );

			$thb_field = new THB_MultipleSelectField( 'gallery_category' );
				$thb_field->setInvisibleIfEmpty( false );
				$thb_field->setLabel( __( 'Gallery categories', 'thb_text_domain' ) );

				$help = __( 'When including items from other albums, pick up only items belonging to these categories.', 'thb_text_domain' );
				if ( defined( 'THB_PORTFOLIO_KEY' ) ) {
					$help = __( 'When including items from projects or other albums, pick up only items belonging to these categories.', 'thb_text_domain' );
				}

				$thb_field->setHelp( $help );
				$thb_field->setOptions( thb_superba_get_gallery_categories() );
			$thb_container->addField( $thb_field );

			if ( thb_is_admin_template( 'template-grid-gallery.php' ) ) {
				$thb_field = new THB_CheckboxField( 'gallery_filter_hide' );
					$thb_field->setLabel( __( 'Hide filter', 'thb_text_domain' ) );
				$thb_container->addField( $thb_field );
			}

			/**
			 * Custom media container.
			 */
			$thb_container = new THB_MetaboxDuplicableFieldsContainer( __('Images and videos', 'thb_text_domain'), 'slides_container' );
			$thb_container->setSortable();

			$thb_container->addControl( __('Add images', 'thb_text_domain'), 'add_image', '', array(
				'action' => 'thb_add_multiple_slides',
				'title'  => __('Add images', 'thb_text_domain')
			) );

			$thb_container->addControl( __('Add video', 'thb_text_domain'), 'add_video', '', array(
				'action' => 'thb_add_video_slide',
				'title'  => __('Add video', 'thb_text_domain')
			) );

				$thb_container->setField($slide_field);

			$thb_tab->addContainer($thb_container);
		}
	}

	add_action( 'init', 'thb_superba_gallery_page_template', 20 );
}

function thb_superba_get_project_items( $id = 0 ) {
	if ( ! $id ) {
		$id = thb_get_page_ID();
	}

	return thb_get_portfolio_item_slides( $id );
}

function thb_superba_gallery_filter( $id = 0 ) {
	if ( ! $id ) {
		$id = thb_get_page_ID();
	}

	if ( thb_get_post_meta( $id, 'gallery_filter_hide' ) ) {
		return;
	}

	$items = thb_superba_get_gallery_items( $id );

	if ( ! empty( $items ) ) {
		$gallery_categories = array();

		foreach ( $items as $item ) {
			$gallery_category = explode( ',', $item['gallery_category'] );

			foreach ( $gallery_category as $cat ) {
				$gallery_categories[] = $cat;
			}
		}

		$gallery_categories = array_unique( $gallery_categories );

		if ( ! empty( $gallery_categories ) ) {
			$filter_terms = array();

			foreach ( $gallery_categories as $category ) {
				$term = get_term( $category, 'superba_gallery_categories' );

				if ( ! is_wp_error( $term ) ) {
					$filter_terms[$term->term_id] = $term->name;
				}
			}

			if ( empty( $filter_terms ) ) {
				return;
			}

			echo '<div class="thb-grid-gallery-filter">';
				echo '<ul class="filterlist">';
					echo '<li class="filter active" data-filter="">';
						echo "<span>";
							echo __('All', 'thb_text_domain');
						echo "</span>";
					echo '</li>';

					foreach ( $filter_terms as $term_id => $term_name ) {
						printf( '<li class="filter %s" data-filter="%s">', '', $term_id );
							echo "<span>";
								echo $term_name;
							echo "</span>";
						echo '</li>';
					}
				echo '</ul>';
			echo '</div>';
		}
	}
}

function thb_superba_get_gallery_items( $id = 0, $image_size = 'full' ) {
	if ( ! $id ) {
		$id = thb_get_page_ID();
	}

	$gallery_from_projects_and_albums = thb_get_post_meta( $id, 'gallery_from_projects_and_albums' );
	$items = array();
	$projects = array();
	$albums_pages = array();

	$gallery_categories = explode( ',', thb_get_post_meta( $id, 'gallery_category' ) );

	if ( $gallery_from_projects_and_albums ) {
		if ( defined( 'THB_PORTFOLIO_KEY' ) ) {
			$projects = get_posts( array(
				'post_type'      => 'works',
				'posts_per_page' => -1
			) );
		}

		$albums_pages = thb_get_pages_for_select( thb_get_theme_templates( 'gallery' ) );

		if ( ! empty( $albums_pages ) ) {
			if ( isset( $albums_pages[0] ) ) {
				unset( $albums_pages[0] );
			}

			if ( isset( $albums_pages[$id] ) ) {
				unset( $albums_pages[$id] );
			}
		}
	}

	/**
	 * Other albums media.
	 */
	foreach ( $albums_pages as $album_id => $album_name ) {
		$album_items = thb_get_entry_slides( 'media', $album_id );

		foreach ( $album_items as $album_item ) {
			$item_category = explode( ',', $album_item['gallery_category'] );
			$intersect = array_intersect( $item_category, $gallery_categories );

			if ( empty( $gallery_categories ) || empty( $gallery_categories[0] ) || ! empty( $intersect ) ) {
				$items[] = array(
					'type'             => $album_item['type'],
					'id'               => $album_item['id'],
					'link'			   => get_attachment_link( (int) $album_item['id'] ),
					'url'              => $album_item['type'] == 'image' ? thb_image_get_size( $album_item['id'], $image_size ) : thb_get_video_thumbnail( $album_item['id'], 'thumbnail_large' ),
					'url_full'         => $album_item['type'] == 'image' ? thb_image_get_size( $album_item['id'], 'full' ) : thb_get_video_thumbnail( $album_item['id'], 'thumbnail_large' ),
					'gallery_category' => isset( $album_item['gallery_category'] ) ? $album_item['gallery_category'] : '',
					'title'            => isset( $album_item['gallery_title'] ) ? $album_item['gallery_title'] : '',
					'description'      => isset( $album_item['caption'] ) ? $album_item['caption'] : '',
					'exif'             => thb_get_img_exif( $album_item['id'] ),
					'project'          => false
				);
			}
		}
	}

	/**
	 * Project media.
	 */
	foreach ( $projects as $project ) {
		$project_items = thb_superba_get_project_items( $project->ID );

		foreach ( $project_items as $project_item ) {
			$project_category = explode( ',', $project_item['gallery_category'] );
			$intersect = array_intersect( $project_category, $gallery_categories );

			if ( empty( $gallery_categories ) || empty( $gallery_categories[0] ) || ! empty( $intersect ) ) {
				$items[] = array(
					'type'             => $project_item['type'],
					'id'               => $project_item['id'],
					'link'			   => get_attachment_link( (int) $project_item['id'] ),
					'url'              => $project_item['type'] == 'image' ? thb_image_get_size( $project_item['id'], $image_size ) : $project_item['id'],
					'url_full'         => $project_item['type'] == 'image' ? thb_image_get_size( $project_item['id'], 'full' ) : thb_get_video_thumbnail( $project_item['id'], 'thumbnail_large' ),
					'gallery_category' => $project_item['gallery_category'],
					'title'            => isset( $project_item['gallery_title'] ) ? $project_item['gallery_title'] : '',
					'description'      => isset( $project_item['caption'] ) ? $project_item['caption'] : '',
					'exif'             => thb_get_img_exif( $project_item['id'] ),
					'project'          => array(
						'id'        => $project->ID,
						'permalink' => get_permalink( $project->ID ),
						'name'      => apply_filters( 'the_title', $project->post_title ),
					)
				);
			}
		}
	}

	/**
	 * Page media.
	 */
	$page_media_items = thb_get_entry_slides( 'media', $id );

	foreach ( $page_media_items as $page_media_item ) {
		$items[] = array(
			'type'             => $page_media_item['type'],
			'id'               => $page_media_item['id'],
			'link'			   => get_attachment_link( (int) $page_media_item['id'] ),
			'url'              => $page_media_item['type'] == 'image' ? thb_image_get_size( $page_media_item['id'], $image_size ) : thb_get_video_thumbnail( $page_media_item['id'], 'thumbnail_large' ),
			'url_full'         => $page_media_item['type'] == 'image' ? thb_image_get_size( $page_media_item['id'], 'full' ) : thb_get_video_thumbnail( $page_media_item['id'], 'thumbnail_large' ),
			'gallery_category' => isset( $page_media_item['gallery_category'] ) ? $page_media_item['gallery_category'] : '',
			'title'            => isset( $page_media_item['gallery_title'] ) ? $page_media_item['gallery_title'] : '',
			'description'      => isset( $page_media_item['caption'] ) ? $page_media_item['caption'] : '',
			'exif'             => thb_get_img_exif( $page_media_item['id'] ),
			'project'          => false
		);
	}

	return $items;
}

/**
 * Get the single works slides.
 *
 * @param  integer $id Single project ID.
 * @return array
 */
function thb_get_single_works_slides( $id = 0, $image_size = 'full' ) {
	if ( ! $id ) {
		$id = get_the_ID();
	}

	$items = array();
	$page_media_items = thb_get_entry_slides( 'work_slide', $id );

	foreach ( $page_media_items as $page_media_item ) {
		$items[] = array(
			'type'             => $page_media_item['type'],
			'id'               => $page_media_item['id'],
			'url'              => $page_media_item['type'] == 'image' ? thb_image_get_size( $page_media_item['id'], $image_size ) : thb_get_video_thumbnail( $page_media_item['id'], 'thumbnail_large' ),
			'url_full'         => $page_media_item['type'] == 'image' ? thb_image_get_size( $page_media_item['id'], 'full' ) : thb_get_video_thumbnail( $page_media_item['id'], 'thumbnail_large' ),
			'gallery_category' => isset( $page_media_item['gallery_category'] ) ? $page_media_item['gallery_category'] : '',
			'title'            => isset( $page_media_item['gallery_title'] ) ? $page_media_item['gallery_title'] : '',
			'description'      => isset( $page_media_item['caption'] ) ? $page_media_item['caption'] : '',
			'exif'             => thb_get_img_exif( $page_media_item['id'] ),
			'project'          => false
		);
	}

	return $items;
}

if( ! function_exists('thb_album_builder_block') ) {
	function thb_album_builder_block() {
		if ( function_exists( 'thb_builder_instance' ) ) {
			require_once dirname(__FILE__) . '/album_builder_block.php';
		}
	}

	add_action( 'wp_loaded', 'thb_album_builder_block' );
}

if( !function_exists('thb_is_carousel_highlight_active') ) {
	function thb_is_carousel_highlight_active( $id = null ) {
		if ( ! $id ) {
			$id = thb_get_page_ID();
		}

		if ( thb_get_post_meta( $id, 'carousel_highlight_active' ) == 1 ) {
			return true;
		}

		return false;
	}
}