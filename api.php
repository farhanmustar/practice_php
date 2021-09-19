<?php
  session_start();
  if (!($_SESSION['is_login'] ?? 0)) {
    unauthorized();
  }
  function unauthorized() {
    header('Location: ./login', true, 302);
    die();
  }

  if (empty($_GET)) {
    echo '{}';
    die();
  }

  $FROMDATE = $_GET['f'] ?? '';
  $TODATE = $_GET['t'] ?? '';

  if (empty($FROMDATE) || empty($TODATE)) {
    echo '{}';
    die();
  }
  // TODO: validate date
  
  $conn = mysqli_connect("localhost","root","") or die("Fail to connect to database.");
  mysqli_select_db($conn,"northwind");


  /* Total Orders and Sales */
  $sql = " SELECT 
COUNT(DISTINCT o.OrderID) as total_orders,
SUM(d.UnitPrice * d.Quantity - d.Discount) as total_sales
FROM orders AS o 
INNER JOIN order_details as d ON o.OrderID = d.OrderID
WHERE o.OrderDate >= '{$FROMDATE}' and o.OrderDate <= '{$TODATE}'
";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $result->close();
  $totalOrders = $row['total_orders'];
  $totalSales = $row['total_sales'];


  /* Daily Sales */
  $sql = "SELECT
SUM(d.UnitPrice * d.Quantity - d.Discount) as sales,
o.OrderDate as date
FROM orders as o
INNER JOIN order_details as d ON o.OrderID = d.OrderID
WHERE o.OrderDate >= '{$FROMDATE}' and o.OrderDate <= '{$TODATE}' 
GROUP BY o.OrderDate
ORDER BY o.OrderDate";
  $result = mysqli_query($conn, $sql);
  $dailySales = array();
  while ($row = $result->fetch_assoc()) {
    $dailySales[] = $row;
  }
  $result->close();


  /* Product Quantity */
  $sql = "SELECT
SUM(d.Quantity) as quantity,
p.ProductName as name
FROM orders AS o 
INNER JOIN order_details as d ON o.OrderID = d.OrderID
INNER JOIN products as p ON p.ProductID = d.ProductID
WHERE o.OrderDate >= '{$FROMDATE}' and o.OrderDate <= '{$TODATE}' 
GROUP BY p.ProductID";
  $result = mysqli_query($conn, $sql);
  $productQuantity = array();
  while ($row = $result->fetch_assoc()) {
    $productQuantity[] = array_map('utf8_encode', $row);
  }
  $result->close();


  /* Customer Sales */
  $sql = "SELECT
SUM(d.UnitPrice * d.Quantity - d.Discount) as sales,
c.CompanyName as customers
FROM orders AS o 
INNER JOIN order_details as d ON o.OrderID = d.OrderID
INNER JOIN customers as c ON o.CustomerID = c.CustomerID
WHERE o.OrderDate >= '{$FROMDATE}' and o.OrderDate <= '{$TODATE}' 
GROUP BY c.CustomerID";
  $result = mysqli_query($conn, $sql);
  $customerSales = array();
  while ($row = $result->fetch_assoc()) {
    $customerSales[] = array_map('utf8_encode', $row);
  }
  $result->close();


  /* Employee Sales */
  $sql = "SELECT
SUM(d.UnitPrice * d.Quantity - d.Discount) as sales,
e.FirstName as first_name,
e.LastName as last_name
FROM orders AS o 
INNER JOIN order_details as d ON o.OrderID = d.OrderID
INNER JOIN employees as e ON o.EmployeeID = e.EmployeeID
WHERE o.OrderDate >= '{$FROMDATE}' and o.OrderDate <= '{$TODATE}' 
GROUP BY e.EmployeeID";
  $result = mysqli_query($conn, $sql);
  $employeeSales = array();
  while ($row = $result->fetch_assoc()) {
    $employeeSales[] = array_map('utf8_encode', $row);
  }
  $result->close();


  $conn->close();

  header("Content-Type: application/json; charset=UTF-8");
  echo json_encode(array(
    "totalOrders" => $totalOrders,
    "totalSales" => $totalSales,
    "dailySales" => $dailySales,
    "productQuantity" => $productQuantity,
    "customerSales" => $customerSales,
    "employeeSales" => $employeeSales,
  ));
