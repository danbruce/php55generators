<?php

const CONF_FILE = 'config.local.php';

$config = (file_exists(CONF_FILE) && is_readable(CONF_FILE)) ?
	require_once 'config.local.php' :
	array(
		'database' => 'example',
		'host' => 'localhost',
		'username' => 'myuser',
		'password' => 'mypass'
	);

try {
    $pdo = new PDO(
    	sprintf(
    		'mysql:dbname=%s;host=%s',
    		$config['database'],
    		$config['host']
		),
    	$config['username'], $config['password']
    );
    unset($config);
    return $pdo;
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}