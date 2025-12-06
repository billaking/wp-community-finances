# Installation and Testing Instructions

## Quick Installation

1. **Download the Plugin:**
   - Clone or download this repository
   - Or download as ZIP from GitHub

2. **Install in WordPress:**
   ```
   Method 1: Upload ZIP
   - Go to WordPress Admin > Plugins > Add New
   - Click "Upload Plugin"
   - Choose the ZIP file
   - Click "Install Now"
   - Click "Activate"

   Method 2: Manual Installation
   - Upload the `wp-community-finances` folder to `/wp-content/plugins/`
   - Go to WordPress Admin > Plugins
   - Find "WP Community Finances"
   - Click "Activate"
   ```

3. **Verify Installation:**
   - Look for "Finances" menu in WordPress admin sidebar
   - Click on it to access the plugin

## First Time Setup

1. **Access the Plugin:**
   - Login to WordPress admin
   - Click "Finances" in the left sidebar

2. **Add Your First Transaction:**
   - Click "Finances > Add New"
   - Fill in the form:
     - Date: Today's date
     - Type: Income
     - Description: "Initial balance"
     - Amount: 1000.00
     - Category: "Starting Balance"
   - Click "Add Transaction"

3. **View the Dashboard:**
   - Click "Finances > All Transactions"
   - You should see your transaction
   - Balance summary should show $1000.00

## Testing Shortcodes

### Test 1: Balance Display

1. Create a new page: "Test Balance"
2. Add shortcode: `[wcf_balance]`
3. Publish and view the page
4. You should see the balance summary

### Test 2: Transaction List

1. Create a new page: "Test Transactions"
2. Add shortcode: `[wcf_transaction_list]`
3. Publish and view the page
4. You should see a table with your transaction

### Test 3: Add Transaction Form

1. Create a new page: "Test Form"
2. Add shortcode: `[wcf_add_transaction]`
3. Publish and view the page
4. Fill out and submit the form
5. Transaction should be added

### Test 4: Financial Summary

1. Create a new page: "Test Summary"
2. Add shortcode: `[wcf_summary]`
3. Publish and view the page
4. You should see financial summary cards

## Testing Different Scenarios

### Add Sample Data

To properly test the plugin, add various transactions:

**Income Transactions:**
- Date: 2024-01-15, Type: Income, Description: "Membership Fees - January", Amount: 500.00, Category: "Membership"
- Date: 2024-02-01, Type: Income, Description: "Fundraiser Event", Amount: 1200.00, Category: "Events"
- Date: 2024-02-15, Type: Income, Description: "Donations", Amount: 300.00, Category: "Donations"

**Expense Transactions:**
- Date: 2024-01-20, Type: Expense, Description: "Office Supplies", Amount: 150.00, Category: "Office"
- Date: 2024-02-05, Type: Expense, Description: "Venue Rental", Amount: 400.00, Category: "Events"
- Date: 2024-02-10, Type: Expense, Description: "Marketing Materials", Amount: 75.00, Category: "Marketing"

### Test Shortcode Attributes

1. **Filtered Transaction List:**
   ```
   [wcf_transaction_list type="income" limit="5"]
   [wcf_transaction_list type="expense" limit="5"]
   ```

2. **Simple Balance:**
   ```
   [wcf_balance show_details="no"]
   ```

3. **Filtered Summary:**
   ```
   [wcf_summary type="income"]
   [wcf_summary type="expense"]
   ```

## Verifying Features

### ✓ Database Creation
- After activation, check database for `wp_wcf_transactions` table
- Via phpMyAdmin or database management tool

### ✓ Admin Interface
- [ ] Can access "Finances" menu
- [ ] Can view all transactions
- [ ] Can add new transaction
- [ ] Can delete transaction
- [ ] Can view reports page
- [ ] Balance calculations are correct

### ✓ Shortcodes
- [ ] `[wcf_transaction_list]` displays correctly
- [ ] `[wcf_balance]` shows accurate balance
- [ ] `[wcf_add_transaction]` form works
- [ ] `[wcf_summary]` displays summary

### ✓ Security
- [ ] Forms use nonces
- [ ] Data is sanitized
- [ ] Only admins can access admin pages
- [ ] SQL injection protection (using prepared statements)

### ✓ Responsive Design
- [ ] Admin pages work on mobile
- [ ] Frontend shortcodes are mobile-friendly
- [ ] Tables scroll/adapt on small screens

## Common Test Issues

### Issue: "Finances" menu doesn't appear
**Solution:** Ensure you're logged in as Administrator

### Issue: Shortcode shows as text
**Solution:** 
- Verify plugin is activated
- Check shortcode spelling
- Make sure you're in Text/HTML mode when adding shortcode

### Issue: Transaction not saving
**Solution:**
- Check all required fields are filled
- Verify JavaScript isn't blocked
- Check browser console for errors

### Issue: Balance shows $0.00
**Solution:**
- Ensure transactions have amounts
- Verify transaction type is set
- Check database for data

## Advanced Testing

### Load Testing
1. Add 100+ transactions
2. Test page load times
3. Verify pagination if implemented

### Browser Compatibility
- Test in Chrome, Firefox, Safari, Edge
- Check responsive design
- Verify JavaScript functionality

### Theme Compatibility
- Test with different WordPress themes
- Check styling compatibility
- Verify no CSS conflicts

### Plugin Conflicts
- Test with other popular plugins
- Deactivate plugins one by one if issues occur

## Cleanup

### To Reset/Uninstall:
1. Deactivate the plugin
2. If you want to remove data:
   - Delete the plugin
   - Manually drop the `wp_wcf_transactions` table if needed
   - Remove `wcf_db_version` from wp_options

**Note:** Deactivation preserves your data. Only full deletion removes the database table.

## Getting Help

If you encounter issues:
1. Check the USER-GUIDE.md
2. Review SHORTCODE-EXAMPLES.md
3. Check GitHub issues
4. Enable WordPress debug mode for detailed error messages

## Debug Mode

To enable debug mode, add to `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

Check `/wp-content/debug.log` for errors.

---

**Plugin Version:** 1.0.0  
**Minimum WordPress Version:** 5.0  
**PHP Version:** 7.0+  
**Tested Up To:** WordPress 6.4