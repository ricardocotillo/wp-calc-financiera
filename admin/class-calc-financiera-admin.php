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
		global $typenow;

		if ($typenow == 'solicitud') {
			wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/calc-financiera-admin.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		global $typenow;
		if ($typenow === 'solicitud') {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/calc-financiera-admin.js', array( 'jquery', 'jquery-ui-datepicker' ), $this->version, true );
		}
	}

	public function add_export_button( $which ) {
		global $typenow;
  
		if ( 'solicitud' === $typenow && 'top' === $which ) {
			$desde = date('Y-m-d', strtotime('-1 month'));
			$hasta = date('Y-m-d', strtotime('now'));
			?>
				<select id="tipo-de-solicitud" name="tipo_de_solicitud">
					<option value="prestamo" selected>Préstamo</option>
					<option value="inversion">Inversión</option>
				</select>
				<input type="text" placeholder="Desde yyyy-mm-dd" id="desde" class="custom_date" name="start_date" value="<?php echo $desde; ?>"/>
				<input type="text" placeholder="Hasta yyyy-mm-dd" id="hasta" class="custom_date" name="end_date" value="<?php echo $hasta; ?>"/>
				<a id="export-btn" href="<?php echo admin_url( 'admin-post.php?action=csv_export&tipo_de_solicitud=prestamo&desde='.$desde.'&hasta='.$hasta ); ?>" target="_blank" class="button button-primary"><?php _e('Exportar Solicitudes'); ?></a>
			<?php
		}
	}

	public function create_options() {
		$cmb_options = new_cmb2_box( array(
			'id' 			=> $this->plugin_name . '-options',
			'title' 		=> 'Calc settings',
			'object_types'	=> array( 'options-page' ),
			'option_key'      => 'pr_services', // The option key and admin menu page slug.
			'icon_url'        => 'dashicons-admin-generic', // Menu icon.
			'capability'      => 'edit_posts', // Capability required to view this options page.
			'position'        => 3, // Menu position.
			'save_button'     => 'Save',
		) );

		$cmb_options->add_field( array(
			'name'    => 'Primary Color',
			'id'      => $this->plugin_name . '-primary_color',
			'type'    => 'colorpicker',
			'default' => '#ffffff',
			'options' => array(
			    'alpha' => true, // Make this a rgba color picker.
			),
		) );

		$cmb_options->add_field( array(
			'name'    => 'Secondary Color',
			'id'      => $this->plugin_name . '-secondary_color',
			'type'    => 'colorpicker',
			'default' => '#ffffff',
			'options' => array(
			    'alpha' => true, // Make this a rgba color picker.
			),
		) );
	}

	public function create_metabox() {

		$cmb = new_cmb2_box( array(
			'id'            => $this->plugin_name . '-meta',
			'title'         => 'Datos del solicitante',
			'object_types'  => array( 'solicitud', ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true,
		) );

		$cmb->add_field( array(
			'name'		=> 'Tipo de solicitud',
			'id' 		=> $this->plugin_name . 'tipo_de_solicitud',
			'type'		=> 'select',
			'options'	=> array(
				'prestamo' => 'Préstamo', 
				'inversion' => 'Inversíon',
			),
		));

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
