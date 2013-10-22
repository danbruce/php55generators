<?php

function fetchMatchingPasswordsArray($resultSet)
{
	return array_filter(
		$resultSet->fetchAll(),
		function ($row) {
			return password_verify('password', $row['password']) ? $row : false;
		}
	);
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
