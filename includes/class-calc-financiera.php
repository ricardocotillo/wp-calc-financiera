<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://portafolio.cotillo.tech
 * @since      1.0.0
 *
 * @package    Calc_Financiera
 * @subpackage Calc_Financiera/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Calc_Financiera
 * @subpackage Calc_Financiera/includes
 * @author     Ricardo Cotillo <rcotillo@cotillo.tech>
 */
class Calc_Financiera {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Calc_Financiera_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CALC_FINANCIERA_VERSION' ) ) {
			$this->version = CALC_FINANCIERA_VERSION;
		} else {
			$this->version = '2.0.0';
		}
		$this->plugin_name = 'calc_financiera';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Calc_Financiera_Loader. Orchestrates the hooks of the plugin.
	 * - Calc_Financiera_i18n. Defines internationalization functionality.
	 * - Calc_Financiera_Admin. Defines all hooks for the admin area.
	 * - Calc_Financiera_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-calc-financiera-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-calc-financiera-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-calc-financiera-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-calc-financiera-public.php';

		/**
		 * Custom Post Types
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-calc-financiera-post_types.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/cmb2/cmb2/init.php';

		if ( is_readable( plugin_dir_path( dirname( __FILE__ ) ) . '/vendor/autoload.php' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/autoload.php';
		}

		$this->loader = new Calc_Financiera_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Calc_Financiera_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Calc_Financiera_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Calc_Financiera_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$plugin_post_types = new Calc_Financiera_Post_Types();

		$this->loader->add_action( 'init', $plugin_post_types, 'create_custom_post_type', 999 );

		$this->loader->add_action( 'cmb2_admin_init', $plugin_admin, 'create_metabox', 999 );

		$this->loader->add_action( 'manage_solicitud_posts_columns', $plugin_admin, 'add_column_to_solicitud' );

		$this->loader->add_action('manage_solicitud_posts_custom_column', $plugin_admin, 'manage_solicitud_columns', 10, 2);

		$this->loader->add_action( 'cmb2_admin_init', $plugin_admin, 'create_options', 0 );

		$this->loader->add_action('manage_posts_extra_tablenav', $plugin_admin, 'add_export_button', 20);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Calc_Financiera_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_shortcode( 'calculadora-prestamo', $plugin_public, 'shortcode_prestamo' );
		$this->loader->add_shortcode( 'calculadora-inversion', $plugin_public, 'shortcode_inversion' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action('wp_ajax_calc_ajax_solicitud', $plugin_public, 'calc_ajax_solicitud');
		$this->loader->add_action('wp_ajax_nopriv_calc_ajax_solicitud', $plugin_public, 'calc_ajax_solicitud');

		$this->loader->add_action('wp_ajax_calc_ajax_option', $plugin_public, 'calc_ajax_option');
		$this->loader->add_action('wp_ajax_nopriv_calc_ajax_option', $plugin_public, 'calc_ajax_option');
		
		$this->loader->add_action( 'admin_post_csv_export', $plugin_public, 'csv_export' );
		$this->loader->add_action( 'admin_post_nopriv_csv_export', $plugin_public, 'csv_export' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Calc_Financiera_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
