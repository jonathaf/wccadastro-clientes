<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/jonathaf
 * @since      1.0.0
 *
 * @package    Wccadastro_Clientes
 * @subpackage Wccadastro_Clientes/includes
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
 * @package    Wccadastro_Clientes
 * @subpackage Wccadastro_Clientes/includes
 * @author     Jonatha Ferreira, Leonardo Oliveira <jonatha.php@gmail.com>
 */
class Wccadastro_Clientes {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wccadastro_Clientes_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'WCCADASTRO_CLIENTES_VERSION' ) ) {
			$this->version = WCCADASTRO_CLIENTES_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wccadastro-clientes';

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
	 * - Wccadastro_Clientes_Loader. Orchestrates the hooks of the plugin.
	 * - Wccadastro_Clientes_i18n. Defines internationalization functionality.
	 * - Wccadastro_Clientes_Admin. Defines all hooks for the admin area.
	 * - Wccadastro_Clientes_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wccadastro-clientes-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wccadastro-clientes-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wccadastro-clientes-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wccadastro-clientes-public.php';

		/**
		 * A classe responsável por gerenciar todo o plugin de cadastro de clientes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wccadastro-clientes-main.php';

		$this->loader = new Wccadastro_Clientes_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wccadastro_Clientes_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wccadastro_Clientes_i18n();

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

		$plugin_admin = new Wccadastro_Clientes_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_main  = new WC_Cadastro_de_clientes_main();

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'user_register', $plugin_admin, 'user_registration_save' , 10, 1 );
		$this->loader->add_action( 'woocommerce_register_form', $plugin_admin, 'wooc_extra_register_fields' );
		$this->loader->add_action( 'woocommerce_register_post', $plugin_admin, 'wooc_validate_extra_register_fields' , 10, 3);
		$this->loader->add_action( 'wp_head', $plugin_admin, 'my_custom_js' );
		$this->loader->add_action( 'wp_footer', $plugin_admin, 'customJsScript' );



	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wccadastro_Clientes_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'user_register', $plugin_admin, 'user_registration_save' , 10, 1 );
		$this->loader->add_action( 'woocommerce_register_form', $plugin_admin, 'wooc_extra_register_fields' );
		$this->loader->add_action( 'woocommerce_register_post', $plugin_admin, 'wooc_validate_extra_register_fields' , 10, 3);
		$this->loader->add_action( 'wp_head', $plugin_admin, 'my_custom_js' );
		$this->loader->add_action( 'wp_footer', $plugin_admin, 'customJsScript' );

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
	 * @return    Wccadastro_Clientes_Loader    Orchestrates the hooks of the plugin.
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
