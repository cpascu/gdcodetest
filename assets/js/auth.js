(function($){
	$(document).ready(function() {
		// generic form submission, for both login and register
		$('.js-auth').submit(function() {
			var $form = $('.js-auth'),
			data      = $form.serialize(),
			path      = $form.attr('action');

			// create account
			$.post(path, data, function(response) {
				if (response.success) {
					window.location = base.siteUrl + 'contacts';
				} else {
					$('.js-error').remove();

					if ('undefined' !== typeof(response.errors)) {
						for (var type in response.errors) {
							$('.js-' + type).after('<div class="js-error error">' + response.errors[type] + '</div>');
						}
					}
				}
			});

			return false;
		});

		$('.js-facebook').click(function() {
			FB.login(function(response) {
				if (response.status === 'connected') {
					$.post(base.siteUrl + 'api/facebook', {}, function(response) {
						if (response.success) {
							window.location = base.siteUrl + 'contacts';
						} else {
							// TODO: Show general error.
						}
					});
				} else if (response.status === 'not_authorized') {
					// Do nothing, they know what they did.
				} else {
					// Do nothing, they know what they did.
				}
			}, {scope: 'email'});
		});
	});
})(jQuery);