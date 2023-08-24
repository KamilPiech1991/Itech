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
require_once('app/config.sample.php');

/**
 * Class: Service
 *
 */
class Service {

	protected $config;
	protected static $db;
	private static $dsn;

	/**
	 * Service constructor
	 *
	 * Get config and request connection
	 *
	 */
	function __construct() {

		global $config;
		$this->config = $config;

		self::$dsn = 'mysql:host='. $config->database_host .';port='. 
		      $config->database_port .';dbname='. $config->database_name .
		      ';charset=utf8';

		self::connect($config->database_user, $config->database_password);

	}

	/**
	 * Connect to database
	 *
	 * @param string $user Database username
	 * @param string $password Database password
	 */
	private static function connect($user, $password) {

		self::$db = new \PDO(self::$dsn, $user, $password );
    self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    // Uncomment in older PHP versions that ignore charset=utf8 dsn option
    // self::$db->query('SET NAMES utf8'); 

	}

	/**
	 * Get fields describing hardware from database
	 *
	 * @return array
	 */
	protected function getHardwareFields() {

		$s = self::$db->query('SELECT * FROM fieldsconf WHERE sValue != ""');
		return $s->fetchAll();

	}

	/**
	 * Get hardware types from database
	 *
	 * @return array
	 */
	protected function getHardwareTypes() {
		
		$s = self::$db->query('SELECT * FROM typesconf ORDER BY iOrder ASC');
		return $s->fetchAll();

	}

	/**
	 * Get client ID from database
	 *
	 * @param string $phone Client phone
	 * @param string $name Client last name
	 * @return array
	 */
	protected function getClientId($phone, $name) {

                $phone = preg_replace('/\D/', '', $phone);
                if (empty($phone) === true) {
                        return array();
                }
                $phone = '^[^0-9]*' . implode('[^0-9]*', str_split($phone)) . '[^0-9]*$';

		$s = self::$db->prepare('SELECT iId FROM clients WHERE sPhone REGEXP :phone AND sSName = :name LIMIT 1');
		$s->execute(array(':phone' => $phone, ':name' => $name));

		return $s->fetch();

	}

	/**
	 * Get repair number, by schema saved in database
	 *
	 * @param integer $id
	 * @return string
	 */
	private function getRepairNum() {

		$s = self::$db->query('SELECT sValue AS format FROM settings WHERE sKey = "numbering" LIMIT 1');
		$schema = $s->fetch();
		
		$date = new \DateTime('now');
		if (! isset($schema['format']))
			return $date->format('dm');
			
		$schema = $schema['format'];
		$search = array('{DAY1}', '{DAY2}', '{MONTH1}', '{MONTH2}', '{YEAR2}', '{YEAR4}', '{INITIALS}');
		$replace = array(
					$date->format('j'),  // {DAY1}
					$date->format('d'),  // {DAY2}
					$date->format('n'),  // {MONTH1} 
					$date->format('m'),  // {MONTH2}
					$date->format('y'),  // {YEAR2}
					$date->format('Y'),  // {YEAR4}
					'RMA',  	     // {INITIALS}
				);		

		return str_replace($search, $replace, $schema);
	}

	/**
	 * Save new repair to database
	 *
	 * @param array $client
	 * @param array $hardware
	 * @param array $repair
	 * @return string|bool
	 */
	protected function saveNewRepair($client, $hardware, $repair ) {
		
		if (! isset($client['iId'])) {

			$s = self::$db->prepare('INSERT INTO clients (sFName, sSName, sCompany, sNIP, sStreet,
						  sAddrBuild, sAddrLoc, sCity, sPostal, sEmail, sEmail2, sPhone, sPhone2, sDescription)
						 VALUES (:sFName, :sSName, :sCompany, :sNIP, :sStreet,
                                                  :sAddrBuild, :sAddrLoc, :sCity, :sPostal, :sEmail, "", :sPhone, "", "")');
			array_walk($client, function($item, &$key) { $key = ':' . $key; });
			$s->execute($client);
			$client['iId'] = self::$db->lastInsertId();

		}

		$s = self::$db->prepare('INSERT INTO hardware (sHName, iHType, iStoreStatus, iReceivedDate, sStoreComment, sField1, sField2,
					  sField3, sField4, sField5, sField6, sField7, sField8, sField9, sField10, sField11, sField12, 
					  sField13, sField14, iFieldDate, sFieldLong, iOwner) 
					 VALUES (:sHName, :iHType, :iStoreStatus, :iReceivedDate, :sStoreComment, :sField1, :sField2,
					  :sField3, :sField4, :sField5, :sField6, :sField7, :sField8, :sField9, :sField10, :sField11, :sField12, 
					  :sField13, :sField14, :iFieldDate, :sFieldLong, :iOwner)');
		
		for ($i = 1; $i <= 14; $i++)
			if (! isset($hardware['sField' . $i])) $hardware['sField' . $i] = '';
		if (! isset($hardware['iFieldDate'])) $hardware['iFieldDate'] = 0;
			else $hardware['iFieldDate'] = strtotime($hardware['iFieldDate']);
		if (! isset($hardware['sFieldLong'])) $hardware['sFieldLong'] = '';
		$hardware['iStoreStatus'] = $this->config->new_hardware_status_id;
		$hardware['iReceivedDate'] = 0;
		$hardware['sStoreComment'] = 'Sprzęt wprowadzony przez moduł on-line RMA';
		$hardware['iOwner'] = $client['iId'];

		array_walk($hardware, function($item, &$key) { $key = ':' . $key; });
		$s->execute($hardware);
		$hardware['iId'] = self::$db->lastInsertId();

		$s = self::$db->prepare('INSERT INTO repairs (sNum, iAddDate, iEndDate, iType, sCost, sMCost, sDefect, sSolution, sComment, 
					  sOuterNo, iStatus, iProgress, iClientId, iHardwareId, iSubmitterId, iTechnicanId)
					 VALUES (:sNum, :iAddDate, :iEndDate, :iType, :sCost, :sMCost, :sDefect, :sSolution, :sComment, 
					 :sOuterNo, :iStatus, :iProgress, :iClientId, :iHardwareId, :iSubmitterId, :iTechnicanId)');

		$repair['sNum'] = $this->getRepairNum();
		$repair['iAddDate'] = time();
		$repair['iEndDate'] = time() + (3600 * 24 * 14);
		$repair['sCost'] = '';
		$repair['sMCost'] = '';
		$repair['sSolution'] = '';
		$repair['sOuterNo'] = '';
		$repair['iStatus'] = $this->config->new_repair_status_id;
		$repair['iProgress'] = 0;
		$repair['iClientId'] = $client['iId'];
		$repair['iHardwareId'] = $hardware['iId'];
		$repair['iSubmitterId'] = $this->config->rma_user_id;
		$repair['iTechnicanId'] = 0;

		array_walk($repair, function($item, &$key) { $key = ':' . $key; });
		$status = $s->execute($repair);
		$repair['iId'] = self::$db->lastInsertId();

		return ($status) ? $repair['iId'] . '/' . $repair['sNum'] : false;

	}

}
