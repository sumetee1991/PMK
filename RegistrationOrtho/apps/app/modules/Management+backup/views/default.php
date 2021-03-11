<?php
	defined('CHECKENV')  		OR define('CHECKENV', 'DEFAULT');
	defined('SSLPREFIX')  		OR define('SSLPREFIX', 'http://');
	defined('TESTMODE')  		OR define('TESTMODE','Y');
	//Main Node Server	
	defined('LINKURL')  		OR define('LINKURL','27.254.59.21');
	defined('PORTAPP')  		OR define('PORTAPP','');
	defined('PORTMID')  		OR define('PORTMID','9000');
	defined('MIDURL')       	OR define('MIDURL',LINKURL.(defined('PORTMID')&&PORTMID?':'.PORTMID:'') );
	//Sound/Print Node Server
	defined('CURLURL')  		OR define('CURLURL','http://27.254.59.21:9200');
	//Redirect Login
	defined('REDIRECTENABLED')  OR define('REDIRECTENABLED',false);
	//defined('REDIRECTLOGIN')  	OR define('REDIRECTLOGIN','http://healthyflow.xyz/login');
	defined('PGCONNECT')		OR define('PGCONNECT', array(
																'host' => '27.254.59.21', 
																'user' => 'postgres', 
																'pass' => 'P@ssw0rd1168', 
																'db' => 'registerQDB'
															));
	
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'The application environment is not set correctly.';
?>