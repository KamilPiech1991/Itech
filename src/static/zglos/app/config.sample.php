<?php

/**
 * 
 * Moduł online (RMA) do programu ntsn.serwis
 *
 * Copyright 2014-2015 ntsn sp. z o.o.
 * Grzegorz Bizon <grzegorz.bizon@ntsn.pl>
 *
 */

$config = new \stdClass();

  /* Wersja modułu online oraz kompatybilna wersja ntsn.serwis */
$config->module_version = '0.3';
$config->compatibility_version = '1.24';

	/* Nazwa firmy */
$config->company = 'iTech Creative Apple Service';
$config->keywords = '';
$config->description = '';
$config->logo_src = null;

  /* Opcjonalne dane, które będą wykorzystane w kolejnych wersjach modułu RMA
$config->contact_company = '';
$config->contact_address = '';
$config->contact_phone = '';
$config->contact_email = '';
  */

  /* Konfiguracja bazy danych */
$config->database_host = 'serwer1404131.home.pl';
$config->database_port = 3306; // port
$config->database_user = '15989005_lakom';
$config->database_password = '_zhF8B9';
$config->database_name = '15989005_lakom';

  /* Numer statusu naprawy z tabeli statusesconf (pole iStatusId z bazy danych)  */
$config->new_repair_status_id = 1;  
  /* Numer statusu sprzętu z tabeli hwstatusesconf(pole iStatusId z bazy danych)  */
$config->new_hardware_status_id = 1;
  /* Numer użytkownika ntsn.serwis z tabeli users (pole iId z bazy danych)  */
$config->rma_user_id = 1;
