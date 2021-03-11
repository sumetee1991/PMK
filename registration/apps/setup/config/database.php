<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
   'hostname' => "pgsql:host=".PGCONNECT['host'].";dbname=".PGCONNECT['db']."",
   'username' => PGCONNECT['user'],
   'password' => PGCONNECT['pass'],
   'database' => PGCONNECT['db'],
   'dbdriver' => 'pdo',
   'dbprefix' => '',
   'pconnect' => FALSE,
   'db_debug' => (ENVIRONMENT !== 'production'),
   'cache_on' => FALSE,
   'cachedir' => '',
   'char_set' => 'utf8',
   'dbcollat' => 'utf8_general_ci',
   'swap_pre' => '',
   'encrypt' => FALSE,
   'compress' => FALSE,
   'stricton' => FALSE,
   'failover' => array(),
   'save_queries' => TRUE,
   'option' => array(PDO::ATTR_TIMEOUT => 5)
);
