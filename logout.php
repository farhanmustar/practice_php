<?php
  session_start();
  session_destroy();
  header('Location: ./login', true, 302);
  die();
?>
