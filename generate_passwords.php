<?php

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

$pdo = require_once 'pdo.php';

$createTableSql = 'CREATE TABLE IF NOT EXISTS `Users` (
	`id` INT(255) UNSIGNED NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(50) NOT NULL,
	`password` CHAR(60) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY (`username`)
);';

$pdo->query($createTableSql);

$insertSql = 'INSERT INTO `Users` (`username`,`password`) VALUES (:username, :password)';
$stmt = $pdo->prepare($insertSql);

$pdo->beginTransaction();

for ($i = 1; $i <= 1000; $i++) {
	do {
		$username = generateRandomString();
		$password = ($i % 10 == 0) ? 'password' : generateRandomString();

		try {
			$result = $stmt->execute(
				array(
					':username' => $username,
					':password' => password_hash($password, PASSWORD_DEFAULT)
				)
			);
		} catch (PDOException $e) {
			$result = false;
		}
	} while (false === $result);
}

$pdo->commit();