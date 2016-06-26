<div class="js-delete-contact-modal js-modal modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Delete Contact</h4>
			</div>
			<div class="js-contact-delete modal-body">
				<p class="lead">Are you sure you want to delete this contact?</p>
				<?= form_open('api/contact/delete', array('class' => 'js-form-delete', 'role' => 'form')); ?>
				<?= form_input(array(
					'type'  => 'hidden',
					'name'  => 'contactId',
					'class' => 'js-input js-contactId',
				)); ?>
				<?= form_close(); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="js-submit btn btn-primary" data-target-form=".js-form-delete">Delete</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->