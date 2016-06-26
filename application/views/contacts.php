<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Genesis Digital - Address Book</title>

	<link rel="stylesheet" type="text/css" href="/assets/bower_components/bootstrap/dist/css/bootstrap.css">
	<?php $this->load->view('third_party/facebook'); ?>

	<script type="text/javascript">
		<? if (!empty($js)) : ?>
			var base = JSON.parse('<?= addslashes(json_encode($js)); ?>');
		<? endif; ?>
	</script>
</head>
<body>
	<br />
	<div class="container">
		<div class="row">
			<div class="col-xs-6">
				<? $this->load->view('partials/form_add_contact'); ?>
				<? $this->load->view('partials/form_edit_contact'); ?>
				<? $this->load->view('partials/form_delete_contact'); ?>
			</div>
			<div class="col-xs-6">
				<div class="form-group pull-right">
					<input class="js-search search form-control" type='text' placeholder="Search" />	
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<? $this->load->view('partials/contact_list'); ?>	
			</div>
		</div>	
	</div>
	
	<script type="text/javascript" src="/assets/bower_components/jquery/dist/jquery.js"></script>
	<script type="text/javascript" src="/assets/bower_components/bootstrap/dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="/assets/js/contacts.js"></script>
</body>
</html>