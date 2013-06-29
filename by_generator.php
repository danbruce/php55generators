<?php

function fetchMatchingPasswordsByGenerator($resultSet)
{
	foreach ($resultSet as $row) {
		if (!password_verify('password', $row['password'])) continue;
		yield $row;
	}
}

$pdo = require_once 'pdo.php';
$selectSql = 'SELECT `id`, `username`, `password` FROM `Users`';

$resultSet = $pdo->query($selectSql);
$count = 0;
$startTime = microtime(true);
$byGenerator = fetchMatchingPasswordsByGenerator($resultSet);
foreach ($byGenerator as $id => $row) {
	$count++;
}
echo $count.' matches using '.memory_get_usage().' bytes in '.(microtime(true) - $startTime).' seconds.'.PHP_EOL;
?>