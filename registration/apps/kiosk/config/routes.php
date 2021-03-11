<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Scanner/PIDScanner';

$route['(.*)/Scanner/(:any)/(:any)/(:any)/(:any)'] = 'Scanner/$2/$3/$4/$5';
$route['(.*)/Scanner/(:any)/(:any)/(:any)'] = 'Scanner/$2/$3/$4';
$route['(.*)/Scanner/(:any)/(:any)'] = 'Scanner/$2/$3';
$route['(.*)/Scanner/(:any)'] = 'Scanner/$2';

$route['(.*)/StepProcessing/PersonType'] = 'StepProcessing/StepProcessing/PersonType';
$route['(.*)/StepProcessing/(:any)/(:any)/(:any)/(:any)'] = 'StepProcessing/$2/$3/$4/$5';
$route['(.*)/StepProcessing/(:any)/(:any)/(:any)'] = 'StepProcessing/$2/$3/$4';
$route['(.*)/StepProcessing/(:any)/(:any)'] = 'StepProcessing/$2/$3';
$route['(.*)/StepProcessing/(:any)'] = 'StepProcessing/$2';

$route['(.*)/slip/(:any)/(:any)/(:any)/(:any)'] = 'slip/$2/$3/$4/$5';
$route['(.*)/slip/(:any)/(:any)/(:any)'] = 'slip/$2/$3/$4';
$route['(.*)/slip/(:any)/(:any)'] = 'slip/$2/$3';
$route['(.*)/slip/(:any)'] = 'slip/$2';
$route['(.*)/slip/MainPage'] = 'slip/MainPage';

$route['(.*)/cv_api/(:any)/(:any)/(:any)/(:any)'] = 'cv_api/$2/$3/$4/$5';
$route['(.*)/cv_api/(:any)/(:any)/(:any)'] = 'cv_api/$2/$3/$4';
$route['(.*)/cv_api/(:any)/(:any)'] = 'cv_api/$2/$3';
$route['(.*)/cv_api/(:any)'] = 'cv_api/$2';

$route['(.*)/StepProcessing/StepProcessing/WelcomeNoHn']           = 'StepProcessing/StepProcessing/WelcomeNoHn';
$route['(.*)/StepProcessing/StepProcessing/PersonType']            = 'StepProcessing/StepProcessing/PersonType';
$route['(.*)/StepProcessing/StepProcessing/Payor']                 = 'StepProcessing/StepProcessing/Payor';  //เข้าแก้ css ไม่ได้ 
$route['(.*)/StepProcessing/StepProcessing/Appointment']           = 'StepProcessing/StepProcessing/Appointment';
$route['(.*)/StepProcessing/StepProcessing/ProcessService']        = 'StepProcessing/StepProcessing/ProcessService';
$route['(.*)/StepProcessing/StepProcessing/ProcessServiceClear']   = 'StepProcessing/StepProcessing/ProcessServiceClear';
$route['(.*)/StepProcessing/StepProcessing/Slip']                  = 'StepProcessing/StepProcessing/Slip';

$route['(.*)/welcome']          = 'welcome';

$route['(.*)'] = 'Scanner/PIDScanner';

$route['404_override']          = 'welcome';
$route['translate_uri_dashes']  = FALSE;
