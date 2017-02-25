<?php
$host = 'localhost';
$db   = 'varlock_test';
$user = 'varlock_test';
$pass = 'vartest44';
$charset = 'utf8';


try
   {
	$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
       //echo 'Połączenie nawiązane!';
        }
   catch(PDOException $e)
   {
	file_put_contents('pdoerrors.txt', $e->getMessage(), FILE_APPEND);
	echo 'Nie połączono z bazą danych :-(';
   }
?>
