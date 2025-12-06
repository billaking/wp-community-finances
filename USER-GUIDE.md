# WP Community Finances - User Guide

## Table of Contents

1. [Getting Started](#getting-started)
2. [Admin Interface Guide](#admin-interface-guide)
3. [Shortcode Reference](#shortcode-reference)
4. [Common Use Cases](#common-use-cases)
5. [Tips and Best Practices](#tips-and-best-practices)
6. [Troubleshooting](#troubleshooting)

## Getting Started

### What is WP Community Finances?

WP Community Finances is a WordPress plugin designed to help small businesses, community groups, clubs, and organizations manage their finances transparently and efficiently. It allows you to:

- Track all income and expenses
- Categorize transactions for better organization
- Generate financial reports
- Display financial information publicly using shortcodes
- Maintain transparency with stakeholders

### Installation Steps

1. **Upload the Plugin:**
   - Log in to your WordPress admin dashboard
   - Navigate to Plugins > Add New
   - Click "Upload Plugin"
   - Choose the `wp-community-finances.zip` file
   - Click "Install Now"

2. **Activate:**
   - Click "Activate Plugin"
   - A new "Finances" menu will appear in your admin sidebar

3. **First Use:**
   - Click on "Finances" in the admin menu
   - You'll see an empty transaction list
   - Click "Add New" to create your first transaction

## Admin Interface Guide

### Dashboard Overview

The main Finances page shows:
- **Balance Summary**: Current financial status at a glance
- **Transaction List**: All recorded transactions
- **Quick Actions**: Delete transactions, add new ones

### Adding Transactions

1. Click "Finances > Add New" in the admin menu
2. Fill in the transaction details:
   - **Date**: When the transaction occurred
   - **Type**: Income or Expense
   - **Description**: What the transaction was for
   - **Amount**: The dollar amount (e.g., 150.00)
   - **Category**: Optional grouping (e.g., "Office Supplies", "Membership Fees")
3. Click "Add Transaction"

**Transaction Types:**
- **Income**: Money coming in (donations, sales, fees, grants)
- **Expense**: Money going out (supplies, rent, services, equipment)

**Categories - Examples:**
- Office Supplies
- Utilities
- Salary/Wages
- Marketing
- Equipment
- Donations
- Membership Fees
- Event Revenue
- Rent
- Insurance

### Viewing Reports

Navigate to "Finances > Reports" to see:

1. **Financial Summary Cards:**
   - Total Income (green)
   - Total Expenses (red)
   - Net Balance (green if positive, red if negative)

2. **Category Breakdown:**
   - See totals grouped by category
   - Identify where money is coming from and going to
   - Make informed decisions about spending

### Managing Transactions

**To Delete a Transaction:**
1. Go to "Finances > All Transactions"
2. Find the transaction you want to remove
3. Click the "Delete" button
4. Confirm the deletion

**Note:** Deletion is permanent and cannot be undone. The plugin doesn't modify data to preserve historical records when you deactivate it.

## Shortcode Reference

### [wcf_transaction_list]

**Purpose:** Display a list of transactions on any page or post

**Basic Usage:**
```
[wcf_transaction_list]
```

**With Attributes:**
```
[wcf_transaction_list limit="20" type="income"]
```

**Attributes:**
- `limit`: Number of transactions (default: 10)
- `type`: Filter by 'income' or 'expense'

**Display:**
- Shows transaction date, description, category, type, and amount
- Formatted table with color-coded amounts
- Responsive design

---

### [wcf_balance]

**Purpose:** Show current financial balance

**Basic Usage:**
```
[wcf_balance]
```

**Simple Version:**
```
[wcf_balance show_details="no"]
```

**Attributes:**
- `show_details`: 'yes' (default) shows income/expense breakdown, 'no' shows only balance

**Display:**
- Detailed view: Shows total income, expenses, and balance
- Simple view: Shows only the current balance
- Color-coded (green for positive, red for negative)

---

### [wcf_add_transaction]

**Purpose:** Allow frontend transaction submission

**Basic Usage:**
```
[wcf_add_transaction]
```

**With Redirect:**
```
[wcf_add_transaction redirect="https://yoursite.com/thank-you"]
```

**Attributes:**
- `redirect`: URL to redirect after successful submission

**Display:**
- Complete form with all fields
- Date picker, type selector, amount input
- Category suggestions
- Submit button

**Security Note:** Anyone with access to the page can submit transactions. Consider using a membership plugin to restrict access if needed.

---

### [wcf_summary]

**Purpose:** Display comprehensive financial overview

**Basic Usage:**
```
[wcf_summary]
```

**Filter by Type:**
```
[wcf_summary type="expense"]
```

**Attributes:**
- `type`: Filter categories by 'income' or 'expense'

**Display:**
- Summary cards with totals
- Category breakdown table
- Visual organization of financial data

## Common Use Cases

### 1. Community Club Financial Transparency

**Goal:** Show members where their fees are going

**Setup:**
```
Create a page called "Our Finances"

Add content:
<h2>Current Financial Status</h2>
[wcf_balance]

<h2>How We've Used Your Membership Fees</h2>
[wcf_transaction_list type="expense" limit="10"]

<h2>Income Sources</h2>
[wcf_transaction_list type="income" limit="10"]
```

### 2. Small Business Financial Tracking

**Goal:** Track business income and expenses privately

**Setup:**
- Use admin interface only
- Don't add shortcodes to public pages
- Regularly review Reports page
- Export data for accountant (future feature)

### 3. Fundraising Campaign

**Goal:** Show donors how funds are being used

**Setup:**
```
Create "Campaign Progress" page

Add:
<h2>Total Raised</h2>
[wcf_balance show_details="no"]

<h2>Recent Donations</h2>
[wcf_transaction_list type="income" limit="5"]

<h2>How We're Using Your Donations</h2>
[wcf_summary type="expense"]
```

### 4. Shared Household Expenses

**Goal:** Track and display shared costs

**Setup:**
```
Create "House Expenses" page

Add member submission form:
<h2>Submit an Expense</h2>
[wcf_add_transaction]

<h2>Recent Expenses</h2>
[wcf_transaction_list limit="20"]

<h2>Who Owes What</h2>
[wcf_summary]
```

## Tips and Best Practices

### Organizing Transactions

1. **Use Consistent Categories:**
   - Decide on categories upfront
   - Use the same spelling and capitalization
   - Examples: "Office Supplies" not "office supplies" or "Office Suplies"

2. **Write Clear Descriptions:**
   - Be specific: "Printer Paper - 5 reams" not just "Paper"
   - Include vendor: "Amazon - Office Chair"
   - Add reference numbers if applicable

3. **Enter Transactions Regularly:**
   - Don't wait until month-end
   - Enter as they occur for accuracy
   - Set a reminder to review weekly

### Display Best Practices

1. **Choose Appropriate Shortcodes:**
   - Homepage: Simple balance `[wcf_balance show_details="no"]`
   - Detailed page: Full summary `[wcf_summary]`
   - Transparency page: Transaction list `[wcf_transaction_list]`

2. **Combine Shortcodes Effectively:**
   - Balance + Recent transactions = Quick overview
   - Summary + Transaction list = Complete picture
   - Multiple filtered lists = Organized view

3. **Consider Your Audience:**
   - Members want transparency: Show everything
   - Donors want impact: Show how money is used
   - Public site: Maybe show balance only

### Security Considerations

1. **Protect the Add Transaction Form:**
   - Don't put on public pages
   - Use on password-protected pages
   - Consider member-only areas

2. **Review Submissions:**
   - Check frontend-submitted transactions
   - Delete spam or incorrect entries
   - Train members on proper use

3. **Backup Your Data:**
   - Regular WordPress backups include the plugin data
   - Use a backup plugin
   - Export data periodically

## Troubleshooting

### Shortcodes Show as Text

**Problem:** `[wcf_balance]` appears on page instead of the balance

**Solution:**
- Make sure the plugin is activated
- Check that you're using the correct shortcode name
- Ensure you're editing in Text/HTML mode, not Visual mode when adding shortcodes

### Transactions Not Saving

**Problem:** Form submits but transaction doesn't appear

**Solution:**
- Check that you filled in all required fields
- Verify your user role has proper permissions
- Look for error messages
- Check if JavaScript is blocked

### Styling Looks Wrong

**Problem:** Tables or forms don't display correctly

**Solution:**
- Your theme might conflict with default styles
- Try a different theme to test
- Add custom CSS to your theme
- Check browser console for errors

### Can't See Finances Menu

**Problem:** No "Finances" menu in admin

**Solution:**
- Verify plugin is activated
- Check your user role (needs Administrator)
- Try deactivating and reactivating the plugin
- Check for plugin conflicts

### Balance Shows $0.00

**Problem:** Balance is zero but transactions exist

**Solution:**
- Verify transactions have amounts entered
- Check transaction type is set correctly
- Look at Reports page for breakdown
- Make sure decimals are used (100.00 not 100)

### Frontend Form Not Working

**Problem:** Add transaction form doesn't submit

**Solution:**
- Check browser console for JavaScript errors
- Verify nonce is present (view page source)
- Test with default WordPress theme
- Disable other plugins to test for conflicts

## Additional Resources

### Customization

Want to customize the look? The CSS file is located at:
```
/wp-content/plugins/wp-community-finances/assets/css/wcf-public.css
```

Copy it to your theme and modify as needed.

### Getting Help

- Check the README.md file for technical details
- Review this user guide thoroughly
- Visit the GitHub repository for issues and updates

### Future Features

Potential enhancements being considered:
- Export to CSV/PDF
- Recurring transactions
- Budget planning
- Multi-currency support
- Email notifications
- Transaction attachments (receipts)

---

**Last Updated:** December 2024  
**Plugin Version:** 1.0.0