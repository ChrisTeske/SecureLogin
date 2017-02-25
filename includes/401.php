<?php
sec_session_start();
//var_dump($_SESSION);

if (!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] != 11) {
?>

<script type="text/javascript">
window.seconds = 5;
window.onload = function()
{
    if (window.seconds != 0)
    {
        document.getElementById('secondsDisplay').innerHTML = '' +
            window.seconds + ' sekund' + ((window.seconds > 4) ? '' : 'y');
        window.seconds--;
        setTimeout(window.onload, 1000);
    }
    else
    {
        window.location = 'login.php';
    }
}
</script>

<p>Wywołany zasób wymaga uwierzytelnienia się. Nie wpisano
odpowiednich danych uwierzytelniających lub podane dane
uwierzytelniające nie uprawniają do uzyskania dostępu do zasobu.</p>

<p><strong>Za <span id="secondsDisplay"> sek.</span> nastąpi
przekierowanie do strony logowania.</strong></p>

<p>Jeżeli przekierowanie nie nastąpi automatycznie, należy kliknąć nastêpujące łącze:
<a href="login.php">Logowanie</a></p>

<?php
exit();
} else {
  // check to see if $_SESSION['timeout'] is set
  if(isset($_SESSION['timeout']) ) {
    $session_life = time() - $_SESSION['timeout'];
    if($session_life > SESSIONINACTIVE) //check value SESSIONINACTIVE in defines.php
          { session_destroy(); header("Location: login.php"); }
  }
  $_SESSION['timeout'] = time();
}

?>
