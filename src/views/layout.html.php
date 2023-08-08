<?php

/**
 * 
 * Moduł RMA do programu ntsn.serwis
 *
 * Copyright ntsn sp. z o.o.
 * Grzegorz Bizon <grzegorz.bizon@ntsn.pl>
 *
 */

?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<title>Moduł RMA <?php echo $config->company ?> </title>
	<meta charset="utf-8" />
	<meta name="description" content="<?php echo $config->description ?>" />
	<meta name="keywords" content="<?php echo $config->keywords ?>" />
	<meta name="author" content="Oprogramowanie do serwisu -- ntsn sp. z o.o. -- http://serwis.ntsn.pl">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/bootflat/css/bootflat.min.css">
	<link rel="stylesheet" type="text/css" href="assets/validator/css/bootstrapValidator.min.css">
	<script src="assets/jquery/jquery-1.11.0.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/bootflat/js/icheck.min.js"></script>
	<script src="assets/validator/js/bootstrapValidator.min.js"></script>
	<script src="assets/validator/js/bootstrapValidator_PL.js"></script>
	<script src="assets/coffeescript/coffee-script.js"></script>
	<!--[if lt IE 9]>
	<script src="assets/html5shiv/html5shiv.min.js"></script>
	<![endif]-->
	<style>
		body {
  			font-family: "Nunito", sans-serif;
		}
	</style>
</head>
<body>

	<div class="container-fluid col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
	<?php echo $content ?>
	</div>

</body>
</html>
