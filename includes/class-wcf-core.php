<?php
/**
 * The core plugin class.
 *
 * @package WP_Community_Finances
 */

/**
 * Core plugin class.
 */
class WCF_Core {

	/**
	 * The loader that's responsible for maintaining and registering all hooks.
	 *
	 * @var WCF_Loader
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @var string
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * Initialize the plugin.
	 */
	public function __construct() {
		$this->version     = WP_COMMUNITY_FINANCES_VERSION;
		$this->plugin_name = 'wp-community-finances';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 */
	private function load_dependencies() {
		require_once WP_COMMUNITY_FINANCES_PATH . 'includes/class-wcf-loader.php';
		require_once WP_COMMUNITY_FINANCES_PATH . 'includes/class-wcf-database.php';
		require_once WP_COMMUNITY_FINANCES_PATH . 'admin/class-wcf-admin.php';
		require_once WP_COMMUNITY_FINANCES_PATH . 'public/class-wcf-public.php';
		require_once WP_COMMUNITY_FINANCES_PATH . 'public/class-wcf-shortcodes.php';

		$this->loader = new WCF_Loader();
	}

	/**
	 * Register all of the hooks related to the admin area functionality.
	 */
	private function define_admin_hooks() {
		$plugin_admin = new WCF_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );
		$this->loader->add_action( 'admin_post_wcf_add_transaction', $plugin_admin, 'handle_add_transaction' );
		$this->loader->add_action( 'admin_post_wcf_delete_transaction', $plugin_admin, 'handle_delete_transaction' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality.
	 */
	private function define_public_hooks() {
		$plugin_public = new WCF_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Register shortcodes.
		$shortcodes = new WCF_Shortcodes();
		$this->loader->add_action( 'init', $shortcodes, 'register_shortcodes' );
	}

	/**
	 * Run the loader to execute all of the hooks.
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin.
	 *
	 * @return string
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks.
	 *
	 * @return WCF_Loader
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return string
	 */
	public function get_version() {
		return $this->version;
	}
}
