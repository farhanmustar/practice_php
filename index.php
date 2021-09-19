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

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Practice Php</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="./">Practice Php</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="./logout">Logout</a>
            </li>
          </ul>
        </div>

      </div>
    </nav>

    <div class="container p-5">
      <div>
        <h3>
          Sales Dashboard
        </h3>
        <p id="dashboard-date"></p>

        <div class="row">
          <div class="col-3">
            <h4>Total Sales</h4>
            <p id="dashboard-total-sales">$ -</p>
          </div>
          
          <div class="col-3">
            <h4>Total Orders</h4>
            <p id="dashboard-total-orders">-</p>
          </div>
        </div>

        <div>
          <div>Daily Sales</div>
          <div id="dashboard-daily-sales"></div>
        </div>

        <div class="row">
          <div class="col-3">
            <div>Sales by Product Category</div>
            <div id="dashboard-product-quantity"></div>
          </div>
        </div>

      </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="./js/custom.js"></script>
  </body>
</html>
