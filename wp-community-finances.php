<?php
/**
 * Plugin Name: WP Community Finances
 * Plugin URI: https://github.com/billaking/bk-finances
 * Description: A WordPress plugin for managing finances for small businesses and community groups. Track income, expenses, and generate financial reports with easy-to-use shortcodes.
 * Version: 1.0.0
 * Author: billaking
 * Author URI: https://github.com/billaking
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: bk-finances
 * Domain Path: /languages
 *
 * @package WP_Community_Finances
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Check if WP Community Core plugin is active
 */
function bk_fin_check_dependencies() {
    // Check if WP Community Core is active
    if (!class_exists('BK_Community_Core')) {
        add_action('admin_notices', 'bk_fin_missing_dependency_notice');

        // Deactivate this plugin
        add_action('admin_init', function() {
            deactivate_plugins(plugin_basename(__FILE__));
        });

        return false;
    }
    return true;
}

/**
 * Display admin notice when dependency is missing
 */
function bk_fin_missing_dependency_notice() {
    ?>
    <div class="notice notice-error">
        <p>
            <strong>WP Community Finances</strong> requires the <strong>WP Community Core</strong> plugin to be installed and activated.
            Please install and activate <a href="<?php echo admin_url('plugin-install.php?s=wp-community-core&tab=search&type=term'); ?>">WP Community Core</a> first.
        </p>
    </div>
    <?php

    // Remove "Plugin activated" message if present
    if (isset($_GET['activate'])) {
        unset($_GET['activate']);
    }
}

// Check dependencies before proceeding
if (!bk_fin_check_dependencies()) {
    return;
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
	BK_FIN_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_wp_community_finances() {
	require_once WP_COMMUNITY_FINANCES_PATH . 'includes/class-wcf-deactivator.php';
	BK_FIN_Deactivator::deactivate();
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
	$plugin = new BK_FIN_Core();
	$plugin->run();
}
run_wp_community_finances();
