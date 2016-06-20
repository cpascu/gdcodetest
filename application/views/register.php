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
	<?= form_open('api/register', array('class' => 'js-auth')); ?>
	<div>
	<?= form_input(array(
		'name'        => 'username',
		'class'       => 'js-input js-username',
		'placeholder' => 'Username'
	)); ?>
	</div><div>
	<?= form_input(array(
		'name'        => 'email',
		'class'       => 'js-input js-email',
		'placeholder' => 'Email'
	)); ?>
	</div><div>
	<?= form_password(array(
		'name'        => 'password',
		'class'       => 'js-input js-password',
		'placeholder' => 'Password'
	)); ?>
	</div><div>
	<?= form_password(array(
		'name'        => 'passwordConf',
		'class'       => 'js-input js-passwordConf',
		'placeholder' => 'Confirm Password'
	)); ?>
	</div><div>
	<?= form_submit(array(
		'name'  => 'submit',
		'class' => 'js-submit',
		'value' => 'Register',
	)); ?>
	</div>
	<?= form_close(); ?>

	<script type="text/javascript" src="/assets/bower_components/jquery/dist/jquery.js"></script>
	<script type="text/javascript" src="/assets/bower_components/bootstrap/dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="/assets/js/auth.js"></script>
</body>
</html>