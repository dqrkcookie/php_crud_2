<?php

session_start();
require_once('../config/conn.php');

try{
  $username = $_GET['username'];
  $amount = $_GET['amount'];
  $id = $_GET['id'];
  $address = $_GET['address'];
  $status = $_GET['status'];

  $query = "SELECT * FROM rakkcart WHERE username = ?";
  $stmtCart = $pdo->prepare($query);
  $stmtCart->execute([$username]);
  $items = $stmtCart->fetchAll();
  
  if(!empty($items)){
    foreach($items as $item){
      $query = "INSERT INTO placed_order(name, quantity, price, username, amount, orderId, address, orderStatus)VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $pdo->prepare($query);
      $params = [$item->name, $item->quantity, $item->price, $username, $amount, $id, $address, $status];
      $stmt->execute($params);

      $query1 = "INSERT INTO pending_orders(name, quantity, price, username, amount, orderId, address, orderStatus)VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt1 = $pdo->prepare($query1);
      $params1 = [$item->name, $item->quantity, $item->price, $username, $amount, $id, $address, $status];
      $stmt1->execute($params1);
      
      $query2 = "DELETE FROM rakkcart WHERE username = ?";
      $stmt2 = $pdo->prepare($query2);
      $params2 = [$username];
      $stmt2->execute($params2);
    }
  }
  
  header('Location: ../src/pages/main.php');
  die();

} catch (PDOException $e){
  error_log('Connection close: ' . $e->getMessage());
}

$pdo = null;

?>