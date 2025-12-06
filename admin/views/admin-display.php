<?php
/**
 * Admin display view.
 *
 * @package WP_Community_Finances
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<?php if ( isset( $_GET['message'] ) && 'success' === $_GET['message'] ) : ?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'Transaction added successfully!', 'bk-finances' ); ?></p>
		</div>
	<?php endif; ?>

	<?php if ( isset( $_GET['message'] ) && 'deleted' === $_GET['message'] ) : ?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'Transaction deleted successfully!', 'bk-finances' ); ?></p>
		</div>
	<?php endif; ?>

	<div class="wcf-balance-summary" style="background: #fff; padding: 20px; margin: 20px 0; border-left: 4px solid #2271b1;">
		<h2><?php esc_html_e( 'Balance Summary', 'bk-finances' ); ?></h2>
		<p>
			<strong><?php esc_html_e( 'Total Income:', 'bk-finances' ); ?></strong> 
			<span style="color: green;">$<?php echo esc_html( number_format( $balance['income'], 2 ) ); ?></span>
		</p>
		<p>
			<strong><?php esc_html_e( 'Total Expenses:', 'bk-finances' ); ?></strong> 
			<span style="color: red;">$<?php echo esc_html( number_format( $balance['expense'], 2 ) ); ?></span>
		</p>
		<p>
			<strong><?php esc_html_e( 'Current Balance:', 'bk-finances' ); ?></strong> 
			<span style="font-size: 1.2em; <?php echo $balance['balance'] >= 0 ? 'color: green;' : 'color: red;'; ?>">
				$<?php echo esc_html( number_format( $balance['balance'], 2 ) ); ?>
			</span>
		</p>
	</div>

	<h2><?php esc_html_e( 'All Transactions', 'bk-finances' ); ?></h2>

	<?php if ( empty( $transactions ) ) : ?>
		<p><?php esc_html_e( 'No transactions found.', 'bk-finances' ); ?></p>
		<p>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=wcf-add-transaction' ) ); ?>" class="button button-primary">
				<?php esc_html_e( 'Add Your First Transaction', 'bk-finances' ); ?>
			</a>
		</p>
	<?php else : ?>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Date', 'bk-finances' ); ?></th>
					<th><?php esc_html_e( 'Description', 'bk-finances' ); ?></th>
					<th><?php esc_html_e( 'Category', 'bk-finances' ); ?></th>
					<th><?php esc_html_e( 'Type', 'bk-finances' ); ?></th>
					<th><?php esc_html_e( 'Amount', 'bk-finances' ); ?></th>
					<th><?php esc_html_e( 'Actions', 'bk-finances' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $transactions as $transaction ) : ?>
					<tr>
						<td><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $transaction['transaction_date'] ) ) ); ?></td>
						<td><?php echo esc_html( $transaction['description'] ); ?></td>
						<td><?php echo esc_html( $transaction['category'] ); ?></td>
						<td>
							<span class="wcf-type-badge wcf-type-<?php echo esc_attr( $transaction['transaction_type'] ); ?>">
								<?php echo esc_html( ucfirst( $transaction['transaction_type'] ) ); ?>
							</span>
						</td>
						<td style="<?php echo 'income' === $transaction['transaction_type'] ? 'color: green;' : 'color: red;'; ?>">
							<?php echo 'income' === $transaction['transaction_type'] ? '+' : '-'; ?>
							$<?php echo esc_html( number_format( $transaction['amount'], 2 ) ); ?>
						</td>
						<td>
							<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=bk_fin_delete_transaction&transaction_id=' . $transaction['id'] ), 'bk_fin_delete_transaction' ) ); ?>" 
							   class="button button-small"
							   onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to delete this transaction?', 'bk-finances' ); ?>');">
								<?php esc_html_e( 'Delete', 'bk-finances' ); ?>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>

<style>
.wcf-type-badge {
	display: inline-block;
	padding: 2px 8px;
	border-radius: 3px;
	font-size: 12px;
	font-weight: 600;
}
.wcf-type-income {
	background-color: #d4edda;
	color: #155724;
}
.wcf-type-expense {
	background-color: #f8d7da;
	color: #721c24;
}
</style>
