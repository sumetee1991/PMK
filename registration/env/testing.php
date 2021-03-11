<?php
	defined('CHECKENV')  		OR define('CHECKENV', 'TEST');
	defined('SSLPREFIX')  		OR define('SSLPREFIX', 'https://');
	defined('TESTMODE')  		OR define('TESTMODE','Y');
	//Main Node Server	
	defined('LINKURL')  		OR define('LINKURL','pmk.express-apps.com');
	defined('PORTAPP')  		OR define('PORTAPP','');
	defined('PORTMID')  		OR define('PORTMID','9000');
	defined('MIDPREFIX')       	OR define('MIDPREFIX','https://');
	defined('MIDURI')       	OR define('MIDURI','/regissocket/socket.io');
	defined('MIDURL')       	OR define('MIDURL',LINKURL.'/regissocket' );
	defined('SOCKETURL')		OR define('SOCKETURL','io.connect("'.SSLPREFIX.LINKURL.'",{secure:true,path:"'.MIDURI.'"})');
	//Sound/Print Node Server
	defined('CURLURL')  		OR define('CURLURL','https://pmk.express-apps.com/dashboard');
	//Redirect Login
	defined('REDIRECTENABLED')  OR define('REDIRECTENABLED',false);
	defined('REDIRECTLOGIN')  	OR define('REDIRECTLOGIN','');//defined('REDIRECTLOGIN')  	OR define('REDIRECTLOGIN','http://healthyflow.xyz/login');
	defined('PGCONNECT')		OR define('PGCONNECT', array(
																'host' => 'db1.telecorp.co.th', 
																'user' => 'interndev', 
																'pass' => 'P@11681168', 
																'db' => 'Q_RegisterQDB'
															)
														);
	//MOCK API
	defined('APIURL')			OR define('APIURL',MIDURL.'/ords/pmkords/hlab');
	defined('PATIENTAPI')		OR define('PATIENTAPI',APIURL.'/patient');
	defined('APPOINTMENTAPI')	OR define('APPOINTMENTAPI',APIURL.'/appointment');
	defined('VISITAPI')			OR define('VISITAPI',APIURL.'/visit');
	defined('CREDITAPI')		OR define('CREDITAPI',APIURL.'/credit'); //GET
	
	ini_set('display_errors', 0);
	if (version_compare(PHP_VERSION, '5.3', '>='))
	{
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
	}
	else
	{
		error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
	}
?>