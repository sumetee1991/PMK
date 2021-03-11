<?php
	defined('CHECKENV')  		OR define('CHECKENV', 'PROD');
	defined('SSLPREFIX')  		OR define('SSLPREFIX', 'https://');
	defined('TESTMODE')  		OR define('TESTMODE','N');
	//Main Node Server
	defined('LINKURL')  		OR define('LINKURL','dashqueue.pmk.local');//define('LINKURL','191.123.58.36');
	defined('PORTAPP')  		OR define('PORTAPP','');
	defined('PORTMID')  		OR define('PORTMID','9001');
	defined('MIDPREFIX')       	OR define('MIDPREFIX','https://');
	defined('MIDURI')       	OR define('MIDURI','/regisorthosocket/socket.io');//OR define('MIDURI','/socket.io');//
	defined('MIDURL')       	OR define('MIDURL',LINKURL.'/regisorthosocket' );
	//defined('SOCKETURL')		OR define('SOCKETURL','io.connect("'.LINKURL.'/regisorthosocket",{secure:true})');
	defined('SOCKETURL')		OR define('SOCKETURL',"io('dashqueue.pmk.local',{secure:true,path:'/regisorthosocket/socket.io',transports:['polling']})");
	
	defined('APPURLMANAGE')		OR define('APPURLMANAGE', 'https://flow.pmk.local/registration/management' );
	//Sound/Print Node Server
	defined('CURLURL')  		OR define('CURLURL','http://191.123.58.33:9201');
	//Redirect Login
	defined('REDIRECTENABLED')  OR define('REDIRECTENABLED',true);
	defined('REDIRECTLOGIN')  	OR define('REDIRECTLOGIN','https://flow.pmk.local/login');
	defined('PGCONNECT')		OR define('PGCONNECT', array(
																'host' => 'db1.telecorp.co.th', 
																'user' => 'interndev', 
																'pass' => 'P@11681168',
												                'db' => 'Q_RegisterQDB_Ortho'
															)
														);
	 defined('PHARPGCONNECT') OR define('PHARPGCONNECT', array(
                'host' => '191.123.58.47', 
                'user' => 'queueregis', 
                'pass' => 'P@ssw0rd1168', 
                'db' => 'QueuePharCashPMKDB'
               )
              );
	 defined('DASHBOARDPHARCASH')OR define('DASHBOARDPHARCASH','https://pmk.express-apps.com/pharcashapp');
	//H-LAB API
	defined('APIURL')			OR define('APIURL','http://191.123.95.38:8181/ords/pmkords/hlab');
	defined('PATIENTAPI')		OR define('PATIENTAPI',APIURL.'/patient');
	defined('APPOINTMENTAPI')	OR define('APPOINTMENTAPI',APIURL.'/appointment');
	defined('VISITAPI')			OR define('VISITAPI',APIURL.'/visit/');
	defined('CREDITAPI')		OR define('CREDITAPI',APIURL.'/credit'); //GET
	

	error_reporting(-1);
	ini_set('display_errors', 1);
	/*
	ini_set('display_errors', 0);
	if (version_compare(PHP_VERSION, '5.3', '>='))
	{
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
	}
	else
	{
		error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
	}
	*/
?>