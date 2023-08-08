<?php

/**
 * 
 * Moduł RMA do programu ntsn.serwis
 *
 * Copyright ntsn sp. z o.o.
 * Grzegorz Bizon <grzegorz.bizon@ntsn.pl>
 *
 */

require('app/RMA.php');
use ntsn\RMA;

try {

	$rma = new RMA();
	$rma->ajax();
	$content = $rma->handle();

} catch(Exception $e) {

	$content = '<div class="well text-center" style="margin-top: 50px;">
				<h3>Wykryto błąd. Skontaktuj się z administratorem serwisu.</h3> 
				<br /><br /> 
				Kod błędu: '. $e->getMessage() .'</div>';
}

$rma->render('layout', array('content' => $content, 'config.sample.php' => $config));
