<?php
/**
 * Reports view.
 *
 * @package WP_Community_Finances
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<div class="wcf-reports-container">
		<div class="wcf-balance-summary" style="background: #fff; padding: 20px; margin: 20px 0; border-left: 4px solid #2271b1;">
			<h2><?php esc_html_e( 'Financial Summary', 'wp-community-finances' ); ?></h2>
			<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
				<div>
					<p><strong><?php esc_html_e( 'Total Income', 'wp-community-finances' ); ?></strong></p>
					<p style="font-size: 24px; color: green; margin: 0;">
						$<?php echo esc_html( number_format( $balance['income'], 2 ) ); ?>
					</p>
				</div>
				<div>
					<p><strong><?php esc_html_e( 'Total Expenses', 'wp-community-finances' ); ?></strong></p>
					<p style="font-size: 24px; color: red; margin: 0;">
						$<?php echo esc_html( number_format( $balance['expense'], 2 ) ); ?>
					</p>
				</div>
				<div>
					<p><strong><?php esc_html_e( 'Net Balance', 'wp-community-finances' ); ?></strong></p>
					<p style="font-size: 24px; margin: 0; <?php echo $balance['balance'] >= 0 ? 'color: green;' : 'color: red;'; ?>">
						$<?php echo esc_html( number_format( $balance['balance'], 2 ) ); ?>
					</p>
				</div>
			</div>
		</div>

		<div style="background: #fff; padding: 20px; margin: 20px 0;">
			<h2><?php esc_html_e( 'Summary by Category', 'wp-community-finances' ); ?></h2>
			<?php if ( empty( $summary_by_category ) ) : ?>
				<p><?php esc_html_e( 'No transactions found.', 'wp-community-finances' ); ?></p>
			<?php else : ?>
				<table class="wp-list-table widefat fixed striped">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Category', 'wp-community-finances' ); ?></th>
							<th><?php esc_html_e( 'Type', 'wp-community-finances' ); ?></th>
							<th><?php esc_html_e( 'Total Amount', 'wp-community-finances' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $summary_by_category as $item ) : ?>
							<tr>
								<td><?php echo esc_html( $item['category'] ? $item['category'] : __( 'Uncategorized', 'wp-community-finances' ) ); ?></td>
								<td>
									<span class="wcf-type-badge wcf-type-<?php echo esc_attr( $item['transaction_type'] ); ?>">
										<?php echo esc_html( ucfirst( $item['transaction_type'] ) ); ?>
									</span>
								</td>
								<td style="<?php echo 'income' === $item['transaction_type'] ? 'color: green;' : 'color: red;'; ?>">
									$<?php echo esc_html( number_format( $item['total'], 2 ) ); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
	</div>
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
