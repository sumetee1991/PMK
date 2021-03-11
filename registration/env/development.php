<?php
	defined('CHECKENV')  		OR define('CHECKENV', 'DEV');
	defined('SSLPREFIX')  		OR define('SSLPREFIX', 'http://');
	defined('TESTMODE')  		OR define('TESTMODE','Y');
	//Main Node Server	
	defined('LINKURL')  		OR define('LINKURL','localhost');
	defined('PORTAPP')  		OR define('PORTAPP','');
	defined('PORTMID')  		OR define('PORTMID','9000');
	defined('MIDPREFIX')       	OR define('MIDPREFIX','http://');
	defined('MIDURI')       	OR define('MIDURI','');
	defined('MIDURL')       	OR define('MIDURL',LINKURL.(defined('PORTMID')&&PORTMID?':'.PORTMID:'') );
	defined('SOCKETURL')		OR define('SOCKETURL','io.connect("'.MIDURL.'",{secure:true})');
	//Sound/Print Node Server
	defined('CURLURL')  		OR define('CURLURL','http://27.254.59.21:9200');
	//Redirect Login
	defined('REDIRECTENABLED')  OR define('REDIRECTENABLED',false);
	defined('REDIRECTLOGIN')  	OR define('REDIRECTLOGIN','');
	defined('PGCONNECT')		OR define('PGCONNECT', array(
																'host' => 'db1.telecorp.co.th', 
																'user' => 'interndev', 
																'pass' => 'P@11681168',
																'db' => 'Q_RegisterQDB'
															)
														);
	//MOCK API
	defined('APIURL')			OR define('APIURL','http://localhost:4001/ords/pmkords/hlab'); //GET
	defined('PATIENTAPI')		OR define('PATIENTAPI',APIURL.'/patient'); //GET
	defined('APPOINTMENTAPI')	OR define('APPOINTMENTAPI',APIURL.'/appointment'); //GET
	defined('VISITAPI')			OR define('VISITAPI',APIURL.'/visit'); //GET
	defined('CREDITAPI')		OR define('CREDITAPI',APIURL.'/credit'); //GET

	error_reporting(-1);
	ini_set('display_errors', 1);
?>