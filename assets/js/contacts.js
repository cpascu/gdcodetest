/**
 * @author Kyle Florence <kyle[dot]florence[at]gmail[dot]com>
 * @website https://github.com/kflorence/jquery-deserialize/
 * @version 1.3.3
 *
 * Dual licensed under the MIT and GPLv2 licenses.
 */
!function(e,t){function n(t){return t.map(function(){return this.elements?e.makeArray(this.elements):this}).filter(":input:not(:disabled)").get()}function i(n){var i,a={};return e.each(n,function(e,n){i=a[n.name],i===t&&(a[n.name]=[]),a[n.name].push(n)}),a}var a=Array.prototype.push,o=/^(?:radio|checkbox)$/i,l=/\+/g,r=/^(?:option|select-one|select-multiple)$/i,s=/^(?:button|color|date|datetime|datetime-local|email|hidden|month|number|password|range|reset|search|submit|tel|text|textarea|time|url|week)$/i;e.fn.deserialize=function(c,u){var p,h,m=n(this),f=[];if(!c||!m.length)return this;if(e.isArray(c))f=c;else if(e.isPlainObject(c)){var d,g;for(d in c)e.isArray(g=c[d])?a.apply(f,e.map(g,function(e){return{name:d,value:e}})):a.call(f,{name:d,value:g})}else if("string"==typeof c){var v;for(c=c.split("&"),p=0,h=c.length;h>p;p++)v=c[p].split("="),a.call(f,{name:decodeURIComponent(v[0].replace(l,"%20")),value:decodeURIComponent(v[1].replace(l,"%20"))})}if(!(h=f.length))return this;var y,b,k,w,A,C,x,g,F,$,j,I,L=e.noop,N=e.noop,R={};for(u=u||{},m=i(m),e.isFunction(u)?N=u:(L=e.isFunction(u.change)?u.change:L,N=e.isFunction(u.complete)?u.complete:N),p=0;h>p;p++)if(y=f[p],A=y.name,g=y.value,F=m[A],F&&0!==F.length)if(R[A]===t&&(R[A]=0),j=R[A]++,F[j]&&(b=F[j],x=(b.type||b.nodeName).toLowerCase(),s.test(x)))L.call(b,b.value=g);else for(k=0,w=F.length;w>k;k++)if(b=F[k],x=(b.type||b.nodeName).toLowerCase(),C=null,o.test(x)?C="checked":r.test(x)&&(C="selected"),C){if(I=[],b.options)for($=0;$<b.options.length;$++)I.push(b.options[$]);else I.push(b);for($=0;$<I.length;$++)y=I[$],y.value==g&&L.call(y,(y[C]=!0)&&g)}return N.call(this),this}}(jQuery);
// will use this later to fill edit form


/**
 * Contacts Module
 * @author  Cosmin Pascu <csmnpsc@gmail.com>
 */
(function(){
	$(document).ready(function() {
		var ContactsModule = function () {
			var self       = this;
			self.contacts  = window.base.contacts;
			self.templates = {
				contact: "<div class=''>[[name]], [[email]]</div>",
			}

			$('.js-form-add').submit(function() {
				var $form   = $(this),
				contactsIdx = self.addContact($form) - 1; // add new contact and get location
				
				// refresh the list first, we want screen to update right away
				if (contactsIdx) {
					self.refreshContactList();
				}

				// send data to backend
				self.submitForm($form, contactsIdx);

				return false;
			});
		}

		ContactsModule.prototype.refreshContactList = function() {
			var self     = this,
			$contactList = $('.js-contact-list');

			// wipe list
			$contactList.html('');

			// repaint list
			for (var i in self.contacts) {
				//TODO: strip out [[]] from contact field values, because they will break the replace
				var html = self.templates.contact;
				html     = html.replace('[[name]]', self.contacts[i].name);
				html     = html.replace('[[email]]', self.contacts[i].email);
				$contactList.append(html);
			}
		}

		ContactsModule.prototype.submitForm = function($form, contactsIdx) {
			var self    = this,
			data        = $form.serialize(),
			path        = $form.attr('action'),
			contactsIdx = 'undefined' !== typeof contactsIdx ? contactsIdx : false;

			// create account
			$.post(path, data, function(response) {
				if (response.success) {
					// update contact id
					self.contacts[contactsIdx].contactId = response.contactId;
				}
				else
				{
					// show that there was an error, show retry or delete
					// 
					// just realized this is bad UX... will need to add pthread... bleh
				}
			});
		}

		ContactsModule.prototype.addContact = function($form) {
			var self = this,
			data     = $form.serializeArray(),
			contact  = {};

			for (var i in data) {
				if (data[i].value.length > 0) {
					contact[data[i].name] = data[i].value;
				}
			}

			if (!$.isEmptyObject(contact)) {
				self.contacts.push(contact);

				return self.contacts.length;
			}

			return false;
		}

		var contactsModule = new ContactsModule();
	});
})(jQuery);