<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://portafolio.cotillo.tech
 * @since             1.0.0
 * @package           Calc_Financiera
 *
 * @wordpress-plugin
 * Plugin Name:       calculadora financiera
 * Plugin URI:        https://portafolio.cotillo.tech/calc-financiera
 * Description:       Calculadora de cuotas de préstamo.
 * Version:           1.0.5
 * Author:            Ricardo Cotillo
 * Author URI:        https://portafolio.cotillo.tech
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       calc-financiera
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CALC_FINANCIERA_VERSION', '1.0.5' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-calc-financiera-activator.php
 */
function activate_calc_financiera() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-calc-financiera-activator.php';
	Calc_Financiera_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-calc-financiera-deactivator.php
 */
function deactivate_calc_financiera() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-calc-financiera-deactivator.php';
	Calc_Financiera_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_calc_financiera' );
register_deactivation_hook( __FILE__, 'deactivate_calc_financiera' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-calc-financiera.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_calc_financiera() {

	$plugin = new Calc_Financiera();
	$plugin->run();

}
run_calc_financiera();
