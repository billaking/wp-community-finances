/**
 * WP Community Finances - Public JavaScript
 */

(function( $ ) {
	'use strict';

	$(document).ready(function() {
		// Form validation
		$('.wcf-form').on('submit', function(e) {
			var amount = $('#wcf_amount').val();
			var description = $('#wcf_description').val();

			if (!amount || parseFloat(amount) <= 0) {
				alert('Please enter a valid amount.');
				e.preventDefault();
				return false;
			}

			if (!description || description.trim() === '') {
				alert('Please enter a description.');
				e.preventDefault();
				return false;
			}
		});

		// Auto-dismiss success messages
		setTimeout(function() {
			$('.wcf-message').fadeOut('slow');
		}, 5000);

		// Animate numbers on page load
		$('.wcf-balance-value, .wcf-summary-amount').each(function() {
			var $this = $(this);
			var text = $this.text();
			
			// Only animate if it's a number
			if (text.match(/\$[\d,]+\.?\d*/)) {
				$this.css('opacity', '0').animate({
					opacity: 1
				}, 600);
			}
		});
	});

})( jQuery );
