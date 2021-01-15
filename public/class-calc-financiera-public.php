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
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/calc-financiera-public.css', array(), $this->version, 'all' );
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
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/calc-financiera-public.js', array( 'jquery' ), $this->version, false );
		}

	}

	/**
	 * Register Shortcode for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function dotiavatar_function() {
		return 
		'<div id="calculadora-financiera">
			<div class="center">
				<div class="property-card">
					<div class="tipo-de-inversion">
						<h6>Tipo de inversión</h6>
						<div class="tipos">
							<div class="tipo">
								<input name="tipo" value="0" type="radio" checked />
								<label><strong>Préstamo con garatía hipotecaria</strong></label>
							</div>
							<div class="tipo">
								<input name="tipo" value="1" type="radio" />
								<label><strong>Factoring</strong></label>
							</div>
						</div>
					</div>
					<div class="amount">
						<h6>Monto de inversión</h6>
						<div id="amount">
							<div id="remove" class="amount-btn cursor-pointer">-</div>
							<input data-min="20000" data-step="100" data-value="1000" value="20000"  id="amount-input">
							<div id="add" class="amount-btn cursor-pointer">+</div>
						</div>
					</div>
					<div class="periodo">
						<h6>Período de inversión</h6>
						<select>
							<option selected value="1">1 año</option>
							<option value="2">2 años</option>
							<option value="3">3 años</option>
							<option value="4">4 años</option>
						</select>
					</div>
					<div style="width: 20px"></div>
					<div class="ganancia">
						<h6>En 1 año ganarías</h6>
						<h3><strong>S/ 23</strong></h3>
						<button class="btn-register">Regístrate</button>
					</div>
				</div>
			</div>
	  	</div>';
   	}

}