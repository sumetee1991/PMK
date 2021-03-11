<?php
defined('BASEPATH') or exit('No direct script access allowed');

define('DEFAULT_MODULE','Main');
$default_module = DEFAULT_MODULE;
$route['default_controller'] = DEFAULT_MODULE;
//dynamically routes
$app_controllers = array('Main');
foreach($app_controllers as $value){
    $controllers_format = array(strtoupper($value),strtolower($value),ucfirst($value),$value);
    foreach($controllers_format as $val_format){
        $route["(.*)/$val_format/(.*)"]                             = "$value/$2";
        $route["(.*)/$val_format"]                                  = "$value/redirect_index/$value";
    }
}
//main module route //skip module call to function call
$route["(.*)"]                  = function($_1){
    $URI_EXP = explode('/',$_1);
    $IDX_APP = array_search(APP_URI, $URI_EXP);
    array_splice($URI_EXP, 0, $IDX_APP+1);
    $FUNC = implode('/',$URI_EXP);
    if($FUNC){
        return DEFAULT_MODULE."/$FUNC";
    }else{
        header( "location: " . APPURL . "/index" );
    }    
};

$route['404_override']          = "$default_module/redirect_index/$default_module";
$route['translate_uri_dashes']  = FALSE;
unset($default_module);
unset($appcontrollers);unset($value);
unset($controllers_format);unset($val_format);
