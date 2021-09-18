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

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="./">Practice Php</a>
      </div>
    </nav>

    <div class="container">
      <div class="row">
        <h3 class="p-5 text-center">User Login Page</h3>
      </div>
      <div class="row">
        <?php if ($error) { echo '<div class="alert alert-danger" role="alert">'.$error.'</div>'; } ?>
        <form action="./login" method="post">
          <div class="mb-3">
            <label for="username" class="form-label">User Name</label>
            <input type="text" class="form-control" id="username" name="username">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <input type="submit" name="Submit" id="Submit" value="Login" class="btn btn-primary">
        </form>
      </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  </body>
</html>
