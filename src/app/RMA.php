<?php

/**
 * 
 * Moduł RMA do programu ntsn.serwis
 *
 * Copyright ntsn sp. z o.o.
 * Grzegorz Bizon <grzegorz.bizon@ntsn.pl>
 *
 */

namespace ntsn;
require_once('app/Service.php');

/**
 * Class: RMA
 *
 * @see Service
 */
class RMA extends Service{

	/**
	 * Handle requests
	 *
	 * @return string $content
	 */
	public function handle() {

		ob_start();
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {	/* Submitting RMA request */
			

			if (! isset($_POST['client'], $_POST['eclient'], $_POST['hardware'], $_POST['repair']))
				throw new Exception('Incorrect form submission.');

			if ($_POST['eclient']['iId'] > 0) {
				$client_verification = $this->getClientId($_POST['eclient']['sPhone'], $_POST['eclient']['sSName']);
				if ((! false === $client_verification) && $_POST['eclient']['iId'] != $client_verification['iId'])
					throw new Exception('Incorrect client ID.');
			}

			$client = ($_POST['eclient']['iId'] > 0) ? $_POST['eclient'] : $_POST['client'];
			$hardware = $_POST['hardware'];
			$repair = $_POST['repair'];

			$new_repair_id = $this->saveNewRepair($client, $hardware, $repair);

			if (! $new_repair_id)
				throw new Exception('Database error');
			else
				$this->render('confirmation', array('repair_id' => $new_repair_id));


		} else {					/* Rendering RMA form */

			$hardware = array();
			$hardware['types'] = $this->getHardwareTypes();
			$hardware['fields'] = $this->getHardwareFields();
			
			$this->render('form', $hardware);
		}

		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	/**
	 * Handle AJAX requests
	 *
	 */
	public function ajax() {

		if (isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) 
			&& $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
								/* This is AJAX request */

			$client = $this->getClientId($_POST['phone'], $_POST['name']);
			die(json_encode($client));
			
		}
	}

	/**
	 * Render view
	 *
	 * @param string $view
	 * @param array $variables
	 */
	public function render($view, $variables = array()) {

		extract($variables);
		$template = './views/' . $view . '.html.php';
		include($template);

	}
}
