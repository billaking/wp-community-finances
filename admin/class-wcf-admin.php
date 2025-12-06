<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package WP_Community_Finances
 */

/**
 * Admin class.
 */
class BK_FIN_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @var string
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Initialize the class.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		// Enqueue admin styles
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
	}

	/**
	 * Enqueue admin styles.
	 */
	public function enqueue_admin_styles( $hook ) {
		// Only load on our plugin pages
		if ( strpos( $hook, 'bk-finances' ) !== false || strpos( $hook, 'wcf-' ) !== false ) {
			wp_enqueue_style(
				$this->plugin_name . '-admin',
				WP_COMMUNITY_FINANCES_URL . 'assets/css/admin.css',
				array(),
				$this->version,
				'all'
			);
		}
	}

	/**
	 * Add admin menu.
	 */
	public function add_admin_menu() {
		add_menu_page(
			__( 'Community Finances', 'bk-finances' ),
			__( 'Finances', 'bk-finances' ),
			'manage_options',
			'bk-finances',
			array( $this, 'display_admin_page' ),
			'dashicons-chart-line',
			30
		);

		add_submenu_page(
			'bk-finances',
			__( 'All Transactions', 'bk-finances' ),
			__( 'All Transactions', 'bk-finances' ),
			'manage_options',
			'bk-finances',
			array( $this, 'display_admin_page' )
		);

		add_submenu_page(
			'bk-finances',
			__( 'Add New', 'bk-finances' ),
			__( 'Add New', 'bk-finances' ),
			'manage_options',
			'wcf-add-transaction',
			array( $this, 'display_add_transaction_page' )
		);

		add_submenu_page(
			'bk-finances',
			__( 'Reports', 'bk-finances' ),
			__( 'Reports', 'bk-finances' ),
			'manage_options',
			'wcf-reports',
			array( $this, 'display_reports_page' )
		);
	}

	/**
	 * Display the main admin page.
	 */
	public function display_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$transactions = BK_FIN_Database::get_transactions( array( 'limit' => 100 ) );
		$balance      = BK_FIN_Database::get_balance();

		require_once WP_COMMUNITY_FINANCES_PATH . 'admin/views/admin-display.php';
	}

	/**
	 * Display the add transaction page.
	 */
	public function display_add_transaction_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		require_once WP_COMMUNITY_FINANCES_PATH . 'admin/views/add-transaction.php';
	}

	/**
	 * Display the reports page.
	 */
	public function display_reports_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$balance           = BK_FIN_Database::get_balance();
		$summary_by_category = BK_FIN_Database::get_summary_by_category();

		require_once WP_COMMUNITY_FINANCES_PATH . 'admin/views/reports.php';
	}

	/**
	 * Handle add transaction form submission.
	 */
	public function handle_add_transaction() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to perform this action.', 'bk-finances' ) );
		}

		check_admin_referer( 'bk_fin_add_transaction' );

		$data = array(
			'transaction_date' => isset( $_POST['transaction_date'] ) ? sanitize_text_field( wp_unslash( $_POST['transaction_date'] ) ) : current_time( 'mysql' ),
			'description'      => isset( $_POST['description'] ) ? sanitize_text_field( wp_unslash( $_POST['description'] ) ) : '',
			'amount'           => isset( $_POST['amount'] ) ? floatval( $_POST['amount'] ) : 0,
			'transaction_type' => isset( $_POST['transaction_type'] ) ? sanitize_text_field( wp_unslash( $_POST['transaction_type'] ) ) : 'expense',
			'category'         => isset( $_POST['category'] ) ? sanitize_text_field( wp_unslash( $_POST['category'] ) ) : '',
		);

		$result = BK_FIN_Database::insert_transaction( $data );

		if ( $result ) {
			wp_safe_redirect( admin_url( 'admin.php?page=bk-finances&message=success' ) );
		} else {
			wp_safe_redirect( admin_url( 'admin.php?page=wcf-add-transaction&message=error' ) );
		}
		exit;
	}

	/**
	 * Handle delete transaction.
	 */
	public function handle_delete_transaction() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to perform this action.', 'bk-finances' ) );
		}

		check_admin_referer( 'bk_fin_delete_transaction' );

		$transaction_id = isset( $_GET['transaction_id'] ) ? intval( $_GET['transaction_id'] ) : 0;

		if ( $transaction_id > 0 ) {
			BK_FIN_Database::delete_transaction( $transaction_id );
		}

		wp_safe_redirect( admin_url( 'admin.php?page=bk-finances&message=deleted' ) );
		exit;
	}
}
