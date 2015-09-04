<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

/**
 * Multiple select field class.
 *
 * This class is entitled to manage the option/meta multiple select field types.
 *
 * ---
 *
 * The Happy Framework: WordPress Development Framework
 * Copyright 2014, Andrea Gandino & Simone Maranzana
 *
 * Licensed under The MIT License
 * Redistribuitions of files must retain the above copyright notice.
 *
 * @package Core\Fields
 * @author The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright 2014, Andrea Gandino & Simone Maranzana
 * @link http://
 * @since The Happy Framework v 2.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
if ( ! class_exists('THB_MultipleSelectField') ) {
	class THB_MultipleSelectField extends THB_SelectField {

		/**
		 * Constructor
		 *
		 * @param string $name The field name.
		 * @param integer $context The field context.
		 **/
		public function __construct( $name, $context = null )
		{
			parent::__construct( $name, $context );

			$this->setMultiple();
			$this->_data['select_class'] = 'thb-selectize';
			$this->_data['select_attrs'] = array( 'multiple' => 'multiple' );
		}

	}
}