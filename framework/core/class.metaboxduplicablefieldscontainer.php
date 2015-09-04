<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

/**
 * Duplicable Metabox Fields Container class.
 *
 * This class is entitled to manage a duplicable metabox container for input
 * fields.
 *
 * ---
 *
 * The Happy Framework: WordPress Development Framework
 * Copyright 2014, Andrea Gandino & Simone Maranzana
 *
 * Licensed under The MIT License
 * Redistribuitions of files must retain the above copyright notice.
 *
 * @package Core
 * @author The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright 2014, Andrea Gandino & Simone Maranzana
 * @link http://
 * @since The Happy Framework v 2.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
if( !class_exists('THB_MetaboxDuplicableFieldsContainer') ) {
	class THB_MetaboxDuplicableFieldsContainer extends THB_FieldsContainer {

		/**
		 * The duplicable field controls.
		 *
		 * @var array
		 */
		protected $_controls = array();

		/**
		 * True if the fields elements should be sortable.
		 *
		 * @var boolean
		 */
		protected $_isSortable = false;

		/**
		 * True if the fields elements should be sortable using a handle.
		 *
		 * @var boolean
		 */
		protected $_withHandle = false;

		/**
		 * True if the fields elements are to be prepended in the container.
		 *
		 * @var boolean
		 */
		protected $_prependable = false;

		/**
		 * The fields container template.
		 *
		 * @var string
		 */
		protected $_template = 'admin/metabox_fields_container_duplicable';

		/**
		 * Constructor
		 *
		 * @param string $title The fields container title.
		 * @param string $slug The fields container slug.
		 **/
		public function __construct( $title, $slug )
		{
			parent::__construct( $title, $slug );
		}

		/**
		 * Add a duplicable field control.
		 *
		 * @param string $label The control label.
		 * @param string $id The control id.
		 * @param array $data The control data attributes.
		 * @return void
		 */
		public function addControl( $label, $id='', $icon='', $data=array() )
		{
			if( empty( $id ) ) {
				$id = 'new';
			}

			$data['tpl'] = $id;

			$this->_controls[$id] = array(
				'label' => $label,
				'icon' => $icon,
				'data' => $data
			);
		}

		/**
		 * Get the duplicable field controls.
		 *
		 * @return array
		 */
		public function getControls()
		{
			return $this->_controls;
		}

		/**
		 * Get the duplicable field model.
		 *
		 * @return THB_Field
		 */
		public function getField( $name = null )
		{
			return $this->_fields->getFirst();
		}

		/**
		 * Get the items from the duplicable table
		 *
		 * @return array
		 */
		public function getItems()
		{
			global $post;

			$post_id = thb_input_get( 'post', 'absint', (int) absint( $post->ID ) );

			$items = thb_duplicable_get( $this->getField()->getName(), $post_id );

			$fields = array();
			$field = null;

			$i = 0;
			foreach( $items as $item ) {
				$field = clone $this->getField();
				$field->setIndex( $i );

				$meta = array();
				if( !empty( $item['meta'] ) ) {
					$meta = $item['meta'];
				}

				$field->setContext( THB_Field::Free );
				$field->setValue( $item['value'] );
				$field->setMeta( $meta );

				$fields[] = $field;
				$i++;;
			}

			return $fields;
		}

		/**
		 * Return true when asked if duplicable.
		 *
		 * @return boolean
		 */
		public function isDuplicable()
		{
			return true;
		}

		/**
		 * Check if the fields are sortable.
		 *
		 * @return boolean
		 */
		public function isSortable()
		{
			return $this->_isSortable;
		}

		/**
		 * Check if the fields are sortable with an handle.
		 *
		 * @return boolean
		 */
		public function hasHandle()
		{
			return $this->_withHandle;
		}

		/**
		 * Check if the fields are prependable.
		 *
		 * @return boolean
		 */
		public function isPrependable()
		{
			return $this->_prependable;
		}

		/**
		 * Render the fields container.
		 */
		public function render()
		{
			// $intro_text = new THB_Template( THB_TEMPLATES_DIR . '/admin/introtext', array(
			// 	'intro_text' => $this->getIntroText()
			// ) );

			$fields_container_template = new THB_Template( THB_TEMPLATES_DIR . '/' . $this->_template, array(
				'fields_container' => $this,
				'container_intro_text' => $this->getIntroText() //$intro_text->render(true)
			) );

			$fields_container_template->render();
		}

		/**
		 * Save the fields container.
		 *
		 * @return void
		 */
		public function save()
		{
			global $post_id;

			thb_duplicable_fields_save( $this->getField(), $post_id );
		}

		/**
		 * Set the duplicable field.
		 *
		 * @param THB_Field $field The field.
		 */
		public function setField( THB_Field $field )
		{
			$field->setDuplicable();
			$field->setIndex( '#index#' );

			$this->_fields->removeAll();
			$this->_fields->insert( $field );
		}

		/**
		 * Alias for $this->setField.
		 *
		 * @param THB_Field $field The field.
		 */
		public function addField( THB_Field $field, $index = null, $context = null )
		{
			$this->setField( $field );
		}

		/**
		 * Set the fields to be sortable.
		 *
		 * @param boolean $sortable
		 * @param boolean $handle
		 */
		public function setSortable( $sortable = true, $handle = false )
		{
			$this->_isSortable = $sortable;
			$this->_withHandle = $handle;
		}

		/**
		 * Set the fields to be prependable.
		 *
		 * @param boolean $prependable
		 */
		public function setPrependable( $prependable=true )
		{
			$this->_prependable = $prependable;
		}

	}
}