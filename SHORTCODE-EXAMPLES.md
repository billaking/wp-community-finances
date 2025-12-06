# Shortcode Examples and Templates

This document provides ready-to-use templates and examples for implementing WP Community Finances shortcodes on your WordPress site.

## Quick Reference

| Shortcode | Purpose | Key Attributes |
|-----------|---------|----------------|
| `[wcf_transaction_list]` | Display transaction list | `limit`, `type` |
| `[wcf_balance]` | Show current balance | `show_details` |
| `[wcf_add_transaction]` | Add transaction form | `redirect` |
| `[wcf_summary]` | Financial summary | `type` |

## Complete Page Templates

### Template 1: Public Financial Dashboard

Perfect for community groups wanting full transparency.

```html
<h1>Our Finances</h1>

<div class="financial-overview">
  <h2>Current Status</h2>
  [wcf_balance]
</div>

<div class="recent-activity">
  <h2>Recent Transactions</h2>
  [wcf_transaction_list limit="15"]
</div>

<div class="detailed-summary">
  <h2>Financial Breakdown</h2>
  [wcf_summary]
</div>
```

---

### Template 2: Income & Expenses Separated

Show income and expenses on separate sections.

```html
<h1>Financial Report</h1>

[wcf_balance show_details="yes"]

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 30px;">
  <div>
    <h2>Income Sources</h2>
    [wcf_transaction_list type="income" limit="10"]
  </div>
  
  <div>
    <h2>Expenses</h2>
    [wcf_transaction_list type="expense" limit="10"]
  </div>
</div>

<hr style="margin: 40px 0;">

<h2>Summary by Category</h2>
[wcf_summary]
```

---

### Template 3: Fundraising Campaign Page

Show donors the impact of their contributions.

```html
<h1>Campaign Progress</h1>

<div class="campaign-total">
  <h2>Total Raised So Far</h2>
  [wcf_balance show_details="no"]
</div>

<div class="donors">
  <h2>Recent Donations</h2>
  <p><em>Thank you to our generous supporters!</em></p>
  [wcf_transaction_list type="income" limit="8"]
</div>

<div class="how-used">
  <h2>How Your Donations Are Being Used</h2>
  [wcf_summary type="expense"]
</div>

<div class="donate-more">
  <h2>Want to Contribute?</h2>
  <p>Contact us to learn how you can help!</p>
</div>
```

---

### Template 4: Member Submission Portal

Allow members to submit expenses (place on password-protected page).

```html
<h1>Submit an Expense</h1>

<p>Please fill out the form below to submit a reimbursement request or record a shared expense.</p>

[wcf_add_transaction redirect="/thank-you"]

<hr style="margin: 40px 0;">

<h2>Recently Submitted Expenses</h2>
[wcf_transaction_list limit="10"]
```

---

### Template 5: Simple Sidebar Widget

For adding to a sidebar or widget area.

```html
<div class="widget finances-widget">
  <h3>Current Balance</h3>
  [wcf_balance show_details="no"]
  <p><a href="/finances">View Details →</a></p>
</div>
```

---

### Template 6: Club Treasurer Report

For clubs and organizations.

```html
<h1>Treasurer's Report</h1>

<p><strong>Report Date:</strong> <?php echo date('F Y'); ?></p>

<h2>Financial Summary</h2>
[wcf_balance]

<h2>This Month's Activity</h2>
[wcf_transaction_list limit="20"]

<h2>Category Breakdown</h2>
[wcf_summary]

<hr>

<p><em>Questions about our finances? Contact the treasurer at treasurer@example.com</em></p>
```

---

## Individual Shortcode Examples

### [wcf_transaction_list] Examples

**Basic - Show last 10 transactions:**
```
[wcf_transaction_list]
```

**Show more transactions:**
```
[wcf_transaction_list limit="25"]
```

**Only show income:**
```
[wcf_transaction_list type="income"]
```

**Only show expenses:**
```
[wcf_transaction_list type="expense"]
```

**Last 5 income transactions:**
```
[wcf_transaction_list type="income" limit="5"]
```

**Combine with HTML:**
```html
<div class="my-transactions">
  <h3>Recent Income</h3>
  [wcf_transaction_list type="income" limit="5"]
  
  <h3>Recent Expenses</h3>
  [wcf_transaction_list type="expense" limit="5"]
</div>
```

---

### [wcf_balance] Examples

**Full details (default):**
```
[wcf_balance]
```

**Just the balance number:**
```
[wcf_balance show_details="no"]
```

**With custom heading:**
```html
<h2>Where We Stand</h2>
[wcf_balance show_details="yes"]
```

**In a colored box:**
```html
<div style="background: #f0f8ff; padding: 20px; border-radius: 8px;">
  <h3 style="margin-top: 0;">Financial Health Check</h3>
  [wcf_balance]
</div>
```

---

### [wcf_add_transaction] Examples

**Simple form:**
```
[wcf_add_transaction]
```

**With redirect to thank you page:**
```
[wcf_add_transaction redirect="/thank-you"]
```

**With redirect to same page (to show success message):**
```
[wcf_add_transaction redirect="/submit-expense"]
```

**With instructions:**
```html
<div class="expense-submission">
  <h2>Submit Your Expense</h2>
  
  <div class="instructions">
    <h3>Before You Submit:</h3>
    <ul>
      <li>Have your receipt ready for reference</li>
      <li>Use clear, specific descriptions</li>
      <li>Choose the appropriate category</li>
      <li>Enter the exact amount from your receipt</li>
    </ul>
  </div>
  
  [wcf_add_transaction]
</div>
```

---

### [wcf_summary] Examples

**Complete summary:**
```
[wcf_summary]
```

**Only income summary:**
```
[wcf_summary type="income"]
```

**Only expense summary:**
```
[wcf_summary type="expense"]
```

**With custom styling:**
```html
<div class="financial-summary-box">
  <h2>Financial Overview</h2>
  [wcf_summary]
</div>

<style>
.financial-summary-box {
  background: white;
  padding: 30px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  border-radius: 8px;
}
</style>
```

---

## Advanced Combinations

### Multi-Column Layout

```html
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
  <!-- Left Column - Balance -->
  <div>
    <h2>Quick Stats</h2>
    [wcf_balance]
  </div>
  
  <!-- Right Column - Transactions -->
  <div>
    <h2>Recent Activity</h2>
    [wcf_transaction_list limit="10"]
  </div>
</div>
```

### Tabbed Interface (requires custom JavaScript)

```html
<div class="finance-tabs">
  <button class="tab-btn active" onclick="showTab('overview')">Overview</button>
  <button class="tab-btn" onclick="showTab('income')">Income</button>
  <button class="tab-btn" onclick="showTab('expenses')">Expenses</button>
</div>

<div id="overview" class="tab-content active">
  [wcf_summary]
</div>

<div id="income" class="tab-content">
  <h3>Income Transactions</h3>
  [wcf_transaction_list type="income" limit="20"]
</div>

<div id="expenses" class="tab-content">
  <h3>Expense Transactions</h3>
  [wcf_transaction_list type="expense" limit="20"]
</div>

<script>
function showTab(tabName) {
  // Hide all tabs
  document.querySelectorAll('.tab-content').forEach(tab => {
    tab.classList.remove('active');
  });
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.classList.remove('active');
  });
  
  // Show selected tab
  document.getElementById(tabName).classList.add('active');
  event.target.classList.add('active');
}
</script>

<style>
.tab-content { display: none; }
.tab-content.active { display: block; }
.tab-btn { padding: 10px 20px; margin-right: 5px; cursor: pointer; }
.tab-btn.active { background: #2271b1; color: white; }
</style>
```

---

## Custom Styling Examples

### Custom CSS for Tables

Add this to your theme's Custom CSS:

```css
/* Make transaction tables more colorful */
.wcf-table {
  border: 2px solid #2271b1;
}

.wcf-table th {
  background: #2271b1;
  color: white;
}

.wcf-table tr:hover {
  background: #f0f8ff;
}
```

### Custom Balance Box Styling

```css
/* Style the balance display as a card */
.wcf-balance {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.wcf-balance .wcf-balance-label {
  color: rgba(255,255,255,0.9);
}

.wcf-balance .wcf-balance-value {
  color: white;
  font-size: 2em;
}
```

---

## WordPress Block Editor (Gutenberg) Examples

### Using Shortcode Block

1. Add a new block
2. Search for "Shortcode"
3. Enter your shortcode:
```
[wcf_balance]
```

### Using HTML Block for Complex Layouts

1. Add an "HTML" block
2. Paste your template:
```html
<div class="my-finances">
  <h2>Financial Dashboard</h2>
  [wcf_balance]
  [wcf_transaction_list limit="10"]
</div>
```

---

## Page Builder Compatibility

### Elementor
1. Add a "Shortcode" widget
2. Paste your shortcode
3. Style the widget container as needed

### Beaver Builder
1. Add a "HTML" module
2. Insert your shortcode
3. Adjust module settings

### Divi
1. Add a "Code" module
2. Insert your shortcode
3. Configure design settings

---

## Common Scenarios

### Annual Meeting Report

```html
<h1>Annual Financial Report 2024</h1>

<p>Presented at the Annual General Meeting - December 2024</p>

<h2>Year in Review</h2>
[wcf_balance]

<h2>Major Income Sources</h2>
[wcf_summary type="income"]

<h2>Expenditures by Category</h2>
[wcf_summary type="expense"]

<h2>All Transactions This Year</h2>
[wcf_transaction_list limit="100"]
```

### Monthly Newsletter Snippet

```html
<h3>💰 Financial Update</h3>
<p>Here's where we stand this month:</p>
[wcf_balance show_details="no"]
<p><a href="/finances">View full financial report →</a></p>
```

### Event Budget Tracking

```html
<h1>Summer Festival Budget</h1>

<h2>Event Finances</h2>
[wcf_balance]

<p><em>Filtering to show only Summer Festival related transactions</em></p>

<h3>Event Income</h3>
[wcf_transaction_list type="income" limit="20"]

<h3>Event Expenses</h3>
[wcf_transaction_list type="expense" limit="20"]
```

---

## Tips for Best Results

1. **Test First:** Try shortcodes on a test page before going live
2. **Combine Strategically:** Mix shortcodes with your own HTML for better presentation
3. **Use Headings:** Add context with headings above each shortcode
4. **Consider Mobile:** Test how layouts look on mobile devices
5. **Add Explanations:** Help visitors understand what they're seeing
6. **Update Regularly:** Keep transaction data current for accurate displays
7. **Limit Wisely:** Don't show too many transactions at once (10-20 is usually good)

---

**Need More Help?** Check the USER-GUIDE.md for detailed documentation.

**Plugin Version:** 1.0.0  
**Last Updated:** December 2024