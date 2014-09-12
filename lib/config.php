<?php
//access data for the database
$GLOBALS['db'] = array(
	'server' => 'localhost',
	'user' => 'root',
	'password' => '',
	'db' => 'dsa_blacksmith',
	'charset' => 'utf8',
);

//enable/disable debug
$GLOBALS['config']['debug'] = true;

//paths
$GLOBALS['config']['dir_ws'] = 'http://localhost/DSA_Blacksmith';
$GLOBALS['config']['dir_ws_index'] = 'http://localhost/DSA_Blacksmith/index.php';

$GLOBALS['config']['migrations_dir'] = 'J:/xampp_1.8/htdocs/DSA_Blacksmith/db_migrations/files';
$GLOBALS['config']['dir_ws_migrations'] = 'http://localhost/DSA_Blacksmith/db_migrations';
