<!DOCTYPE html>
<html>

<head>
	<title><?= (isset($Site_Title) ? $Site_Title : (defined(SITE_TITLE) ? SITE_TITLE : "DashQueue")); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<?= (isset($css) ? assets_css($css) : ''); ?>

	<style>
		@font-face {
			font-family: 'Mitr-Light';
			src: url('<?= staticmain() ?>fonts/Mitr/Mitr-Light.ttf');
		}

		@font-face {
			font-family: 'Lato-Light';
			src: url('<?= staticmain() ?>fonts/Lato/Lato-Light.ttf');
		}

		@font-face {
			font-family: 'CSPraJad-bold';
			src: url('<?= staticmain() ?>fonts/CS_PraJad/CSPraJad-bold.otf');
		}

		.headth {
			font-family: 'Mitr-Light';
		}

		.headen,
		.bodyen {
			font-family: 'Lato-Light';
		}

		.bodyth {
			font-family: 'CSPraJad-bold';
		}
	</style>

	<?= single_js('js/viewport.js'); ?>
</head>

<body>

	<?php
	if (isset($Content) && count($Content) > 0) {
		foreach ($Content as $result) :
			$this->load->view($Module . '/' . $result);
		endforeach;
	}
	?>

	<?= (isset($js) ? assets_js($js) : ''); ?>
	<?= (isset($node_modules) ? assets_node($node_modules) : ''); ?>

	<?php
	if (isset($Script) && count($Script) > 0) {
		foreach ($Script as $result) :
			$this->load->view($Module . '/' . $result);
		endforeach;
	}
	?>

</body>

</html>