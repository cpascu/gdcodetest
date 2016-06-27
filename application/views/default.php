<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>GD Test - <?=$title?></title>

	<link rel="stylesheet" type="text/css" href="/assets/bower_components/bootstrap/dist/css/bootstrap.css">
	<?php $this->load->view('third_party/facebook'); ?>

	<script type="text/javascript">
		<? if (!empty($js)) : ?>
			var base = JSON.parse('<?= addslashes(json_encode($js)); ?>');
		<? endif; ?>
	</script>
</head>
<body>
	<? $this->load->view($pageLayout); ?>

	<script type="text/javascript" src="/assets/bower_components/jquery/dist/jquery.js"></script>
	<script type="text/javascript" src="/assets/bower_components/bootstrap/dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="/assets/js/<?=$mainJs?>.js"></script>
</body>
</html>