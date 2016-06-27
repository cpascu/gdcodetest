<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".js-add-contact-modal">
	New Contact
</button>
<a href='/logout' class='btn btn-default'>Logout</a>

<div class="js-add-contact-modal js-modal modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add Contact</h4>
			</div>
			<div class="js-contact-add modal-body">
				<?= form_open('api/contact/add', array('class' => 'js-form-add', 'role' => 'form')); ?>
				<div class="js-name form-group">
						<?= form_input(array(
							'name'        => 'name',
							'class'       => 'js-input form-control',
							'placeholder' => 'Name'
						)); ?>	
				</div>
				<div class="js-surname form-group">
					<?= form_input(array(
						'name'        => 'surname',
						'class'       => 'js-input form-control',
						'placeholder' => 'Surname'
					)); ?>
				</div>
				<div class="js-email form-group">
					<?= form_input(array(
						'name'        => 'email',
						'class'       => 'js-input form-control',
						'placeholder' => 'Email'
					)); ?>
				</div>
				<div class="js-phone form-group">
					<?= form_input(array(
						'name'        => 'phone',
						'class'       => 'js-input form-control',
						'placeholder' => 'Phone'
					)); ?>
				</div>
				<div class="js-custom1 js-custom form-group hidden">
					<div class="input-group">
						<?= form_input(array(
							'name'        => 'custom1',
							'class'       => 'js-input form-control',
							'placeholder' => 'Custom Field'
						)); ?>
						<span class="input-group-addon"><span class="js-remove-custom glyphicon glyphicon-minus" aria-hidden="true"></span></span>
					</div>
				</div>
				<div class="js-custom2 js-custom form-group hidden">
					<div class="input-group">
						<?= form_input(array(
							'name'        => 'custom2',
							'class'       => 'js-input form-control',
							'placeholder' => 'Custom Field'
						)); ?>
						<span class="input-group-addon"><span class="js-remove-custom glyphicon glyphicon-minus" aria-hidden="true"></span></span>
					</div>
				</div>
				<div class="js-custom3 js-custom form-group hidden">
					<div class="input-group">
						<?= form_input(array(
							'name'        => 'custom3',
							'class'       => 'js-input form-control',
							'placeholder' => 'Custom Field'
						)); ?>
						<span class="input-group-addon"><span class="js-remove-custom glyphicon glyphicon-minus" aria-hidden="true"></span></span>
					</div>
				</div>
				<div class="js-custom4 js-custom form-group hidden">
					<div class="input-group">
						<?= form_input(array(
							'name'        => 'custom4',
							'class'       => 'js-input form-control',
							'placeholder' => 'Custom Field'
						)); ?>
						<span class="input-group-addon"><span class="js-remove-custom glyphicon glyphicon-minus" aria-hidden="true"></span></span>
					</div>
				</div>
				<div class="js-custom5 js-custom form-group hidden">
					<div class="input-group">
						<?= form_input(array(
							'name'        => 'custom5',
							'class'       => 'js-input form-control',
							'placeholder' => 'Custom Field'
						)); ?>
						<span class="input-group-addon"><span class="js-remove-custom glyphicon glyphicon-minus" aria-hidden="true"></span></span>
					</div>
				</div>
				<button type="button" class="js-add-custom btn btn-default" aria-label="Left Align">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				</button>
				<?= form_close(); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="js-submit btn btn-primary" data-target-form=".js-form-add">Add</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->