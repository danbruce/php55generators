<?php

function fetchMatchingPasswordsArray($resultSet)
{
	$matches = array();
	foreach ($resultSet as $row) {
		if (!password_verify('password', $row['password'])) continue;
		$matches[$row['id']] = $row;
	}
	return $matches;
}

$pdo = require_once 'pdo.php';
$selectSql = 'SELECT `id`, `username`, `password` FROM `Users`';

$resultSet = $pdo->query($selectSql);
$count = 0;
$startTime = microtime(true);
$byArray = fetchMatchingPasswordsArray($resultSet);
foreach ($byArray as $id => $row) {
	$count++;
}
echo $count.' matches using '.memory_get_usage().' bytes in '.(microtime(true) - $startTime).' seconds.'.PHP_EOL;
?>