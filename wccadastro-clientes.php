<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/jonathaf
 * @since             1.0.0
 * @package           Wccadastro_Clientes
 *
 * @wordpress-plugin
 * Plugin Name:       WC Cadastro de Clientes
 * Plugin URI:        https://github.com/jonathaf/wccadastro-clientes
 * Description:       Adicionar mais campos na pagina de cadastro de clientes
 * Version:           1.0.0
 * Author:            Jonatha Ferreira, Leonardo Oliveira
 * Author URI:        https://github.com/jonathaf
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wccadastro-clientes
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
define( 'WCCADASTRO_CLIENTES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wccadastro-clientes-activator.php
 */
function activate_wccadastro_clientes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wccadastro-clientes-activator.php';
	Wccadastro_Clientes_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wccadastro-clientes-deactivator.php
 */
function deactivate_wccadastro_clientes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wccadastro-clientes-deactivator.php';
	Wccadastro_Clientes_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wccadastro_clientes' );
register_deactivation_hook( __FILE__, 'deactivate_wccadastro_clientes' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wccadastro-clientes.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wccadastro_clientes() {

	$plugin = new Wccadastro_Clientes();
	$plugin->run();

}
run_wccadastro_clientes();
