<?php
/**
 * Add transaction view.
 *
 * @package WP_Community_Finances
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<?php if ( isset( $_GET['message'] ) && 'error' === $_GET['message'] ) : ?>
		<div class="notice notice-error is-dismissible">
			<p><?php esc_html_e( 'Error adding transaction. Please try again.', 'wp-community-finances' ); ?></p>
		</div>
	<?php endif; ?>

	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="max-width: 600px;">
		<?php wp_nonce_field( 'wcf_add_transaction' ); ?>
		<input type="hidden" name="action" value="wcf_add_transaction">

		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="transaction_date"><?php esc_html_e( 'Date', 'wp-community-finances' ); ?></label>
				</th>
				<td>
					<input type="date" 
						   id="transaction_date" 
						   name="transaction_date" 
						   value="<?php echo esc_attr( current_time( 'Y-m-d' ) ); ?>" 
						   class="regular-text">
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="transaction_type"><?php esc_html_e( 'Type', 'wp-community-finances' ); ?></label>
				</th>
				<td>
					<select id="transaction_type" name="transaction_type" class="regular-text">
						<option value="income"><?php esc_html_e( 'Income', 'wp-community-finances' ); ?></option>
						<option value="expense" selected><?php esc_html_e( 'Expense', 'wp-community-finances' ); ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="description"><?php esc_html_e( 'Description', 'wp-community-finances' ); ?></label>
				</th>
				<td>
					<input type="text" 
						   id="description" 
						   name="description" 
						   class="regular-text" 
						   required>
					<p class="description"><?php esc_html_e( 'Enter a brief description of the transaction.', 'wp-community-finances' ); ?></p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="amount"><?php esc_html_e( 'Amount', 'wp-community-finances' ); ?></label>
				</th>
				<td>
					<input type="number" 
						   id="amount" 
						   name="amount" 
						   step="0.01" 
						   min="0" 
						   class="regular-text" 
						   required>
					<p class="description"><?php esc_html_e( 'Enter the amount (e.g., 100.00).', 'wp-community-finances' ); ?></p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="category"><?php esc_html_e( 'Category', 'wp-community-finances' ); ?></label>
				</th>
				<td>
					<input type="text" 
						   id="category" 
						   name="category" 
						   class="regular-text" 
						   list="category-suggestions">
					<datalist id="category-suggestions">
						<option value="Office Supplies">
						<option value="Utilities">
						<option value="Salary">
						<option value="Marketing">
						<option value="Equipment">
						<option value="Donations">
						<option value="Membership Fees">
						<option value="Event Revenue">
						<option value="Services">
					</datalist>
					<p class="description"><?php esc_html_e( 'Optional. Choose or enter a category.', 'wp-community-finances' ); ?></p>
				</td>
			</tr>
		</table>

		<p class="submit">
			<input type="submit" 
				   class="button button-primary" 
				   value="<?php esc_attr_e( 'Add Transaction', 'wp-community-finances' ); ?>">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=wp-community-finances' ) ); ?>" class="button">
				<?php esc_html_e( 'Cancel', 'wp-community-finances' ); ?>
			</a>
		</p>
	</form>
</div>
