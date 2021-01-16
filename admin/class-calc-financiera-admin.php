<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://portafolio.cotillo.tech
 * @since      1.0.0
 *
 * @package    Calc_Financiera
 * @subpackage Calc_Financiera/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Calc_Financiera
 * @subpackage Calc_Financiera/admin
 * @author     Ricardo Cotillo <rcotillo@cotillo.tech>
 */
class Calc_Financiera_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Calc_Financiera_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Calc_Financiera_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/calc-financiera-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Calc_Financiera_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Calc_Financiera_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/calc-financiera-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function create_menu() {

		/*
		* To add a metabox.
		* This normally go to your functions.php or another hook
		*/
		$config_metabox = array(
	
			/*
			* METABOX
			*/
			'type'              => 'metabox',                       // Required, menu or metabox
			'id'                => $this->plugin_name . '-meta',    // Required, meta box id, unique, for saving meta: id[field-id]
			// 'post_types'        => array( 'page' ),                 // Post types to display meta box
			'post_types'        => array( 'solicitud' ),         // Post types to display meta box
			'context'           => 'advanced',
			'priority'          => 'default',
			'title'             => 'Datos del solicitante',                  // The name of this page
			'capability'        => 'edit_posts',                    // The capability needed to view the page
			'tabbed'            => false,
	
		);
	
		$fields[] = array(
			'name'   => 'datos_solicitante',
			'title'  => 'Datos del solicitante',
			'fields' => array(
	
				/**
				 * Available fields:
				 * - ACE field
				 * - attached
				 * - backup
				 * - button
				 * - botton_bar
				 * - card
				 * - checkbox
				 * - color
				 * - content
				 * - date
				 * - editor
				 * - group
				 * - hidden
				 * - image
				 * - image_select
				 * - meta
				 * - notice
				 * - number
				 * - password
				 * - radio
				 * - range
				 * - select
				 * - switcher
				 * - tap_list
				 * - text
				 * - textarea
				 * - upload
				 * - video mp4/oembed
				 *
				 * Add your fields, eg.:
				 */
	
				array(
					'id'	=> 'nombres',
					'type'	=> 'text',
					'title'	=> 'Nombres',
					'class'	=> 'text-class',
				),
	
				array(
					'id'     => 'apellidos',
					'type'   => 'text',
					'title'  => 'Apellidos',
				),
	
	
				array(
					'id'     => 'dni',
					'type'   => 'text',
					'title'  => 'DNI',
				),
	
				array(
					'id'     => 'telefono1',
					'type'   => 'text',
					'title'  => 'Teléfono',
				),
	
				array(
					'id'     => 'telefono2',
					'type'   => 'text',
					'title'  => 'Teléfono 2',
				),
	
				array(
					'id'    => 'email',
					'type'  => 'text',
					'title' => 'Email',
				),
	
				array(
					'id'	=> 'departamento',
					'type'	=> 'text',
					'title'	=> 'Departamento',
				),
				array(
					'id'	=> 'provincia',
					'type'	=> 'text',
					'title'	=> 'Provincia',
				),
				array(
					'id'	=> 'distrito',
					'type'	=> 'text',
					'title'	=> 'Distrito',
				),
				array(
					'id'	=> 'tipo_de_propiedad',
					'type'	=> 'text',
					'title'	=> 'Tipo de propiedad',
				),
				array(
					'id'	=> 'area',
					'type'	=> 'text',
					'title'	=> 'Área de la propiedad (m²)',
				),
				array(
					'id'	=> 'dueno',
					'type'	=> 'text',
					'title'	=> 'Dueño de la propiedad',
				),
				array(
					'id'	=> 'sunarp',
					'type'	=> 'text',
					'title'	=> '¿La propiedad está inscrita en SUNARP',
				),
				array(
					'id'	=> 'embargo',
					'type'	=> 'text',
					'title'	=> '¿Cuenta con un embargo vigente?',
				),
				array(
					'id'	=> 'hipoteca',
					'type'	=> 'text',
					'title'	=> '¿Cuenta con una hipoteca vigente?',
				),
			),
		);
	
		/**
		 * Second Tab
		 */
		// $fields[] = array(
		// 	'name'   => 'second',
		// 	'title'  => 'Second',
		// 	'icon'   => 'dashicons-portfolio',
		// 	'fields' => array(
	
		// 		array(
		// 			'type'    => 'content_second',
		// 			'content' => 'Second Section',
	
		// 		),
	
		// 	)
		// );
	
		/**
		 * Third Tab
		 */
		// $fields[] = array(
		// 	'name'   => 'third',
		// 	'title'  => 'Third',
		// 	'icon'   => 'dashicons-portfolio',
		// 	'fields' => array(
	
		// 		array(
		// 			'type'    => 'content_third',
		// 			'content' => 'Third Section',
	
		// 		),
	
		// 	)
		// );
	
		/**
		 * instantiate your admin page
		 */
		$metabox_panel = new Exopite_Simple_Options_Framework( $config_metabox, $fields );
	
	}

}
