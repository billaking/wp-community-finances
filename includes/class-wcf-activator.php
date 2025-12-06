<?php
/**
 * Fired during plugin activation.
 *
 * @package WP_Community_Finances
 */

/**
 * Activator class.
 */
class BK_FIN_Activator {

	/**
	 * Activate the plugin.
	 *
	 * Creates the database table for storing transactions.
	 */
	public static function activate() {
		global $wpdb;

		$table_name      = $wpdb->prefix . 'bk_fin_transactions';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			transaction_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			description varchar(255) NOT NULL,
			amount decimal(10,2) NOT NULL,
			transaction_type varchar(20) NOT NULL,
			category varchar(100) DEFAULT '' NOT NULL,
			group_id bigint(20) DEFAULT 0 NOT NULL,
			created_by bigint(20) DEFAULT 0 NOT NULL,
			created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
			PRIMARY KEY  (id),
			KEY transaction_type (transaction_type),
			KEY transaction_date (transaction_date),
			KEY group_id (group_id)
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

		// Add plugin version to options.
		add_option( 'bk_fin_db_version', WP_COMMUNITY_FINANCES_VERSION );
	}
}
