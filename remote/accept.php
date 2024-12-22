<?php

session_start();
require_once('../config/conn.php');

try{
    $id = $_GET['id'];
    $username = $_GET['username'];
    $address = $_GET['address'];
    $amount = $_GET['amount'];
    $accept = $_GET['accept'];
    $items = $_GET['items'];

    $queryAccept = "INSERT INTO accepted_orders(username, address, payment, accept)VALUES(?, ?, ?, ?)";
    $stmtAccept = $pdo->prepare($queryAccept);
    $params = [$username, $address, $amount, $accept];
    $stmtAccept->execute($params);

    $queryNotif = "INSERT INTO order_notifications(username, items, amount, order_id)VALUES(?, ?, ?, ?)";
    $stmtNotif = $pdo->prepare($queryNotif);
    $paramsNotif = [$username, $items, $amount, $id];
    $stmtNotif->execute($paramsNotif);

    $queryDelete = "DELETE FROM pending_orders WHERE username = ? AND orderId = ?";
    $stmtDelete = $pdo->prepare($queryDelete);
    $parameters = [$username, $id];
    $stmtDelete->execute($parameters);

} catch (PDOException $e){
  error_log('Connection close: ' . $e->getMessage());
}

header("Location: ../src/pages/pending.php");

$pdo = null;
?>