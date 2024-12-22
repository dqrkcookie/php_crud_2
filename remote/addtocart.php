<?php

session_start();
require_once('../config/conn.php');

try{
  $itemName = $_GET['name'];
  $price = $_GET['price'];
  $qty = $_GET['qty'];
  $username = $_GET['username'];

  $qtyIncrement = "SELECT * FROM rakkcart WHERE username = ? AND name = ?";
  $stmtQty = $pdo->prepare($qtyIncrement);
  $stmtQty->execute([$username, $itemName]); 
  $item = $stmtQty->fetch();

  if($item){
    $newQty = $qty + $item->quantity;
    $cartQty = "UPDATE rakkcart SET quantity = ? WHERE name = ? AND username = ?";
    $stmtQty = $pdo->prepare($cartQty);
    $stmtQty->execute([$newQty, $itemName, $username]);

    header("Location: ../src/pages/main.php");
    die();
  } else {
    $cartQuery = "INSERT INTO rakkcart(name, quantity, price, username)VALUE(?, ?, ?, ?)";
    $stmt = $pdo->prepare($cartQuery);
    $params = [$itemName, $qty, $price, $username];
    
    $stmt->execute($params);
    header("Location: ../src/pages/main.php");
    die();
  }

} catch (PDOException $e){
  error_log('Close connection: ' . $e->getMessage());
}

$pdo = null;

?>