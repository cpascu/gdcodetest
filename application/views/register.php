<div class="container">
	<div class="row">
		<div class="col">
			<h1 class="text-center">Register</h1>
			<br />
		</div>
	</div>
	<div class="row">
		<div class="col-xs-offset-3 col-xs-6">
			<?= form_open('api/register', array('class' => 'js-auth', 'role' => 'form')); ?>
				<div class="js-username form-group">
					<?= form_input(array(
						'name'        => 'username',
						'class'       => 'js-input form-control',
						'placeholder' => 'Username'
					)); ?>
				</div>
				<div class="js-email form-group">
					<?= form_input(array(
						'name'        => 'email',
						'class'       => 'js-input form-control',
						'placeholder' => 'Email'
					)); ?>
				</div>
				<div class="js-password form-group">
					<?= form_password(array(
						'name'        => 'password',
						'class'       => 'js-input form-control',
						'placeholder' => 'Password'
					)); ?>
				</div>
				<div class="js-passwordConf form-group">
					<?= form_password(array(
						'name'        => 'passwordConf',
						'class'       => 'js-input form-control',
						'placeholder' => 'Confirm Password'
					)); ?>
				</div>
				<div class="form-group">
					<?= form_submit(array(
						'name'  => 'submit',
						'class' => 'js-submit btn btn-success form-control',
						'value' => 'Register',
					)); ?>
				</div>
			<?= form_close(); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-offset-3 col-xs-6">
			<p class="text-center">Already have an account? <a href="/login">Login</a> now.</p>
		</div>
	</div>
</div>