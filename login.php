<?php
  $error = '';
  session_start();
  if ($_SESSION['is_login'] ?? 0){
    header('Location: ./', true, 302);
    die();
  }

  if (!empty($_POST)) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $userPass = $username.'|'.$password;
    $fh = fopen('./users.txt','r');
    while ($line = fgets($fh)) {
      if (trim($line) == $userPass) {
        $_SESSION['username'] = $username;
        $_SESSION['is_login'] = 1;
        break;
      }
    }
    fclose($fh);

    if ($_SESSION['is_login'] ?? 0){
      header('Location: ./', true, 302);
      die();
    }

    $error = 'Username or password is invalid.';
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Login Page</title>
  </head>
  <body>
    <h1>Login Lah Cepat</h1>
    <?php if ($error) { echo '<h2>'.$error.'</h2>'; } ?>
    <form action="./login" method="post">
      <span>User Name:</span>
      <input type="text" name="username" id="username" value="">
      <br/>
      <span>Password:</span>
      <input type="password" name="password" id="password" value="">
      <br/>
      <input type="submit" name="Submit" id="Submit" value="Login">
    </form>
  </body>
</html>
