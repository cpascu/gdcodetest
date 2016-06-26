/**
 * Contacts Module, displays, adds, edits, deletes, and searches for contacts.
 *
 * @author  Cosmin Pascu <csmnpsc@gmail.com>
 */
(function(){
	$(document).ready(function() {
		var ContactsModule = function () {
			var self       = this;
			/* The array of active contacts in the list */
			self.contacts  = window.base.contacts;
			self.templates = {
				contact: "<tr class='js-edit' data-contact-id='[[contactId]]'><td class='js-delete'>X</td><td>[[name]]</td><td>[[surname]]</td><td>[[email]]</td><td>[[phone]]</td></tr>",
			}

			// submit the modal form
			$('.js-submit').click(function() {
				var $form = $($(this).data('target-form'));
				self.submitForm($form);
			});

			// open the edit contact modal
			$('.js-contact-list').on('click', '.js-edit', function () {
				self.refreshForm($(this).index(), 'edit');
				$('.js-form-edit').data('acting-index', $(this).index());
			});

			// open the delete contact modal
			$('.js-contact-list').on('click', '.js-delete', function (e) {
				e.stopPropagation();

				self.refreshForm($(this).parent().index(), 'delete');
				$('.js-form-delete').data('acting-index', $(this).parent().index());
			});

			// add a custom field to the form
			$('.js-add-custom').click(function() {
				$hiddenCustomFields = $(this).parent().parent().find('.js-custom.hidden')
				$hiddenCustomFields.first().removeClass('hidden');

				if ($hiddenCustomFields.length < 2) {
					$(this).remove();
				}
			});

			self.refreshContactList();
		}

		/**
		 * Refreshes the contacts list based on whatever is in self.contacts
		 *
		 * @return void
		 */
		ContactsModule.prototype.refreshContactList = function() {
			var self     = this,
			$contactList = $('.js-contact-list');

			// wipe list
			$contactList.html('');

			// repaint list
			for (var i in self.contacts) {
				//TODO: strip out [[]] from contact field values, because they will break the replace
				var html = self.templates.contact;
				html     = html.replace('[[contactId]]', self.contacts[i].contactId);

				if ('undefined' !== typeof self.contacts[i].name && self.contacts[i].name) {
					html = html.replace('[[name]]', self.contacts[i].name);
				} else {
					html = html.replace('[[name]]', '');
				}

				if ('undefined' !== typeof self.contacts[i].surname && self.contacts[i].surname) {
					html = html.replace('[[surname]]', self.contacts[i].surname);
				} else {
					html = html.replace('[[surname]]', '');
				}

				if ('undefined' !== typeof self.contacts[i].email && self.contacts[i].email) {
					html = html.replace('[[email]]', self.contacts[i].email);
				} else {
					html = html.replace('[[email]]', '');
				}

				if ('undefined' !== typeof self.contacts[i].phone && self.contacts[i].phone) {
					html = html.replace('[[phone]]', self.contacts[i].phone);
				} else {
					html = html.replace('[[phone]]', '');
				}

				$contactList.append(html);
			}
		}

		/**
		 * Updates the modal form with corresponding data from active contact from self.contacts
		 *
		 * @param  Number actingIdx The index of the contact in the self.contacts array
		 * @param  String type      The type of form (edit|delete)
		 *
		 * @return void
		 */
		ContactsModule.prototype.refreshForm = function (actingIdx, type) {
			var self = this;

			if ('undefined' !== typeof self.contacts[actingIdx]) {
				var contact = self.contacts[actingIdx],
				$modal      = $('.js-' + type + '-contact-modal');

				for (var i in contact) {
					var $fieldGroup = $modal.find('.js-' + i);
					if ('contactId' === i) {
						$fieldGroup.val(contact[i]);
						continue;
					}
					if ($fieldGroup.length > 0 && null !== contact[i]) {
						$fieldGroup.removeClass('hidden').find('.js-input').val(contact[i]);
					}
				}

				$modal.modal('show');
			}
		}

		/**
		 * General form submission.
		 *
		 * @param  Object $form The jQuery object containing the form.
		 *
		 * @return void
		 */
		ContactsModule.prototype.submitForm = function($form) {
			var self    = this,
			data        = $form.serialize(),
			path        = $form.attr('action');

			// create account
			$.post(path, data, function(response) {
				$modal = $('.js-modal.in');
				$modal.find('.has-error').removeClass('has-error');

				if (response.success) {
					self.syncContactList($form, $form.data('acting-index'));
					$form.removeData('acting-index');

					self.refreshContactList();
					$modal.modal('hide');
				}
				else
				{
					// show the errors on the form
					for (var i in response.errors) {
						var $group = $modal.find('.js-' + i);
						$group.addClass('has-error');
						$group.find('.help-block').remove();
						$group.append('<span class="help-block">' + response.errors[i] + '</span>')
					}
				}
			});
		}

		/**
		 * Make updates to self.contacts based on form data.
		 *
		 * @param  Object $form     The jQuery object containing the form.
		 * @param  Number pushToIdx The index of the contact in self.contacts that we should update (can be empty for add new)
		 *
		 * @return Boolean          True if successful, false otherwise.
		 */
		ContactsModule.prototype.syncContactList = function($form, pushToIdx) {
			var self  = this,
			data      = $form.serializeArray(),
			contact   = {},
			pushToIdx = 'undefined' !== typeof pushToIdx ? pushToIdx : false;

			// its holding only the contactId, after a successful delete
			if (data.length === 1 && false !== pushToIdx) {
				self.contacts.splice(pushToIdx, 1);
				return true;
			}

			for (var i in data) {
				if (data[i].value.length > 0) {
					contact[data[i].name] = data[i].value;
				}
			}

			if (!$.isEmptyObject(contact)) {
				if (false === pushToIdx) {
					self.contacts.push(contact);
				} else {
					self.contacts[pushToIdx] = contact;
				}

				return true;
			}

			return false;
		}

		var contactsModule = new ContactsModule();
	});
})(jQuery);