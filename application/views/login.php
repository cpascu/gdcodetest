<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Genesis Digital - Address Book</title>

	<link rel="stylesheet" type="text/css" href="/assets/bower_components/bootstrap/dist/css/bootstrap.css">
	<?php $this->load->view('third_party/facebook'); ?>

	<script type="text/javascript">
		<? if (!empty($js)) : ?>
			var base = JSON.parse('<?= json_encode($js); ?>');
		<? endif; ?>
	</script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="text-center">Login</h1>
				<br />
			</div>
		</div>
		<div class="row">
			<div class="col-xs-offset-3 col-xs-6">
				<div type="button" class="js-facebook btn btn-primary btn-block">Facebook</div>
				<br />
			</div>
		</div>
		<div class="row">
			<div class="col-xs-offset-3 col-xs-6">
				<a type="button" href="<?= $githubLogin ?>" class="github btn btn-info btn-block">Github</a>
				<br />
			</div>
		</div>
		<div class="row">
			<div class="col-xs-offset-3 col-xs-6">
				<?= form_open('api/login', array('class' => 'js-auth', 'role' => 'form')); ?>
				<div class="form-group">
					<?= form_input(array(
						'name'        => 'username',
						'class'       => 'js-input js-username form-control',
						'placeholder' => 'Username'
					)); ?>
				</div>
				<div class="form-group">
					<?= form_password(array(
						'name'        => 'password',
						'class'       => 'js-input js-password form-control',
						'placeholder' => 'Password'
					)); ?>
				</div>
				<div class="form-group">
					<?= form_submit(array(
						'name'  => 'submit',
						'class' => 'js-submit btn btn-success form-control',
						'value' => 'Login',
					)); ?>
				</div>
				<?= form_close(); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-offset-3 col-xs-6">
				<p class="text-center">Don't have an account? <a href="/register">Register</a> one now.</p>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="/assets/bower_components/jquery/dist/jquery.js"></script>
	<script type="text/javascript" src="/assets/bower_components/bootstrap/dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="/assets/js/auth.js"></script>
</body>
</html>