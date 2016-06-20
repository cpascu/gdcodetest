(function($){
	$(document).ready(function() {
		$('.js-auth').submit(function () {
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
	});
})(jQuery);