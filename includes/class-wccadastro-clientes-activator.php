<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/jonathaf
 * @since      1.0.0
 *
 * @package    Wccadastro_Clientes
 * @subpackage Wccadastro_Clientes/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wccadastro_Clientes
 * @subpackage Wccadastro_Clientes/includes
 * @author     Jonatha Ferreira, Leonardo Oliveira <jonatha.php@gmail.com>
 */
class Wccadastro_Clientes_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	
		if( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			$msg = __('Desculpe, mas para instalar este plugin, é necessário que o WooCommerce esteja instalado e ativo. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Voltar para a página de plugins</a>', 'wccadastro-clientes');
			wp_die($msg);
		}
		
		if( !is_plugin_active( 'woocommerce-extra-checkout-fields-for-brazil/woocommerce-extra-checkout-fields-for-brazil.php' ) ) {
			$msg = __('Desculpe, mas para instalar este plugin, é necessário que o Brazilian Market on WooCommerce esteja instalado e ativo. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Voltar para a página de plugins</a>', 'wccadastro-clientes');
			wp_die($msg);
		}
		
		
	}

}
