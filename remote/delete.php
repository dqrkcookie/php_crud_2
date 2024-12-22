<?php

require_once("../config/conn.php");

$id = $_GET['id'] ?? '';

$query = "DELETE FROM product_tbl WHERE productID = ?";

$stmt = $pdo->prepare($query);

$stmt->bindParam(1, $id);

if(!$stmt->execute()){
  header("Location: ../src/pages/add.php");
} else {
  header("Location: ../src/pages/add.php");
}

$pdo = null;

?>