<?php

session_start();
require_once('../config/conn.php');

try{
  $itemName = $_GET['name'];
  $username = $_GET['username'];

  $queryDelete = "DELETE FROM rakkcart WHERE name = ? AND username = ?";
  $stmt = $pdo->prepare($queryDelete);
  $params = [$itemName, $username];
  $stmt->execute($params);

  header("Location: ../src/pages/main.php");
} catch (PDOException $e){
  error_log('Connection close: ' . $e->getMessage());
}

$pdo = null;

?>