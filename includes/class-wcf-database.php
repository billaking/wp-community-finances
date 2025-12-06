<?php
/**
 * Database operations for the plugin.
 *
 * @package WP_Community_Finances
 */

/**
 * Database class.
 */
class BK_FIN_Database {

	/**
	 * Get the table name.
	 *
	 * @return string
	 */
	public static function get_table_name() {
		global $wpdb;
		return $wpdb->prefix . 'bk_fin_transactions';
	}

	/**
	 * Insert a new transaction.
	 *
	 * @param array $data Transaction data.
	 * @return int|false The number of rows inserted, or false on error.
	 */
	public static function insert_transaction( $data ) {
		global $wpdb;

		$defaults = array(
			'transaction_date' => current_time( 'mysql' ),
			'description'      => '',
			'amount'           => 0,
			'transaction_type' => 'expense',
			'category'         => '',
			'group_id'         => 0,
			'created_by'       => get_current_user_id(),
		);

		$data = wp_parse_args( $data, $defaults );

		$result = $wpdb->insert(
			self::get_table_name(),
			array(
				'transaction_date' => $data['transaction_date'],
				'description'      => sanitize_text_field( $data['description'] ),
				'amount'           => floatval( $data['amount'] ),
				'transaction_type' => sanitize_text_field( $data['transaction_type'] ),
				'category'         => sanitize_text_field( $data['category'] ),
				'group_id'         => intval( $data['group_id'] ),
				'created_by'       => intval( $data['created_by'] ),
			),
			array( '%s', '%s', '%f', '%s', '%s', '%d', '%d' )
		);

		if ( false === $result ) {
			error_log( 'WCF Database Error: Failed to insert transaction - ' . $wpdb->last_error );
		}

		return $result;
	}

	/**
	 * Get all transactions.
	 *
	 * @param array $args Query arguments.
	 * @return array
	 */
	public static function get_transactions( $args = array() ) {
		global $wpdb;

		$defaults = array(
			'limit'            => 50,
			'offset'           => 0,
			'transaction_type' => '',
			'order_by'         => 'transaction_date',
			'order'            => 'DESC',
		);

		$args = wp_parse_args( $args, $defaults );

		// Build WHERE clause safely.
		$where_clause = '';
		$where_values = array();
		if ( ! empty( $args['transaction_type'] ) && in_array( $args['transaction_type'], array( 'income', 'expense' ), true ) ) {
			$where_clause = 'WHERE transaction_type = %s';
			$where_values[] = $args['transaction_type'];
		}

		// Validate and sanitize ORDER BY.
		$allowed_order_by = array( 'transaction_date', 'amount', 'description', 'category', 'id' );
		$order_by_field = in_array( $args['order_by'], $allowed_order_by, true ) ? $args['order_by'] : 'transaction_date';
		$order_direction = 'ASC' === strtoupper( $args['order'] ) ? 'ASC' : 'DESC';
		$order_by = $order_by_field . ' ' . $order_direction;

		// Build final query.
		$sql = "SELECT * FROM " . self::get_table_name() . " $where_clause ORDER BY $order_by LIMIT %d OFFSET %d";

		// Add WHERE values to prepare arguments.
		$prepare_args = array_merge( $where_values, array( $args['limit'], $args['offset'] ) );

		if ( ! empty( $where_values ) ) {
			return $wpdb->get_results(
				$wpdb->prepare( $sql, ...$prepare_args ),
				ARRAY_A
			);
		} else {
			return $wpdb->get_results(
				$wpdb->prepare( $sql, $args['limit'], $args['offset'] ),
				ARRAY_A
			);
		}
	}

	/**
	 * Get a single transaction by ID.
	 *
	 * @param int $id Transaction ID.
	 * @return array|null
	 */
	public static function get_transaction( $id ) {
		global $wpdb;

		return $wpdb->get_row(
			$wpdb->prepare( 'SELECT * FROM ' . self::get_table_name() . ' WHERE id = %d', $id ),
			ARRAY_A
		);
	}

	/**
	 * Delete a transaction.
	 *
	 * @param int $id Transaction ID.
	 * @return int|false The number of rows deleted, or false on error.
	 */
	public static function delete_transaction( $id ) {
		global $wpdb;

		return $wpdb->delete(
			self::get_table_name(),
			array( 'id' => $id ),
			array( '%d' )
		);
	}

	/**
	 * Get balance summary.
	 *
	 * @return array
	 */
	public static function get_balance() {
		global $wpdb;

		$income = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT SUM(amount) FROM " . self::get_table_name() . " WHERE transaction_type = %s",
				'income'
			)
		);

		$expense = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT SUM(amount) FROM " . self::get_table_name() . " WHERE transaction_type = %s",
				'expense'
			)
		);

		return array(
			'income'  => floatval( $income ),
			'expense' => floatval( $expense ),
			'balance' => floatval( $income ) - floatval( $expense ),
		);
	}

	/**
	 * Get summary by category.
	 *
	 * @param string $transaction_type Optional. Filter by transaction type.
	 * @return array
	 */
	public static function get_summary_by_category( $transaction_type = '' ) {
		global $wpdb;

		// Build WHERE clause safely.
		$where_clause = '';
		if ( ! empty( $transaction_type ) && in_array( $transaction_type, array( 'income', 'expense' ), true ) ) {
			$where_clause = $wpdb->prepare( 'WHERE transaction_type = %s', $transaction_type );
		}

		// Build the query with proper preparation.
		$sql = "SELECT category, SUM(amount) as total, transaction_type
				FROM " . self::get_table_name() . "
				{$where_clause}
				GROUP BY category, transaction_type
				ORDER BY total DESC";

		return $wpdb->get_results( $sql, ARRAY_A );
	}

	/**
	 * Get transactions by group ID.
	 *
	 * @param int   $group_id Group ID from WP Community Core.
	 * @param array $args     Query arguments.
	 * @return array
	 */
	public static function get_group_transactions( $group_id, $args = array() ) {
		global $wpdb;

		$defaults = array(
			'limit'            => 50,
			'offset'           => 0,
			'transaction_type' => '',
			'order_by'         => 'transaction_date',
			'order'            => 'DESC',
		);

		$args = wp_parse_args( $args, $defaults );

		// Build WHERE clause.
		$where_conditions = array( 'group_id = %d' );
		$where_values     = array( $group_id );

		if ( ! empty( $args['transaction_type'] ) && in_array( $args['transaction_type'], array( 'income', 'expense' ), true ) ) {
			$where_conditions[] = 'transaction_type = %s';
			$where_values[]     = $args['transaction_type'];
		}

		$where_clause = 'WHERE ' . implode( ' AND ', $where_conditions );

		// Validate and sanitize ORDER BY.
		$allowed_order_by = array( 'transaction_date', 'amount', 'description', 'category', 'id' );
		$order_by_field   = in_array( $args['order_by'], $allowed_order_by, true ) ? $args['order_by'] : 'transaction_date';
		$order_direction  = 'ASC' === strtoupper( $args['order'] ) ? 'ASC' : 'DESC';
		$order_by         = $order_by_field . ' ' . $order_direction;

		// Build final query.
		$sql          = \"SELECT * FROM \" . self::get_table_name() . \" $where_clause ORDER BY $order_by LIMIT %d OFFSET %d\";
		$prepare_args = array_merge( $where_values, array( $args['limit'], $args['offset'] ) );

		return $wpdb->get_results( $wpdb->prepare( $sql, ...$prepare_args ), ARRAY_A );
	}

	/**
	 * Get group balance (income vs expense).
	 *
	 * @param int $group_id Group ID from WP Community Core.
	 * @return array Balance information.
	 */
	public static function get_group_balance( $group_id ) {
		global $wpdb;

		$income = $wpdb->get_var(
			$wpdb->prepare(
				\"SELECT SUM(amount) FROM \" . self::get_table_name() . \" WHERE group_id = %d AND transaction_type = %s\",
				$group_id,
				'income'
			)
		);

		$expense = $wpdb->get_var(
			$wpdb->prepare(
				\"SELECT SUM(amount) FROM \" . self::get_table_name() . \" WHERE group_id = %d AND transaction_type = %s\",
				$group_id,
				'expense'
			)
		);

		return array(
			'income'  => floatval( $income ),
			'expense' => floatval( $expense ),
			'balance' => floatval( $income ) - floatval( $expense ),
		);
	}
}
