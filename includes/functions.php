<?php
function hash_password($password)
{
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
return $hashed_password;
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function sec_session_start() {
    $session_name = 'SesjaLogIn';   // Set a custom session name
    /*Sets the session name.
     *This must come before session_set_cookie_params due to an undocumented bug/feature in PHP.
     */
    session_name($session_name);

    $secure = true;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        /*$cookieParams["/"],
        /*$cookieParams["madlon.pl"],
        $secure,*/
        $httponly);
        if(!isset($_SESSION)){
          session_start();            // Start the PHP session
          session_regenerate_id(true);    // regenerated the session, delete the old one.
    }
}

function czyistnieje($dane, $pdo) {
    $stmt = $pdo->prepare('SELECT USER_EMAIL FROM users WHERE USER_EMAIL=:user_email');
 		$stmt->execute(array(':user_email' => $dane));
 		$result = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if ($count == 1) {
      return true;    } else
      {
      return false;
      }
  }

function getUserIP() {
  $client  = @$_SERVER['HTTP_CLIENT_IP'];
  $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
  $remote  = $_SERVER['REMOTE_ADDR'];

  if(filter_var($client, FILTER_VALIDATE_IP))
  {
    $ip = $client;
  }
  elseif(filter_var($forward, FILTER_VALIDATE_IP))
  {
    $ip = $forward;
  }
  else
  {
  $ip = $remote;
  }
  return $ip;
}


function checkbrute($dane, $pdo) {

    $now = time();
    $valid_attempts = $now - (2 * 60 * 60);

    $stmt = $pdo->prepare("SELECT USER_ID, USER_EMAIL FROM users WHERE USER_EMAIL=:user_email");
    $stmt->bindParam(':user_email', $dane, PDO::PARAM_INT);
    $stmt->execute();
    $row=$stmt->fetchObject();
    $id_usera = $row->USER_ID;

    $stmt = $pdo->prepare("SELECT logintime FROM login_attempts WHERE user_id = '$id_usera' AND logintime > $valid_attempts");
    $stmt->execute();

    if ($stmt->rowCount() > 5) {
      return true;
    } else {
      return false;
    }
}

function logowanie($email, $password, $pdo, $ip) {
  $stmt = $pdo->prepare("SELECT USER_ID, USER_EMAIL, USER_PASS FROM users WHERE USER_EMAIL=:user_email");
  $stmt->bindParam(':user_email', $email, PDO::PARAM_INT);
  $stmt->execute();
  $row=$stmt->fetchObject();
  $stmt->closeCursor(); //dodałem!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  $id_usera = $row->USER_ID;
  $user_pass = $row->USER_PASS;
  if (password_verify($password, $user_pass)) {
    $user_browser = $_SERVER['HTTP_USER_AGENT'];
    // XSS protection as we might print this value
    $user_id = preg_replace("/[^0-9]+/", "", $id_usera);
    $_SESSION['user_id'] = $user_id;
    // XSS protection as we might print this value
    $_SESSION['username'] = $email;
    $_SESSION['zalogowany'] = 11;     // Login successful.
    // SAve the login time to the database:
    $stmt = $pdo->prepare("INSERT INTO login_history (user_id, user_ip) VALUES (?, ?)");
    $stmt->bindParam(1, $id_usera);
    $stmt->bindParam(2, $ip);
    $stmt->execute();
    return true; }
    else {
      // Password is not correct
      // We record this attempt in the database
      $now = time();
      $stmt = $pdo->prepare("INSERT INTO login_attempts (user_id, logintime, user_ip) VALUES (:user_id, :time, :user_ip)");
      $stmt->bindParam(':user_id', $id_usera, PDO::PARAM_INT);
      $stmt->bindParam(':time', $now, PDO::PARAM_INT);
      $stmt->bindParam(':user_ip', $ip, PDO::PARAM_STR);
      $stmt->execute();
      return false;
  }
}


?>
