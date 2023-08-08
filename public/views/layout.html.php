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
			overflow-x: hidden
		}
		.mt-3 {
			margin-top: 3em
		}
		.mt-5 {
			margin-top: 5em!important
		}
		.mb-3 {
			margin-bottom: 3em!important
		}
		.main-title {
			margin-bottom: 3em
		}
		.form-wrap {
			padding: 2em;
			background: #f5f7f9
		}
		.form-group label {
			margin-left: 15px
		}
		.form-group input,
		.form-group select,
		.form-group textarea {
			padding: 1.8em 1em;
			border-radius: 25px;
			border: 2px solid #0584d1
		}
		.btn.btn-success,
		.btn.btn-primary {
			display: inline-block;
padding: 1em 3em;
background-color: #4585C8;
border: none;
border-radius: 70px;
font-size: 16px;
font-weight: 500;
text-transform: uppercase;
transition: 0.3s ease-in-out;
text-align: center;
cursor: pointer
		}
		.btn.btn-success:hover,
		.btn.btn-primary:hover {
			background-color: #5C9DE2
		}

		@media(min-width:767px) {
			.form-wrap {
			padding: 5em
		}
		.lines-left {
			position: relative
		}
		.lines-left::before {
			position: absolute;
			top: 0;
			width: 30em;
  content: url("https://itech.dfirma.pl/assets/img/sections/lines-left.png");
  top: 2em;
  left: -3em;
  z-index: -1
}
.lines-left::after {
			position: absolute;
			top: 0;
			width: 30em;
  content: url("https://itech.dfirma.pl/assets/img/sections/lines-left.png");
  top: 2em;
  right: -10em;
  z-index: -1
}
		}
	</style>
</head>
<body>

	<div class="main-wrap">
	<?php echo $content ?>
	</div>

</body>
</html>
