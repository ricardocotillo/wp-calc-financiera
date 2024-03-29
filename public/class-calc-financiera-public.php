<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://portafolio.cotillo.tech
 * @since      1.0.0
 *
 * @package    Calc_Financiera
 * @subpackage Calc_Financiera/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Calc_Financiera
 * @subpackage Calc_Financiera/public
 * @author     Ricardo Cotillo <rcotillo@cotillo.tech>
 */
class Calc_Financiera_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'dist/css/app.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name . 'wp_vue1', plugin_dir_url( __FILE__ ) . 'dist/js/app.js', null, $this->version, true );
		wp_enqueue_script( $this->plugin_name . 'wp_vue2', plugin_dir_url( __FILE__ ) . 'dist/js/chunk-vendors.js', null, $this->version, true );
		wp_localize_script( $this->plugin_name . 'wp_vue1', 'wp_ajax', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'_nonce' => wp_create_nonce( 'calc-financiera-ver=1.0.7' ),
		) );
	}

	/**
	 * Defer JavaScript files for the public-facing side of the site.
	 *
	 * @since    1.0.5
	 */
	public function script_defer() {

	}

	public function shortcode_prestamo( $atts = array() ) {
		$options = get_option( $this->plugin_name . '-options');
		$atts = shortcode_atts(array(
			'direccion' => 'horizontal',
			'cuotas_fijas_tea' => 0.36,
			'solo_intereses_tasa' => 0.025,
			'prestamo_puente_tasa' => 0.032,
		), $atts);
		
		$settings = array_merge($options, $atts);
		$settings['tipo'] = 'prestamo';
		$json_settings = json_encode($settings);
		
		return '<div id="app" data-settings=' . $json_settings . ' ></div>';
	}

	public function shortcode_inversion( $atts = array() ) {
		$options = get_option( $this->plugin_name . '-options');
		$atts = shortcode_atts(array(
			'direccion' => 'horizontal',
			'prestamo_tea' => 0.36,
			'factoring_tea' => 0.39,
		), $atts);

		$settings = array_merge($options, $atts);
		$settings['tipo'] = 'inversion';
		$json_settings = json_encode($settings);

		return '<div id="app" data-settings=' . $json_settings . ' ></div>';
	}

	public function calc_ajax_solicitud() {
		$args = array(
			'post_title'	=> $_POST['nombres'] . ' ' . $_POST['apellidos'],
			'post_type' 	=> 'solicitud',
			'post_status'	=> 'publish',
		);
		$s_id = wp_insert_post($args);
		$fields_to_update = array(
			'tipo_de_solicitud',
			'nombres',
			'apellidos',
			'dni',
			'telefono1',
			'telefono2', 
			'email',
			'departamento',
			'provincia',
			'distrito',
			'tipo_de_propiedad',
			'area',
			'dueno',
			'sunarp',
			'embargo',
			'hipoteca',
		);
		foreach ($fields_to_update as $f) {
			update_post_meta($s_id, $this->plugin_name . $f, $_POST[$f]);
		}
		die( json_encode( array('status' => 201) ) );
	}

	public function array_to_xlsx( $array ) {

		$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->fromArray($array, NULL, 'A1');
		$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        if (count($array) == 0) {
            return null;
        }

        ob_start();

        $df = fopen("php://output", 'w');

        $writer->save($df);

        fclose($df);

        return ob_get_clean();

	}
	
	public function set_csv_header( $extra_file_name = 'csv_export' ) {

        $sitename = sanitize_key( get_bloginfo( 'name' ) );

        if ( ! empty( $sitename ) ) {
            $sitename .= '.';
        }

        $filename = $sitename . $extra_file_name . '.' . date( 'Y-m-d-H-i-s' ) . '.xlsx';
        $now = gmdate( "D, d M Y H:i:s" );

        // disable caching
        header( "Expires: Tue, 01 Jan 2000 00:00:00 GMT" );
        header( "Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate" );
        header( "Last-Modified: ". $now . " GMT" );
        header( "Content-Description: File Transfer" );
        header( "Pragma: no-cache" );

        // force download
        header( "Content-Type: application/force-download" );
        header( "Content-Type: application/octet-stream" );
        header( "Content-Type: application/download" );

        header( "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header( "Content-Disposition: attachment; filename=" . $filename );

	}

	public function csv_export() {
		$tipo_de_solicitud = $_GET['tipo_de_solicitud'];
		$desde = $_GET['desde'];
		$hasta = $_GET['hasta'];
		$tipo = array( 'Casa', 'Dpto', 'Terreno', 'Local', 'Edificio' );
		$sino = array('Si', 'No', 'No sé');
		$dueno = array( 'Sólo yo', 'Otras personas y yo', 'Otras personas' );

		$this->set_csv_header( 'Calc-Financiera Solicitudes' );

        /**
         * PROCESS YOUR VALUES EXAMPLE
         */
        // Add header to csv
        $header_values;

		if ($tipo_de_solicitud == 'prestamo') {
			$header_values = array(
				array(
					'Tipo de solicitud',
					'Nombres',
					'Apellidos',
					'DNI',
					'Teléfono',
					'Teléfono 2',
					'Email',
					'Departamento',
					'Provincia',
					'Distrito',
					'Tipo de propiedad',
					'Área de propiedad (m²)',
					'Dueño de propiedad',
					'¿La propiedad está inscrita en SUNARP?',
					'¿Cuenta con un embargo vigente?',
					'¿Cuenta con una hipoteca vigente?',
				)
			);
		} else {
			$header_values = array(
				array(
					'Tipo de solicitud',
					'Nombres',
					'Apellidos',
					'DNI',
					'Teléfono',
					'Teléfono 2',
					'Email',
				),
			);
		}

        // Get only IDs from all test post type sort by title.
        $args = array(
			'posts_per_page'	=> -1,
			'post_status' 		=> 'publish',
            'post_type'        	=> 'solicitud',
			'order'            	=> 'ASC',
			'meta_query'        => array(
				array(
					'key'	=> $this->plugin_name . 'tipo_de_solicitud',
					'value'	=> $tipo_de_solicitud,
				)
			),
			'date_query'		=> array(
				array(
					'after'     => $desde,
					'before'    => $hasta,
					'inclusive' => true,
				),
			),
		);

		$solicitudes = get_posts( $args );

        // Loop IDs and get valuses what we want.
        $solicitudes_values = array();
        foreach ( $solicitudes as $solicitud ) {
			if ($tipo_de_solicitud == 'prestamo') {
				$values1 = array(
					$solicitud->{$this->plugin_name . 'tipo_de_solicitud'},
					$solicitud->{$this->plugin_name . 'nombres'},
					$solicitud->{$this->plugin_name . 'apellidos'},
					$solicitud->{$this->plugin_name . 'dni'},
					$solicitud->{$this->plugin_name . 'telefono1'},
					$solicitud->{$this->plugin_name . 'telefono2'},
					$solicitud->{$this->plugin_name . 'email'},
					$solicitud->{$this->plugin_name . 'departamento'},
					$solicitud->{$this->plugin_name . 'provincia'},
					$solicitud->{$this->plugin_name . 'distrito'},
					$tipo[(int)$solicitud->{$this->plugin_name . 'tipo_de_propiedad'}] ? $tipo[(int)$solicitud->{$this->plugin_name . 'tipo_de_propiedad'}] : 'No especificado',
					$solicitud->{$this->plugin_name . 'area'},
					$dueno[(int)$solicitud->{$this->plugin_name . 'dueno'}] ? $dueno[(int)$solicitud->{$this->plugin_name . 'dueno'}] : 'No especificado',
					$sino[(int)$solicitud->{$this->plugin_name . 'sunarp'}] ? $sino[(int)$solicitud->{$this->plugin_name . 'sunarp'}] : 'No especificado',
					$sino[(int)$solicitud->{$this->plugin_name . 'embargo'}] ? $sino[(int)$solicitud->{$this->plugin_name . 'embargo'}] : 'No especificado',
					$sino[(int)$solicitud->{$this->plugin_name . 'hipoteca'}] ? $sino[(int)$solicitud->{$this->plugin_name . 'hipoteca'}] : 'No especificado',
				);
				array_push($solicitudes_values, $values1);
			} else {
				$values2 = array(
					$solicitud->{$this->plugin_name . 'tipo_de_solicitud'},
					$solicitud->{$this->plugin_name . 'nombres'},
					$solicitud->{$this->plugin_name . 'apellidos'},
					$solicitud->{$this->plugin_name . 'dni'},
					$solicitud->{$this->plugin_name . 'telefono1'},
					$solicitud->{$this->plugin_name . 'telefono2'},
					$solicitud->{$this->plugin_name . 'email'},
				);
				array_push($solicitudes_values, $values2);
			}
			
		}

        // // Merge them together.
        $fields = array_merge( $header_values, $solicitudes_values );
        /**
         * END PROCESS YOUR VALUES EXAMPLE
         */

        die($this->array_to_xlsx( $fields ));
    }

}
