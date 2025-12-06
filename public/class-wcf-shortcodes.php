<?php
/**
 * Shortcodes for the plugin.
 *
 * @package WP_Community_Finances
 */

/**
 * Shortcodes class.
 */
class BK_FIN_Shortcodes {

	/**
	 * Register all shortcodes.
	 */
	public function register_shortcodes() {
		add_shortcode( 'bk_fin_transaction_list', array( $this, 'transaction_list_shortcode' ) );
		add_shortcode( 'bk_fin_balance', array( $this, 'balance_shortcode' ) );
		add_shortcode( 'bk_fin_add_transaction', array( $this, 'add_transaction_shortcode' ) );
		add_shortcode( 'bk_fin_summary', array( $this, 'summary_shortcode' ) );
	}

	/**
	 * Transaction list shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function transaction_list_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'limit' => 10,
				'type'  => '',
			),
			$atts,
			'bk_fin_transaction_list'
		);

		$args = array(
			'limit' => intval( $atts['limit'] ),
		);

		if ( ! empty( $atts['type'] ) && in_array( $atts['type'], array( 'income', 'expense' ), true ) ) {
			$args['transaction_type'] = $atts['type'];
		}

		$transactions = BK_FIN_Database::get_transactions( $args );

		ob_start();
		?>
		<div class="wcf-transaction-list">
			<h3><?php esc_html_e( 'Transactions', 'bk-finances' ); ?></h3>
			<?php if ( empty( $transactions ) ) : ?>
				<p><?php esc_html_e( 'No transactions found.', 'bk-finances' ); ?></p>
			<?php else : ?>
				<table class="wcf-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Date', 'bk-finances' ); ?></th>
							<th><?php esc_html_e( 'Description', 'bk-finances' ); ?></th>
							<th><?php esc_html_e( 'Category', 'bk-finances' ); ?></th>
							<th><?php esc_html_e( 'Type', 'bk-finances' ); ?></th>
							<th><?php esc_html_e( 'Amount', 'bk-finances' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $transactions as $transaction ) : ?>
							<tr>
								<td><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $transaction['transaction_date'] ) ) ); ?></td>
								<td><?php echo esc_html( $transaction['description'] ); ?></td>
								<td><?php echo esc_html( $transaction['category'] ); ?></td>
								<td>
									<span class="wcf-badge wcf-badge-<?php echo esc_attr( $transaction['transaction_type'] ); ?>">
										<?php echo esc_html( ucfirst( $transaction['transaction_type'] ) ); ?>
									</span>
								</td>
								<td class="wcf-amount wcf-amount-<?php echo esc_attr( $transaction['transaction_type'] ); ?>">
									<?php echo 'income' === $transaction['transaction_type'] ? '+' : '-'; ?>
									$<?php echo esc_html( number_format( $transaction['amount'], 2 ) ); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Balance shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function balance_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'show_details' => 'yes',
			),
			$atts,
			'bk_fin_balance'
		);

		$balance = BK_FIN_Database::get_balance();

		ob_start();
		?>
		<div class="wcf-balance">
			<?php if ( 'yes' === $atts['show_details'] ) : ?>
				<div class="wcf-balance-details">
					<div class="wcf-balance-item">
						<span class="wcf-balance-label"><?php esc_html_e( 'Total Income:', 'bk-finances' ); ?></span>
						<span class="wcf-balance-value wcf-income">$<?php echo esc_html( number_format( $balance['income'], 2 ) ); ?></span>
					</div>
					<div class="wcf-balance-item">
						<span class="wcf-balance-label"><?php esc_html_e( 'Total Expenses:', 'bk-finances' ); ?></span>
						<span class="wcf-balance-value wcf-expense">$<?php echo esc_html( number_format( $balance['expense'], 2 ) ); ?></span>
					</div>
					<div class="wcf-balance-item wcf-balance-total">
						<span class="wcf-balance-label"><?php esc_html_e( 'Current Balance:', 'bk-finances' ); ?></span>
						<span class="wcf-balance-value <?php echo $balance['balance'] >= 0 ? 'wcf-positive' : 'wcf-negative'; ?>">
							$<?php echo esc_html( number_format( $balance['balance'], 2 ) ); ?>
						</span>
					</div>
				</div>
			<?php else : ?>
				<div class="wcf-balance-simple">
					<span class="wcf-balance-label"><?php esc_html_e( 'Balance:', 'bk-finances' ); ?></span>
					<span class="wcf-balance-value <?php echo $balance['balance'] >= 0 ? 'wcf-positive' : 'wcf-negative'; ?>">
						$<?php echo esc_html( number_format( $balance['balance'], 2 ) ); ?>
					</span>
				</div>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Add transaction shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function add_transaction_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'redirect' => '',
			),
			$atts,
			'bk_fin_add_transaction'
		);

		// Handle form submission.
		if ( isset( $_POST['bk_fin_submit_transaction'] ) && isset( $_POST['bk_fin_transaction_nonce'] ) ) {
			if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bk_fin_transaction_nonce'] ) ), 'bk_fin_add_transaction_public' ) ) {
				$data = array(
					'transaction_date' => isset( $_POST['transaction_date'] ) ? sanitize_text_field( wp_unslash( $_POST['transaction_date'] ) ) : current_time( 'mysql' ),
					'description'      => isset( $_POST['description'] ) ? sanitize_text_field( wp_unslash( $_POST['description'] ) ) : '',
					'amount'           => isset( $_POST['amount'] ) ? floatval( $_POST['amount'] ) : 0,
					'transaction_type' => isset( $_POST['transaction_type'] ) ? sanitize_text_field( wp_unslash( $_POST['transaction_type'] ) ) : 'expense',
					'category'         => isset( $_POST['category'] ) ? sanitize_text_field( wp_unslash( $_POST['category'] ) ) : '',
				);

				$result = BK_FIN_Database::insert_transaction( $data );

				if ( $result ) {
					$message = 'success';
				} else {
					$message = 'error';
				}

				// Redirect if URL provided.
				if ( ! empty( $atts['redirect'] ) ) {
					wp_safe_redirect( add_query_arg( 'bk_fin_message', $message, esc_url( $atts['redirect'] ) ) );
					exit;
				}
			}
		}

		ob_start();
		?>
		<div class="wcf-add-transaction-form">
			<?php if ( isset( $_GET['bk_fin_message'] ) && 'success' === sanitize_text_field( wp_unslash( $_GET['bk_fin_message'] ) ) ) : ?>
				<div class="wcf-message wcf-success">
					<p><?php esc_html_e( 'Transaction added successfully!', 'bk-finances' ); ?></p>
				</div>
			<?php endif; ?>

			<?php if ( isset( $_GET['bk_fin_message'] ) && 'error' === sanitize_text_field( wp_unslash( $_GET['bk_fin_message'] ) ) ) : ?>
				<div class="wcf-message wcf-error">
					<p><?php esc_html_e( 'Error adding transaction. Please try again.', 'bk-finances' ); ?></p>
				</div>
			<?php endif; ?>

			<form method="post" class="wcf-form">
				<?php wp_nonce_field( 'bk_fin_add_transaction_public', 'bk_fin_transaction_nonce' ); ?>
				
				<div class="wcf-form-field">
					<label for="bk_fin_transaction_date"><?php esc_html_e( 'Date', 'bk-finances' ); ?></label>
					<input type="date" id="bk_fin_transaction_date" name="transaction_date" value="<?php echo esc_attr( current_time( 'Y-m-d' ) ); ?>" required>
				</div>

				<div class="wcf-form-field">
					<label for="bk_fin_transaction_type"><?php esc_html_e( 'Type', 'bk-finances' ); ?></label>
					<select id="bk_fin_transaction_type" name="transaction_type" required>
						<option value="income"><?php esc_html_e( 'Income', 'bk-finances' ); ?></option>
						<option value="expense"><?php esc_html_e( 'Expense', 'bk-finances' ); ?></option>
					</select>
				</div>

				<div class="wcf-form-field">
					<label for="bk_fin_description"><?php esc_html_e( 'Description', 'bk-finances' ); ?></label>
					<input type="text" id="bk_fin_description" name="description" required>
				</div>

				<div class="wcf-form-field">
					<label for="bk_fin_amount"><?php esc_html_e( 'Amount', 'bk-finances' ); ?></label>
					<input type="number" id="bk_fin_amount" name="amount" step="0.01" min="0" required>
				</div>

				<div class="wcf-form-field">
					<label for="bk_fin_category"><?php esc_html_e( 'Category', 'bk-finances' ); ?></label>
					<input type="text" id="bk_fin_category" name="category">
				</div>

				<div class="wcf-form-field">
					<input type="submit" name="bk_fin_submit_transaction" class="wcf-button" value="<?php esc_attr_e( 'Add Transaction', 'bk-finances' ); ?>">
				</div>
			</form>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Summary shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function summary_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'type' => '',
			),
			$atts,
			'bk_fin_summary'
		);

		$balance           = BK_FIN_Database::get_balance();
		$summary_by_category = BK_FIN_Database::get_summary_by_category( $atts['type'] );

		ob_start();
		?>
		<div class="wcf-summary">
			<div class="wcf-summary-balance">
				<h3><?php esc_html_e( 'Financial Summary', 'bk-finances' ); ?></h3>
				<div class="wcf-summary-grid">
					<div class="wcf-summary-card">
						<span class="wcf-summary-label"><?php esc_html_e( 'Total Income', 'bk-finances' ); ?></span>
						<span class="wcf-summary-amount wcf-income">$<?php echo esc_html( number_format( $balance['income'], 2 ) ); ?></span>
					</div>
					<div class="wcf-summary-card">
						<span class="wcf-summary-label"><?php esc_html_e( 'Total Expenses', 'bk-finances' ); ?></span>
						<span class="wcf-summary-amount wcf-expense">$<?php echo esc_html( number_format( $balance['expense'], 2 ) ); ?></span>
					</div>
					<div class="wcf-summary-card wcf-summary-total">
						<span class="wcf-summary-label"><?php esc_html_e( 'Net Balance', 'bk-finances' ); ?></span>
						<span class="wcf-summary-amount <?php echo $balance['balance'] >= 0 ? 'wcf-positive' : 'wcf-negative'; ?>">
							$<?php echo esc_html( number_format( $balance['balance'], 2 ) ); ?>
						</span>
					</div>
				</div>
			</div>

			<?php if ( ! empty( $summary_by_category ) ) : ?>
				<div class="wcf-summary-categories">
					<h4><?php esc_html_e( 'By Category', 'bk-finances' ); ?></h4>
					<table class="wcf-table">
						<thead>
							<tr>
								<th><?php esc_html_e( 'Category', 'bk-finances' ); ?></th>
								<th><?php esc_html_e( 'Type', 'bk-finances' ); ?></th>
								<th><?php esc_html_e( 'Amount', 'bk-finances' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $summary_by_category as $item ) : ?>
								<tr>
									<td><?php echo esc_html( $item['category'] ? $item['category'] : __( 'Uncategorized', 'bk-finances' ) ); ?></td>
									<td>
										<span class="wcf-badge wcf-badge-<?php echo esc_attr( $item['transaction_type'] ); ?>">
											<?php echo esc_html( ucfirst( $item['transaction_type'] ) ); ?>
										</span>
									</td>
									<td class="wcf-amount wcf-amount-<?php echo esc_attr( $item['transaction_type'] ); ?>">
										$<?php echo esc_html( number_format( $item['total'], 2 ) ); ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}
}
