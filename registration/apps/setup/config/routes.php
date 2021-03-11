<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Test_pm/redirect_index';

$route['(.*)/Test_pm/(:any)/(:any)/(:any)/(:any)'] = 'Test_pm/$2/$3/$4/$5';
$route['(.*)/Test_pm/(:any)/(:any)/(:any)'] = 'Test_pm/$2/$3/$4';
$route['(.*)/Test_pm/(:any)/(:any)'] = 'Test_pm/$2/$3';
$route['(.*)/Test_pm/(:any)'] = 'Test_pm/$2';
$route['(.*)/Test_pm'] = 'Test_pm/redirect_index';
$route['(.*)'] = 'Test_pm/redirect_index';
/*
$route['(.*)/Websocket/SocketConnection']='Websocket/SocketConnection';
$route['(.*)/Test/index']='Test/index';

$route['(.*)/Scanner/PIDScanner']   = 'Scanner/PIDScanner';

$route['(.*)/StepProcessing/PersonType']            = 'StepProcessing/PersonType';

$route['(.*)/StepProcessing/CheckPayor']            = 'StepProcessing/CheckPayor';
$route['(.*)/StepProcessing/Appointment']           = 'StepProcessing/Appointment';
$route['(.*)/StepProcessing/ProcessService']        = 'StepProcessing/ProcessService';
$route['(.*)/StepProcessing/ProcessServiceClear']   = 'StepProcessing/ProcessServiceClear';
$route['(.*)/StepProcessing/Slip']                  = 'StepProcessing/Slip';

$route['(.*)/welcome']          = 'welcome';
*/

$route['404_override']          = 'Test_pm/redirect_index';
$route['translate_uri_dashes']  = FALSE;
