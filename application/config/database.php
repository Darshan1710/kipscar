<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',	
	'username' => 'carmantr_kipscar',
	'password' => 'sfzkGoyV&mU^',
	'database' => 'carmantr_kipscar',
	'dbdriver' => 'mysqli',
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
	'save_queries' => TRUE
);


// if($_SERVER['HTTP_HOST'] == 'localhost'){
	// $db['default']['hostname'] = 'localhost';
	// $db['default']['username'] = 'root';
	// $db['default']['password'] = 'admin';
	// $db['default']['database'] = 'keepscar';
// }

