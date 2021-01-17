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
					'id'		=> 'tipo_de_propiedad',
					'type'		=> 'select',
					'title'		=> 'Tipo de propiedad',
					'options'	=> array( 'Casa', 'Dpto', 'Terreno', 'Local', 'Edificio' ),
				),
				array(
					'id'	=> 'area',
					'type'	=> 'text',
					'title'	=> 'Área de la propiedad (m²)',
				),
				array(
					'id'		=> 'dueno',
					'type'		=> 'select',
					'title'		=> 'Dueño de la propiedad',
					'options'	=> array( 'Sólo yo', 'Otras personas y yo', 'Otras personas' ),
				),
				array(
					'id'		=> 'sunarp',
					'type'		=> 'select',
					'title'		=> '¿La propiedad está inscrita en SUNARP?',
					'options'	=> array( 'Si', 'No' ),
				),
				array(
					'id'		=> 'embargo',
					'type'		=> 'select',
					'title'		=> '¿Cuenta con un embargo vigente?',
					'options'	=> array( 'Si', 'No', 'No sé' ),
				),
				array(
					'id'		=> 'hipoteca',
					'type'		=> 'select',
					'title'		=> '¿Cuenta con una hipoteca vigente?',
					'options'	=> array( 'Si', 'No', 'No sé' ),
				),
			),
		);
		$metabox_panel = new Exopite_Simple_Options_Framework( $config_metabox, $fields );
	
	}

}
