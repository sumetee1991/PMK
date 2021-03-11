<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'hostname' => "pgsql:host=".PGCONNECT['host'].";dbname=".PGCONNECT['db']."",
	'username' => PGCONNECT['user'],
	'password' => PGCONNECT['pass'],
	'database' => PGCONNECT['db'],
	'dbdriver' => "pdo",
	'dbprefix' => "",
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => "",
	'char_set' => "utf8",
	'dbcollat' => "utf8_general_ci",
	'swap_pre' => "",
	'autoinit' => TRUE,
	'stricton' => FALSE,
);