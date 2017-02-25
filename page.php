<?php
require 'includes/functions.php';
sec_session_start();
header('Cache-control: private');
require 'includes/defines.php';
require 'includes/common.php';
require 'includes/db.php';
require 'includes/401.php';

/*if (!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] != 11) {
  echo "niezalogowany</br>" . var_dump($_SESSION); } else {
    echo "zalogowany";
  }*/

echo "<p>--------------------------</p>";
echo $_SESSION['timeout'] . "</br>";
?>
To jest dalej.
