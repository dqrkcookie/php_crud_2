<?php

session_start();
require_once('../config/conn.php');

try {
    $username = $_GET['username'];
    $amount = $_GET['amount'];
    $id = $_GET['id'];
    $address = $_GET['address'];
    $status = $_GET['status'];

    $query = "SELECT * FROM rakkcart WHERE username = ?";
    $stmtCart = $pdo->prepare($query);
    $stmtCart->execute([$username]);
    $items = $stmtCart->fetchAll();
  
    if (!empty($items)) {
        $placedOrderQuery = "INSERT INTO placed_order(name, quantity, price, username, amount, orderId, address, orderStatus) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $pendingOrderQuery = "INSERT INTO pending_orders(name, quantity, price, username, amount, orderId, address, orderStatus) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
        $updateStockQuery = "UPDATE product_tbl SET noOfStocks = ? WHERE productName = ?";
        
        foreach ($items as $item) {
            $qty = $item->quantity;

            $productQuery = $pdo->prepare("SELECT * FROM product_tbl WHERE productName = ?");
            $productQuery->execute([$item->name]);
            $productQueryResult = $productQuery->fetch();

            if ($productQueryResult) {
                $newQty = $productQueryResult->noOfStocks - $qty;

                if ($newQty < 0) {
                    echo "<script>alert('Not enough stock!');
                    window.location.href = '../src/pages/main.php?checkout=failed';
                    </script>"; 
                    die();
                } else {
                    $stmtPlacedOrder = $pdo->prepare($placedOrderQuery);
                    $paramsPlacedOrder = [$item->name, $item->quantity, $item->price, $username, $amount, $id, $address, $status];
                    $stmtPlacedOrder->execute($paramsPlacedOrder);

                    $stmtPendingOrder = $pdo->prepare($pendingOrderQuery);
                    $paramsPendingOrder = [$item->name, $item->quantity, $item->price, $username, $amount, $id, $address, $status];
                    $stmtPendingOrder->execute($paramsPendingOrder);

                    $stmtUpdateStock = $pdo->prepare($updateStockQuery);
                    $stmtUpdateStock->execute([$newQty, $productQueryResult->productName]);
                }
            }
        }

        $deleteCartQuery = "DELETE FROM rakkcart WHERE username = ?";
        $stmtDeleteCart = $pdo->prepare($deleteCartQuery);
        $stmtDeleteCart->execute([$username]);

        echo "<script>window.location.href = '../src/pages/main.php?checkout=success';</script>";
        die();
    } else {
        echo "<script>alert('No items in the cart.');</script>";
    }

} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    echo "<script>alert('Something went wrong. Please try again later.');</script>";
}

$pdo = null;

?>
