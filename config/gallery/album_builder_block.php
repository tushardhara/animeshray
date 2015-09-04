<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

if( ! class_exists( 'THB_AlbumBlock' ) && function_exists( 'thb_builder' ) ) {
	/**
	 * Builder album block.
	 */
	class THB_AlbumBlock extends THB_BuilderBlock {

		/**
		 * Constructor
		 *
		 * @param string $title The block title.
		 **/
		public function __construct()
		{
			parent::__construct(
				'thb_album',
				__( 'Album', 'thb_text_domain' ),
				THB_THEME_CONFIG_DIR . '/gallery/block_thb_album'
			);

			$this->setDescription( __( 'Create a link to a specific album.', 'thb_text_domain' ) );

			$this->buildModals();
		}

		/**
		 * Build the block modals.
		 */
		private function buildModals()
		{
			$thb_modal = new THB_Modal( $this->getTitle(), $this->getSlug() );
				$thb_modal_container = $thb_modal->createContainer( '', $this->getSlug() . '_container' );

					$albums_pages = thb_get_pages_for_select( thb_get_theme_templates( 'gallery') );

					$thb_field = new THB_SelectField( 'album_select' );
					$thb_field->setLabel( __( 'Select the Album', 'thb_text_domain') );
					$thb_field->setHelp( __( 'Choose the album page that must be displayed from all the pages with an "albums" page template assigned', 'thb_text_domain' ) );
					$thb_field->setOptions( $albums_pages );
					$thb_modal_container->addField($thb_field);

					$thb_field = new THB_TextField( 'title' );
					$thb_field->setLabel( __( 'Title', 'thb_text_domain' ) );
					$thb_field->setHelp( __( 'Enter a new title that will override the original page title.', 'thb_text_domain' ) );
					$thb_modal_container->addField( $thb_field );

					$thb_field = new THB_GraphicRadioField( 'data_position' );
					$thb_field->setLabel( __( 'Labels positioning', 'thb_text_domain' ) );
					$thb_field->setOptions( array(
						'thb-desc-outside' => get_template_directory_uri() . '/css/i/thb-desc-outside.png',
						'thb-desc-inside'  => get_template_directory_uri() . '/css/i/thb-desc-inside.png'
					) );
					$thb_modal_container->addField( $thb_field );

					$thb_field = new THB_CheckboxField( 'show_images_count' );
						$thb_field->setLabel( __( 'Show images count', 'thb_text_domain' ) );
					$thb_modal_container->addField($thb_field);

					$thb_field = new THB_SelectField( 'featured_image_size' );
					$thb_field->setLabel( __( 'Featured image size', 'thb_text_domain' ) );
					$thb_field->setOptions( array(
						'medium'             => __( 'Medium', 'thb_text_domain' ),
						'medium-cropped'     => __( 'Medium cropped', 'thb_text_domain' ),
						'grid-large'         => __( 'Small', 'thb_text_domain' ),
						'grid-large-cropped' => __( 'Small squared', 'thb_text_domain' ),
						'large'              => __( 'Large', 'thb_text_domain' ),
						// 'large-cropped'      => __( 'Large cropped', 'thb_text_domain' ),

						'full'               => __( 'Full', 'thb_text_domain' ),
					) );
					$thb_modal_container->addField( $thb_field );

					$thb_field = new THB_CheckboxField( 'enable_slideviews' );
						$thb_field->setLabel( __( 'Enable slideviews', 'thb_text_domain' ) );
						$thb_field->setHelp( __( 'By checking this, you enable the iPhoto-like effect for the album on mouse over. Only applies if a cropped/squared height image size is being used.', 'thb_text_domain' ) );
					$thb_modal_container->addField( $thb_field );

			$this->addModal( $thb_modal );
		}

		/**
		 * The classes to be added to the block element on frontend.
		 *
		 * @param array $block_data
		 * @return array
		 */
		public function blockClasses( $block_data ) {
			$block_classes = array();
			$featured_image = thb_get_featured_image( 'full', $block_data['album_select'] );
			$block_classes[] = 'thb-block-type-element';

			// if ( empty( $featured_image ) ) {
			// 	$block_data['data_position'] = 'thb-desc-outside';
			// }

			if ( isset( $block_data['data_position'] ) ) {
				$block_classes[] = $block_data['data_position'];
			}


			return array_merge( $block_classes, parent::blockClasses( $block_data ) );
		}

	}

	thb_builder_instance()->addBlock( new THB_AlbumBlock() );
}