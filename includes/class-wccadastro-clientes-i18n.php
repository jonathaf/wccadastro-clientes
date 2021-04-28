<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/jonathaf
 * @since      1.0.0
 *
 * @package    Wccadastro_Clientes
 * @subpackage Wccadastro_Clientes/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wccadastro_Clientes
 * @subpackage Wccadastro_Clientes/includes
 * @author     Jonatha Ferreira, Leonardo Oliveira <jonatha.php@gmail.com>
 */
class Wccadastro_Clientes_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wccadastro-clientes',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
