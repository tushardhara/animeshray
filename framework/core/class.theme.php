<?php if( !defined('THB_FRAMEWORK_NAME') ) exit('No direct script access allowed.');

/**
 * Theme class.
 *
 * This class is entitled to manage the theme instance.
 * The theme object is the entry point to the system, to which all the theme
 * components are attached, both backend and frontend.
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
if( !class_exists('THB_Theme') ) {
	class THB_Theme {

		/**
		 * The theme instance.
		 *
		 * @var THB_Theme
		 **/
		private static $_instance = null;

		/**
		 * Get the theme instance.
		 *
		 * @return THB_Theme
		 **/
		public static function getInstance()
		{
			if( self::$_instance == null ) {
				self::$_instance = new THB_Theme();
			}

			return self::$_instance;
		}


		// -------------------------------------------------------------------------


		/**
		 * The theme admin interface.
		 *
		 * @var THB_Admin
		 */
		private $_admin;

		/**
		 * The theme configuration.
		 *
		 * @var array
		 */
		private $_config = array();

		/**
		 * The theme customization object.
		 *
		 * @var THB_Customizer
		 */
		private $customizer = null;

		/**
		 * The theme default language.
		 *
		 * @var string
		 */
		private $_defaultLanguage = 'en_US';

		/**
		 * The theme frontend.
		 *
		 * @var THB_Frontend
		 */
		private $_frontend;

		/**
		 * The theme language.
		 *
		 * @var string
		 */
		private $_language;

		/**
		 * The theme options.
		 *
		 * @var array
		 */
		private $_options = array();

		/**
		 * The theme post types.
		 *
		 * @var array
		 */
		private $_postTypes = array();

		/**
		 * The theme sidebars.
		 *
		 * @var array
		 */
		private $_sidebars = array();

		/**
		 * Constructor
		 *
		 */
		public function __construct()
		{
			$this->_admin = new THB_Admin();
			$this->_loadOptions();
			$this->_frontend = new THB_Frontend();
			$this->_loadLanguage();

			/**
			 * Add default post types
			 */
			$this->addPostType( new THB_PostType('post') );
			$this->addPostType( new THB_PostType('page') );
		}

		/**
		 * Add support for the post type formats.
		 *
		 * @return void
		 */
		private function addPostFormatsSupport()
		{
			foreach( $this->_postTypes as $postType ) {
				$formats = $postType->getFormats();
				add_post_type_support( $postType->getType(), 'post-formats', $formats );
			}
		}

		/**
		 * Add a post type to the theme.
		 *
		 * @param THB_PostType $postType
		 * @return void
		 */
		public function addPostType( THB_PostType $postType )
		{
			$this->_postTypes[] = $postType;
		}

		/**
		 * Add a sidebar to the theme.
		 *
		 * @param string $name The sidebar name.
		 * @param string $id The sidebar id.
		 * @param string $desc The sidebar description.
		 * @return void
		 */
		public function addSidebar( $name, $id, $desc = '' )
		{
			$this->_sidebars[$id] = array(
				'name' => $name,
				'desc' => $desc
			);
		}

		/**
		 * Flush the theme rewrite rules.
		 *
		 * @return void
		 **/
		public function flushRewriteRules()
		{
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
		}

		/**
		 * Get the theme admin interface.
		 *
		 * @return THB_Admin
		 */
		public function getAdmin()
		{
			return $this->_admin;
		}

		/**
		 * Get the theme frontend.
		 *
		 * @return THB_Frontend
		 */
		public function getFrontend()
		{
			return $this->_frontend;
		}

		/**
		 * Get the theme default language.
		 *
		 * @return string
		 */
		public function getDefaultLanguage()
		{
			return $this->_defaultLanguage;
		}

		/**
		 * Get the theme language.
		 *
		 * @return string
		 */
		public function getLanguage()
		{
			return $this->_language;
		}

		/**
		 * Get the theme options.
		 *
		 * @return array
		 */
		public function getOptions()
		{
			return $this->_options;
		}

		/**
		 * Get a theme defined post type by its name.
		 *
		 * @param string $type The post type.
		 * @return THB_PostType
		 */
		public function getPostType( $type )
		{
			foreach( $this->_postTypes as $postType ) {
				if( $postType->getType() == $type ) {
					return $postType;
				}
			}

			return false;
		}

		/**
		 * Get a theme defined post types.
		 *
		 * @return THB_PostType
		 */
		public function getPostTypes()
		{
			return $this->_postTypes;
		}

		/**
		 * Get a theme defined public post types.
		 *
		 * @return THB_PostType
		 */
		public function getPublicPostTypes()
		{
			$public_post_types = array();

			foreach( $this->_postTypes as $postType ) {
				if( $postType->isPublicContent() || in_array($postType->getType(), array('post', 'page')) ) {
					$public_post_types[] = $postType;
				}
			}

			return $public_post_types;
		}

		/**
		 * Get a list of names of the currently registered taxonomies.
		 *
		 * @return array
		 */
		public function getRegisteredTaxonomies()
		{
			$taxonomies = array(
				'category',
				'post_tag'
			);

			foreach( $this->_postTypes as $postType ) {
				$taxs = $postType->getTaxonomies();

				if( !empty($taxs) ) {
					foreach( $taxs as $t ) {
						$taxonomies[] = $t->getType();
					}
				}
			}

			return $taxonomies;
		}

		/**
		 * Load the theme language.
		 *
		 * @return void
		 */
		private function _loadLanguage()
		{
			$this->_language = $this->_defaultLanguage;

			if ( defined( 'WPLANG' ) && WPLANG !== '' ) {
				$this->_language = WPLANG;
			}
		}

		/**
		 * Load a theme module.
		 *
		 * @param string $name The module name.
		 * @return void
		 */
		public function loadModule( $name, $config=array() )
		{
			$theme_config = $this->getThemeConfig();
			$module = THB_THEME_MODULES . '/' . $name . '/module.php';

			if (
				empty( $theme_config ) ||
				! isset( $theme_config['modules_to_exclude'] ) ||
				! in_array( $name, $theme_config['modules_to_exclude'] )
			) {
				extract($config);
				include $module;
			}
			else {
				wp_die( 'Impossibile caricare il modulo ' . $name );
			}

		}

		/**
		 * Read the theme configuration file.
		 *
		 * @return array
		 */
		private function getThemeConfig()
		{
			$config_file = THB_TEMPLATE_DIR . '/config.php';

			if ( file_exists( $config_file ) )  {
				return include $config_file;
			}

			return array();
		}

		/**
		 * Set a configuration key.
		 *
		 * @param string $key The configuration key.
		 * @param mixed $value The configuration value.
		 * @return void
		 */
		public function setConfig( $key, $value )
		{
			$this->_config[$key] = $value;
		}

		/**
		 * Set a configuration subkey.
		 *
		 * @param string $key The configuration key.
		 * @param string $subkey The configuration subkey.
		 * @param mixed $value The configuration value.
		 * @return void
		 */
		public function setConfigKey( $key, $subkey, $value )
		{
			if( !isset($this->_config[$key][$subkey]) ) {
				$this->_config[$key][$subkey] = null;
			}

			$this->_config[$key][$subkey] = $value;
		}

		/**
		 * Add a configuration subkey.
		 *
		 * @param string $key The configuration key.
		 * @param string $subkey The configuration subkey.
		 * @param mixed $value The configuration value.
		 * @return void
		 */
		public function addConfig( $key, $subkey, $value )
		{
			if( !isset($this->_config[$key][$subkey]) ) {
				$this->_config[$key][$subkey] = array();
			}

			$this->_config[$key][$subkey][] = $value;
		}

		/**
		 * Get a configuration key.
		 *
		 * @param string $key The configuration key.
		 * @param string $subkey The configuration subkey.
		 * @return mixed
		 */
		public function getConfig( $key, $subkey=null )
		{
			if( isset($this->_config[$key]) ) {
				if( $subkey && isset($this->_config[$key][$subkey]) ) {
					return $this->_config[$key][$subkey];
				}
				else {
					return $this->_config[$key];
				}
			}

			return false;
		}

		/**
		 * Load the theme options.
		 *
		 * @return void
		 */
		private function _loadOptions()
		{
			$options = get_option(THB_OPTIONS_KEY);
			if( !$options ) {
				$options = array();
				update_option(THB_OPTIONS_KEY, $options);
			}

			$this->_options = $options;
		}

		/**
		 * Register the theme post types.
		 *
		 * @return void
		 */
		public function registerPostTypes()
		{
			foreach( $this->_postTypes as $postType ) {
				add_action( 'add_meta_boxes', array($postType, 'registerMetaboxes') );
				add_action( 'save_post', array($postType, 'saveMetaboxes') );
			}
		}

		/**
		 * Register the theme sidebars.
		 *
		 * @return void
		 */
		public function registerSidebars()
		{
			$args = array(
				'name'          => '',
				'id'            => '',
				'description'   => '',
				'class'         => '',
				'before_widget' => '<section id="%1$s" class="thb-page-section widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<header><h1 class="widgettitle">',
				'after_title'   => '</h1></header>'
			);

			// User-created sidebars
			foreach( thb_duplicable_get( THB_DUPLICABLE_SIDEBARS ) as $sidebar ) {
				$args['name'] = $sidebar['value'];
				$args['id'] = $sidebar['meta']['uniqid'];

				register_sidebar($args);
			}

			foreach( $this->_sidebars as $id => $sidebar ) {
				$args['name'] = $sidebar['name'];
				$args['description'] = $sidebar['desc'];
				$args['id'] = $id;

				register_sidebar($args);
			}
		}

		/**
		 * Import the theme options, completely overwriting the previously
		 * saved ones.
		 *
		 * @param array $options The options to be saved.
		 * @return void
		 */
		public function importOptions( $options=array() )
		{
			$this->_options = (array) $options;
			update_option( THB_OPTIONS_KEY, $this->_options );
		}

		/**
		 * Save the theme options.
		 *
		 * @param array $options The options to be saved.
		 * @return void
		 */
		public function saveOptions( $options )
		{
			$options = (array) $options;

			$this->_options = $options + (array) $this->_options;
			update_option( THB_OPTIONS_KEY, $this->_options );
		}

		/**
		 * Set the theme customization object.
		 *
		 * @param THB_Customizer $customization The customization object.
		 */
		public function setCustomizer( THB_Customizer $customizer ) {
			$this->customizer = $customizer;

			return $this->getCustomizer();
		}

		/**
		 * Get the theme customizer.
		 *
		 * @return THB_Customizer
		 */
		public function getCustomizer() {
			return $this->customizer;
		}

		/**
		 * Run the theme.
		 *
		 * @return void
		 **/
		public function run()
		{
			// Theme supports
			add_theme_support('post-thumbnails');
			add_post_type_support('page', 'excerpt');
			// add_filter('widget_text', 'thb_do_shortcode');

			// Register the theme post types
			add_action( 'init', array($this, 'registerPostTypes'), 10 );

			// Add post formats support
			add_theme_support( 'post-formats', $this->getPostType('post')->getFormats() );

			// Add support for automatic feed links
			add_theme_support( 'automatic-feed-links' );

			// Add support for custom editor style
			add_editor_style();

			// Register sidebars
			add_action( 'widgets_init', array( $this, 'registerSidebars' ) );

			// Run the admin interface
			$this->_admin->run();

			// Run the frontend
			$this->_frontend->run();
		}

	}
}