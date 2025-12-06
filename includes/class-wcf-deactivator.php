<?php
/**
 * Fired during plugin deactivation.
 *
 * @package WP_Community_Finances
 */

/**
 * Deactivator class.
 */
class BK_FIN_Deactivator {

	/**
	 * Deactivate the plugin.
	 *
	 * Currently performs cleanup tasks if needed.
	 */
	public static function deactivate() {
		// Cleanup tasks on deactivation.
		// Note: We don't delete the database table to preserve data.
	}
}
