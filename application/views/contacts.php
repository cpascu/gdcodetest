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
	<button class="js-new-contact">New Contact</button>
	<div class="js-contact-list"></div>
	<div class="js-contact-add">
		<?= form_open('api/contact/add', array('class' => 'js-form-add')); ?>
		<div>
		<?= form_input(array(
			'name'        => 'name',
			'class'       => 'js-input js-name',
			'placeholder' => 'Name'
		)); ?>
		</div><div>
		<?= form_input(array(
			'name'        => 'surname',
			'class'       => 'js-input js-surname',
			'placeholder' => 'Surname'
		)); ?>
		</div><div>
		<?= form_input(array(
			'name'        => 'email',
			'class'       => 'js-input js-email',
			'placeholder' => 'Email'
		)); ?>
		</div><div>
		<?= form_input(array(
			'name'        => 'phone',
			'class'       => 'js-input js-phone',
			'placeholder' => 'Phone'
		)); ?>
		</div><div>
		<?= form_submit(array(
			'name'  => 'submit',
			'class' => 'js-submit',
			'value' => 'Add',
		)); ?>
		</div>
		<?= form_close(); ?>
	</div>
	
	<script type="text/javascript" src="/assets/bower_components/jquery/dist/jquery.js"></script>
	<script type="text/javascript" src="/assets/bower_components/bootstrap/dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="/assets/js/contacts.js"></script>
</body>
</html>