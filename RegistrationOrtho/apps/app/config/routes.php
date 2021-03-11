<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Management/index';

$route['(.*)/Management/(:any)/(:any)/(:any)/(:any)'] = 'Management/$2/$3/$4/$5';
$route['(.*)/Management/(:any)/(:any)/(:any)'] = 'Management/$2/$3/$4';
$route['(.*)/Management/(:any)/(:any)'] = 'Management/$2/$3';
$route['(.*)/Management/(:any)'] = 'Management/$2';

$route['(.*)/Websocket/(:any)/(:any)/(:any)'] = 'Websocket/$2/$3/$4';
$route['(.*)/Websocket/(:any)/(:any)'] = 'Websocket/$2/$3';
$route['(.*)/Websocket/(:any)'] = 'Websocket/$2';

$route['(.*)/TestJWT/(:any)'] = 'TestJWT/$2';

$route['(.*)'] = 'Management/index';

/*
$route['(.*)/welcome'] = 'welcome';
$route['(.*)/Management/locationAvailable_JSON/(:num)'] = 'Management/locationAvailable_JSON/$2';
$route['(.*)/Management/getSetupData_JSON'] = 'Management/getSetupData_JSON/';
$route['(.*)/Management/Dashboard'] = 'Management/Dashboard';
$route['(.*)/Management/AltDashboard'] = 'Management/AltDashboard';
$route['(.*)/Websocket/socketManage'] = 'Websocket/socketManage';
$route['(.*)/Websocket/connectSocket'] = 'Websocket/connectSocket';
$route['(.*)/Websocket/render'] = 'Websocket/render';
$route['(.*)/Scanner/PIDScanner'] = 'Scanner/PIDScanner';
$route['(.*)/TestJWT/refreshToken'] = 'TestJWT/refreshToken';
*/
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
