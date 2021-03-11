<?php
	defined('CHECKENV')  		OR define('CHECKENV', 'PROD');
	defined('SSLPREFIX')  		OR define('SSLPREFIX', 'https://');
	defined('TESTMODE')  		OR define('TESTMODE','N');
	//Redirect Login
	defined('REDIRECTENABLED')  OR define('REDIRECTENABLED',true);
	defined('REDIRECTLOGIN')  	OR define('REDIRECTLOGIN','https://uat-flow.pmk.local/login');
	defined('PHARPGCONNECT')	OR define('PHARPGCONNECT', array(
																'host' => 'db1.telecorp.co.th', 
																'user' => 'interndev', 
																'pass' => 'P@11681168',
																'db' => 'Q_QueuePharCashPMKDB'
														));	
	defined('DASHBOARDPHARCASH')OR define('DASHBOARDPHARCASH','https://uat-dashqueue.pmk.local/pharcashapp');
	
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