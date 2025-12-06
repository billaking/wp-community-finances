# WP Community Finances

A WordPress plugin for managing finances for small businesses and community groups. Track income, expenses, and generate financial reports with easy-to-use shortcodes.

## Features

- 💰 Track income and expenses
- 📊 Generate financial reports
- 🏷️ Categorize transactions
- 📈 View balance summaries
- 🎨 Frontend shortcodes for public display
- 🔒 Secure with WordPress nonces and sanitization
- 📱 Responsive design

## Installation

1. Download the plugin files
2. Upload the `wp-community-finances` folder to `/wp-content/plugins/`
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Navigate to 'Finances' in the WordPress admin menu to get started

## Admin Interface

After activation, you'll find a new "Finances" menu in your WordPress admin area with the following sections:

### All Transactions
View all financial transactions with:
- Date, description, category, type, and amount
- Current balance summary
- Delete functionality

### Add New Transaction
Add new income or expense transactions with:
- Date selection
- Transaction type (Income/Expense)
- Description
- Amount
- Category (optional)

### Reports
View financial summaries including:
- Total income
- Total expenses
- Net balance
- Breakdown by category

## Shortcodes

The plugin provides four powerful shortcodes for displaying financial information on the frontend:

### 1. Transaction List - `[wcf_transaction_list]`

Display a list of transactions.

**Attributes:**
- `limit` - Number of transactions to display (default: 10)
- `type` - Filter by transaction type: 'income' or 'expense' (default: all)

**Examples:**
```
[wcf_transaction_list]
[wcf_transaction_list limit="20"]
[wcf_transaction_list type="income" limit="5"]
[wcf_transaction_list type="expense"]
```

### 2. Balance Display - `[wcf_balance]`

Show the current financial balance.

**Attributes:**
- `show_details` - Show detailed breakdown (default: 'yes')

**Examples:**
```
[wcf_balance]
[wcf_balance show_details="no"]
```

### 3. Add Transaction Form - `[wcf_add_transaction]`

Display a form for adding transactions from the frontend.

**Attributes:**
- `redirect` - URL to redirect after successful submission (optional)

**Examples:**
```
[wcf_add_transaction]
[wcf_add_transaction redirect="https://example.com/thank-you"]
```

### 4. Financial Summary - `[wcf_summary]`

Display a comprehensive financial summary with category breakdown.

**Attributes:**
- `type` - Filter by transaction type: 'income' or 'expense' (default: all)

**Examples:**
```
[wcf_summary]
[wcf_summary type="income"]
[wcf_summary type="expense"]
```

## Usage Examples

### Basic Setup for Community Group

1. **Create a Finances Page:**
   - Create a new page called "Our Finances"
   - Add the summary shortcode: `[wcf_summary]`
   - This displays total income, expenses, and balance

2. **Show Recent Transactions:**
   - Add another page or section
   - Use: `[wcf_transaction_list limit="10"]`
   - Shows the last 10 transactions

3. **Allow Members to Submit Expenses:**
   - Create a "Submit Expense" page
   - Add: `[wcf_add_transaction]`
   - Members can submit their expenses for review

### Advanced Examples

**Show only income sources:**
```
[wcf_transaction_list type="income" limit="5"]
```

**Simple balance widget in sidebar:**
```
[wcf_balance show_details="no"]
```

**Complete financial overview:**
```
<h2>Financial Overview</h2>
[wcf_balance]

<h2>Recent Transactions</h2>
[wcf_transaction_list limit="15"]

<h2>Detailed Summary</h2>
[wcf_summary]
```

## Database

The plugin creates a custom table `wp_wcf_transactions` with the following structure:

- `id` - Unique transaction ID
- `transaction_date` - Date of the transaction
- `description` - Transaction description
- `amount` - Transaction amount (decimal)
- `transaction_type` - 'income' or 'expense'
- `category` - Transaction category
- `created_by` - User ID who created the transaction
- `created_at` - Timestamp when created
- `updated_at` - Timestamp when last updated

## Security Features

- Nonce verification for all form submissions
- Data sanitization on all inputs
- SQL injection protection using prepared statements
- Capability checks for admin functions
- XSS protection with proper escaping

## Styling

The plugin includes default CSS that works with most themes. You can customize the appearance by:

1. Copying `/assets/css/wcf-public.css` to your theme
2. Modifying the styles as needed
3. Dequeue the default styles if necessary

## Permissions

- Only users with `manage_options` capability (typically Administrators) can access the admin interface
- All users can view shortcode content on the frontend
- Frontend transaction submission can be restricted by modifying the shortcode template

## Support

For issues, questions, or contributions, please visit:
https://github.com/billaking/wp-community-finances

## Changelog

### Version 1.0.0
- Initial release
- Transaction management (add, view, delete)
- Four shortcodes for frontend display
- Admin interface with reports
- Category-based organization
- Balance tracking

## License

This plugin is licensed under GPL v2 or later.

## Credits

Developed for community groups and small businesses to manage their finances transparently and efficiently.