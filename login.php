<?php
require 'includes/functions.php';
sec_session_start();
header('Cache-control: private');
require 'includes/defines.php';
require 'includes/common.php';
require 'includes/db.php';

$emailErr = $passErr = "";
$email = $password = "";
$komunikat = $user_ip = "";
$user_ip = getUserIP();

if (!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] != 11) {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (empty($_POST["email"])) {
    $emailErr = "Adres e-mail jest wymagany!";
  } else
      {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Zły format adresu e-mail";
    } else {
      if (empty($_POST["password"])) {
        $passErr = "Hasło nie może być puste!";
      } else {
        $password = test_input($_POST["password"]);
        if (czyistnieje($email, $pdo) == false) {

          echo "Login nie istnieje! " . $email; }
          else  {

            if (checkbrute($email, $pdo) == true) {
              $komunikat = "Konto zablokowane tymczasowo!";
            } else {
              //$komunikat = "Dalej!";
              if (logowanie($email, $password, $pdo, $user_ip) == true) {
                $komunikat = "Zalogowano</br>";
                header("Location: index.php");
              } else {
                $komunikat = "Wprowadzono błędne dane logowania!";
              }
            }

          }

    }
}
      }
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
E-mail:
<input type="text" name="email" value="<?php echo $email;?>">
<span class="error">* <?php echo $emailErr;?></span>
<br><br>
Hasło:
<input type="password" name="password" value="<?php echo $password;?>">
<span class="error">* <?php echo $passErr;?></span>
<br><br>
<input type="submit" name="zaloguj" value="Zaloguj">
	</form>

<?php
if ($komunikat === "") {

} else {
echo "<p> Komunikaty błędów:</p>";
echo $komunikat;

}



}
else {
  header("Location: index.php"); /* Redirect browser */
  exit;
}
?>
