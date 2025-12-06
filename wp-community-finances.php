<?php
/**
 * Plugin Name: WP Community Finances
 * Plugin URI: https://github.com/billaking/wp-community-finances
 * Description: A WordPress plugin for managing finances for small businesses and community groups. Track income, expenses, and generate financial reports with easy-to-use shortcodes.
 * Version: 1.0.0
 * Author: WP Community Finances Team
 * Author URI: https://github.com/billaking
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-community-finances
 * Domain Path: /languages
 *
 * @package WP_Community_Finances
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'WP_COMMUNITY_FINANCES_VERSION', '1.0.0' );
define( 'WP_COMMUNITY_FINANCES_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_COMMUNITY_FINANCES_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 */
function activate_wp_community_finances() {
	require_once WP_COMMUNITY_FINANCES_PATH . 'includes/class-wcf-activator.php';
	WCF_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_wp_community_finances() {
	require_once WP_COMMUNITY_FINANCES_PATH . 'includes/class-wcf-deactivator.php';
	WCF_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_community_finances' );
register_deactivation_hook( __FILE__, 'deactivate_wp_community_finances' );

/**
 * The core plugin class.
 */
require WP_COMMUNITY_FINANCES_PATH . 'includes/class-wcf-core.php';

/**
 * Begins execution of the plugin.
 */
function run_wp_community_finances() {
	$plugin = new WCF_Core();
	$plugin->run();
}
run_wp_community_finances();
