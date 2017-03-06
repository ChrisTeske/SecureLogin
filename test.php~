<?php
require 'includes/functions.php';
sec_session_start();
//header('Cache-control: private');
//require 'includes/401.php';
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
  echo '<p>Połączenie nawiązane!</p>';
  }
  catch(PDOException $e)
  {
	file_put_contents('pdoerrors.txt', $e->getMessage(), FILE_APPEND);
	echo 'Nie połączono z bazą danych :-(';
  }

echo "<p>---------------IP2-----------</p>";

$id_usera = 2;
$ip = getUserIP();
echo "IP: " . $ip . "ID usera: " . $id_usera;
$stmt = $pdo->prepare("INSERT INTO login_history (user_id, user_ip) VALUES (?, ?)");
$stmt->bindParam(1, $id_usera);
$stmt->bindParam(2, $ip);
$stmt->execute();

echo "<p>---------------IP-----------</p>";
?>
