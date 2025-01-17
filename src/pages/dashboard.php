<?php 

require_once('../../config/conn.php');
require("./nav.php");

if(empty($_SESSION['admin'])){
  header("Location: ./login.php");
}

$users = $pdo->query("SELECT * FROM users_tbl");
$totalUsers = $users->fetchAll();

$products = $pdo->query("SELECT * FROM product_tbl");
$totalProducts = $products->fetchAll();

$orders = $pdo->query("SELECT * FROM accepted_orders");
$totalOrders = $orders->fetchAll();

$sales = $pdo->query("SELECT * FROM transaction_history WHERE status = 'success'");
$totalSales = $sales->fetchAll();

?>

<link rel="stylesheet" href="../css/dashboard.css">

<section>
  <h1>Dashboard</h1>
  <div>
    <ul>
      <li>No. of Users <?php if(!empty($totalUsers)) { echo '<br>'; echo count($totalUsers);  } ?></li>
      <li>Total items<?php if(!empty($totalProducts)) { echo '<br>'; echo count($totalProducts);  } ?></li>
      <li>Total Orders<?php if(!empty($totalOrders)) { echo '<br>'; echo count($totalOrders);  } ?></li>
      <li>Total sales<?php $revenue = 0; if(!empty($totalSales)) { echo '<br>'; foreach($totalSales as $total){ $revenue += $total->amount; } echo '₱' . $revenue;  } ?></li>
    </ul>
  </div>
</section>