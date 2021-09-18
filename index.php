<?php
  session_start();
  if (!($_SESSION['is_login'] ?? 0)) {
    unauthorized();
  }
  function unauthorized() {
    header('Location: ./login', true, 302);
    die();
  }
?>

Rahsia Kerajaan Malaysia <a href="./logout">Logout</a>
