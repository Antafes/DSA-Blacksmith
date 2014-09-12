<?php
require_once(__DIR__.'/util/general.php');

//access data for the database
$GLOBALS['db'] = array(
	'server' => 'localhost',
	'user' => '',
	'password' => '',
	'db' => 'magic',
	'charset' => 'utf8',
);

$GLOBALS['config']['charset'] = 'UTF-8';

//enable/disable debug
$GLOBALS['config']['debug'] = false;
$GLOBALS['config']['debugSmarty'] = false;

//paths
$GLOBALS['config']['dir_ws'] = 'http://localhost';
$GLOBALS['config']['dir_ws_index'] = 'http://localhost/index.php';

$GLOBALS['config']['migrations_dir'] = '';
$GLOBALS['config']['dir_ws_migrations'] = '';

//autoloader
spl_autoload_register('classLoad');

if (file_exists(__DIR__.'/config.php'))
	require_once(__DIR__.'/config.php');
