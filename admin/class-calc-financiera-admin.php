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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/calc-financiera-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/calc-financiera-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_export_button( $which ) {
		global $typenow;
  
		if ( 'solicitud' === $typenow && 'top' === $which ) {
			?>
			<a href="<?php echo admin_url( 'admin-post.php?action=csv_export' ); ?>" target="_blank" class="button button-primary"><?php _e('Exportar Solicitudes'); ?></a>
			<?php
		}
	}

	// public function create_option() {

	// 	$cmb_options = new_cmb2_box( array(
	// 		'type' 			=> 'menu',
	// 		'id'           	=> $this->plugin_name . '-option',
	// 		'title'        	=> 'Calc config',
	// 		'object_types'	=> array( 'options-page' ),
	// 		'option_key'    => 'rc' . $this->plugin_name . '-option', // The option key and admin menu page slug.
	// 		'icon_url'      => 'dashicons-admin-generic', // Menu icon.
	// 		'capability'    => 'manage_options', // Capability required to view this options page.
	// 		'position'      => 3, // Menu position.
	// 		'save_button'   => 'Save',
	// 	) );

	// 	$cmb_options->add_field( array(
	// 		'name' 				=> 'Dirección',
	// 		'desc' 				=> 'Dirección del layout de la calculadora',
	// 		'id'   				=> 'direccion',
	// 		'type' 				=> 'select',
	// 		'show_option_none'	=> false,
	// 		'default'			=> 0,
	// 		'options'          	=> array('Horizontal', 'Vertical'),
	// 	) );
	// }

	public function create_metabox() {

		$cmb = new_cmb2_box( array(
			'id'            => $this->plugin_name . '-meta',
			'title'         => 'Datos del solicitante',
			'object_types'  => array( 'solicitud', ), // Post type
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // Keep the metabox closed by default
		) );

		$cmb->add_field( array(
			'name'       => 'Nombres',
			'id'         => $this->plugin_name . 'nombres',
			'type'       => 'text',
		) );

		$cmb->add_field( array(
			'id'     => $this->plugin_name . 'apellidos',
			'type'   => 'text',
			'name'  => 'Apellidos',
		) );

		$cmb->add_field( array(
			'id'     => $this->plugin_name . 'dni',
			'type'   => 'text',
			'name'  => 'DNI',
		) );

		$cmb->add_field( array(
			'id'     => $this->plugin_name . 'telefono1',
			'type'   => 'text',
			'name'  => 'Teléfono',
		) );

		$cmb->add_field( array(
			'id'     => $this->plugin_name . 'telefono2',
			'type'   => 'text',
			'name'  => 'Teléfono 2',
		) );

		$cmb->add_field( array(
			'id'     => $this->plugin_name . 'email',
			'type'   => 'text_email',
			'name'  => 'Email',
		) );

		$cmb->add_field( array(
			'id'     => $this->plugin_name . 'departamento',
			'type'   => 'text',
			'name'  => 'Departamento',
		) );

		$cmb->add_field( array(
			'id'     => $this->plugin_name . 'provincia',
			'type'   => 'text',
			'name'  => 'Provincia',
		) );

		$cmb->add_field( array(
			'id'     => $this->plugin_name . 'distrito',
			'type'   => 'text',
			'name'  => 'Distrito',
		) );

		$cmb->add_field( array(
			'name'             => 'Tipo de propiedad',
			'id'               => $this->plugin_name . 'tipo_de_propiedad',
			'type'             => 'select',
			'show_option_none' => true,
			'options'          => array( 'Casa', 'Dpto', 'Terreno', 'Local', 'Edificio' ),
		) );

		$cmb->add_field( array(
			'id'     => $this->plugin_name . 'area',
			'type'   => 'text',
			'name'  => 'Área',
		) );

		$cmb->add_field( array(
			'name'             => 'Dueño',
			'id'               => $this->plugin_name . 'dueno',
			'type'             => 'select',
			'show_option_none' => true,
			'options'          => array( 'Sólo yo', 'Otras personas y yo', 'Otras personas' ),
		) );
		$cmb->add_field( array(
			'name'             => '¿La propiedad está inscrita en SUNARP?',
			'id'               => $this->plugin_name . 'sunarp',
			'type'             => 'select',
			'show_option_none' => true,
			'options'          => array( 'Si', 'No' ),
		) );
		$cmb->add_field( array(
			'name'             => '¿Cuenta con un embargo vigente?',
			'id'               => $this->plugin_name . 'embargo',
			'type'             => 'select',
			'show_option_none' => true,
			'options'          => array( 'Si', 'No', 'No sé' ),
		) );
		$cmb->add_field( array(
			'name'             => '¿Cuenta con una hipoteca vigente?',
			'id'               => $this->plugin_name . 'hipoteca',
			'type'             => 'select',
			'show_option_none' => true,
			'options'          => array( 'Si', 'No', 'No sé' ),
		) );
	
	}

}
