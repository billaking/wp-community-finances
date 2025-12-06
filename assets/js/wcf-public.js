/**
 * WP Community Finances - Public JavaScript
 */

(function( $ ) {
	'use strict';

	$(document).ready(function() {
		// Form validation
		$('.bkFin-form').on('submit', function(e) {
			var amount = $('#bkFin_amount').val();
			var description = $('#bkFin_description').val();

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
			$('.bkFin-message').fadeOut('slow');
		}, 5000);

		// Animate numbers on page load
		$('.bkFin-balance-value, .bkFin-summary-amount').each(function() {
			var $this = $(this);
			var text = $this.text();
			
			// Only animate if it contains a dollar amount
			if (text.indexOf('$') !== -1 && text.match(/[\d,]+\.?\d*/)) {
				$this.css('opacity', '0').animate({
					opacity: 1
				}, 600);
			}
		});
	});

})( jQuery );
