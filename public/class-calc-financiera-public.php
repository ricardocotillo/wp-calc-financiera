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
		global $post;

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

		if (has_shortcode($post->post_content, 'calculadora-financiera')) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'resources/dist/css/app.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		global $post;
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
		
		if (has_shortcode($post->post_content, 'calculadora-financiera')) {
			wp_enqueue_script( $this->plugin_name . 'wp_vue1', plugin_dir_url( __FILE__ ) . 'resources/dist/js/app.js', null, $this->version, true );
			wp_enqueue_script( $this->plugin_name . 'wp_vue2', plugin_dir_url( __FILE__ ) . 'resources/dist/js/chunk-vendors.js', null, $this->version, true );
			wp_localize_script( $this->plugin_name . 'wp_vue1', 'wp_ajax', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				/**
				 * Create nonce for security.
				 *
				 * @link https://codex.wordpress.org/Function_Reference/wp_create_nonce
				 */
				'_nonce' => wp_create_nonce( 'calc-financiera-ver=1.0' ),
			) );
		}

	}

	/**
	 * Register Shortcode for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function dotiavatar_function() {
		return '<div id="app"></div>';
	}
	   
	public function calc_ajax_solicitud() {
		$args = array(
			'post_title'	=> $_POST['nombres'] . ' ' . $_POST['apellidos'],
			'post_type' 	=> 'solicitud',
			'post_status'	=> 'publish',
		);
		$s_id = wp_insert_post($args);
		update_post_meta($s_id, $this->plugin_name . '-meta', $_POST);
		$meta = get_post_meta( $s_id, $this->plugin_name . '-meta', false );
		die( json_encode( $meta[0] ) );
	
	}

	public function array_to_csv( $array ) {

        if (count($array) == 0) {
            return null;
        }

        ob_start();

        $df = fopen("php://output", 'w');

        foreach ( $array as $row ) {
            fputcsv( $df, $row );
        }

        fclose($df);

        return ob_get_clean();

	}
	
	public function set_csv_header( $extra_file_name = 'csv_export' ) {

        $sitename = sanitize_key( get_bloginfo( 'name' ) );

        if ( ! empty( $sitename ) ) {
            $sitename .= '.';
        }

        $filename = $sitename . $extra_file_name . '.' . date( 'Y-m-d-H-i-s' ) . '.csv';
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

        header( "Content-Disposition: attachment; filename=" . $filename );
        header( "Content-Transfer-Encoding: binary" );
        header( "Content-Type: text/csv; charset=" . get_option( 'blog_charset' ), true );

	}

	public function csv_export() {

        $this->set_csv_header( 'Calc-Financiera Solicitudes' );

        /**
         * PROCESS YOUR VALUES EXAMPLE
         */
        // Add header to csv
        $header_values = array(
            array(
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
			),
        );

        // Get only IDs from all test post type sort by title.
        $args = array(
			'posts_per_page'	=> -1,
			'post_status' 		=> 'publish',
            'post_type'        	=> 'solicitud',
	        'order'            	=> 'ASC',
        );
        $solicitudes = get_posts( $args );

        // Loop IDs and get valuses what we want.
        $solicitudes_values = array();
        foreach ( $solicitudes as $solicitud ) {
			$solicitud_meta = get_post_meta( $solicitud->ID, $this->plugin_name . '-meta', false );
			if ($solicitud_meta) {
				$solicitud_meta = $solicitud_meta[0];
				$tipo_de_propiedad;
				$dueno;
				$sunarp;
				$embargo;
				$hipoteca;
				if (isset($solicitud_meta['tipo_de_propiedad'])) {
					switch ($solicitud_meta['tipo_de_propiedad']) {
						case 0:
							$tipo_de_propiedad = 'Casa';
							break;
						case 1:
							$tipo_de_propiedad = 'Dpto';
							break;
						case 2:
							$tipo_de_propiedad = 'Terreno';
							break;
						case 3:
							$tipo_de_propiedad = 'Local';
							break;
						case 4:
							$tipo_de_propiedad = 'Edificio';
							break;
						default:
							$tipo_de_propiedad = 'No especificado';
							break;
					}
				}
				if (isset($solicitud_meta['dueno'])) {
					switch ($solicitud_meta['dueno']) {
						case 0:
							$dueno = 'Solo yo';
							break;
						case 1:
							$dueno = 'Otras personas y yo';
							break;
						case 2:
							$dueno = 'Otras personas';
						default:
							$dueno = 'No especificado';
							break;
					}
				}

				if (isset($solicitud_meta['sunarp'])) {
					switch ($solicitud_meta['sunarp']) {
						case 0:
							$sunarp = 'Si';
							break;
						case 1:
							$sunarp = 'No';
							break;
						default:
							$sunarp = 'No sé';
							break;
					}
				}

				if (isset($solicitud_meta['embargo'])) {
					switch ($solicitud_meta['embargo']) {
						case 0:
							$embargo = 'Si';
							break;
						case 1:
							$embargo = 'No';
							break;
						default:
							$embargo = 'No sé';
							break;
					}
				}

				if (isset($solicitud_meta['hipoteca'])) {
					switch ($solicitud_meta['hipoteca']) {
						case 0:
							$hipoteca = 'Si';
							break;
						case 1:
							$hipoteca = 'No';
							break;
						default:
							$hipoteca = 'No sé';
							break;
					}
				}

				array_push($solicitudes_values, array(
					$solicitud_meta['nombres'] ? $solicitud_meta['nombres'] : '',
					$solicitud_meta['apellidos'] ? $solicitud_meta['apellidos'] : '',
					$solicitud_meta['dni'] ? $solicitud_meta['dni'] : '',
					$solicitud_meta['telefono1'] ? $solicitud_meta['telefono1'] : '',
					$solicitud_meta['telefono2'] ? $solicitud_meta['telefono2'] : '',
					$solicitud_meta['email'] ? $solicitud_meta['email'] : '',
					$solicitud_meta['departamento'] ? $solicitud_meta['departamento'] : '',
					$solicitud_meta['provincia'] ? $solicitud_meta['provincia'] : '',
					$solicitud_meta['distrito'] ? $solicitud_meta['distrito'] : '',
					$tipo_de_propiedad,
					$solicitud_meta['area'] ? $solicitud_meta['area'] : '',
					$dueno,
					$sunarp,
					$embargo,
					$hipoteca,
				));
			}
        }

        // // Merge them together.
        $fields = array_merge( $header_values, $solicitudes_values );
        /**
         * END PROCESS YOUR VALUES EXAMPLE
         */

        die($this->array_to_csv( $fields ));
    }

}
