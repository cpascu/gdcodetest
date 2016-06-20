(function($){
	$(document).ready(function() {
		$('.js-auth').submit(function() {
			var $form = $('.js-auth'),
			data      = $form.serialize(),
			path      = $form.attr('action');

			// create account
			$.post(path, data, function(response) {
				$('.js-error').remove();

				if ('undefined' !== typeof(response.errors)) {
					for (type in response.errors) {
						$('.js-' + type).after('<div class="js-error error">' + response.errors[type] + '</div>');
					}
				}
			});

			return false;
		});

		$('.js-facebook').click(function() {
			FB.login(function(response) {
				if (response.status === 'connected') {
					$.post(base.siteUrl + 'api/facebook', {}, function(response) {
						console.dir(response);
					});
				} else if (response.status === 'not_authorized') {
					// The person is logged into Facebook, but not your app.
				} else {
					// The person is not logged into Facebook, so we're not sure if
					// they are logged into this app or not.
				}
			}, {scope: 'email'});
		});
	});
})(jQuery);