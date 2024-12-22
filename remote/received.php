  <?php

  session_start();
  require_once('../config/conn.php');

  try{
    $amount = $_GET['amount'];
    $name = $_GET['name'];
    $status = $_GET['status'];

    $queryTransac = "INSERT INTO transaction_history(name, amount, status, transactionDate)VALUES(?, ?, ?, NOW())";
    $stmtTransac = $pdo->prepare($queryTransac);
    $params = [$name, $amount, $status];
    $stmtTransac->execute($params);

    $queryHistory = "UPDATE order_notifications SET is_read = ? WHERE amount = ? AND username = ?";
    $stmtHisto = $pdo->prepare($queryHistory);
    $stmtHisto->execute([1, $amount, $name]);

    $queryA = "UPDATE accepted_orders SET accept = ? WHERE payment = ? AND username = ?";
    $stmtA = $pdo->prepare($queryA);
    if($status == 'success'){
      $stmtA->execute(['completed', $amount, $name]);
    } else {
      $stmtA->execute(['failed', $amount, $name]);
    }

    $queryDelete = "DELETE FROM placed_order WHERE username = ? AND amount = ?";
    $stmtDel = $pdo->prepare($queryDelete);
    $paramsDel = [$name, $amount];
    $stmtDel->execute($paramsDel);

  } catch (PDOException $e){
    error_log('Connection close: ' . $e->getMessage());
  }

  header("Location: ../src/pages/main.php");

  $pdo = null;
  ?>