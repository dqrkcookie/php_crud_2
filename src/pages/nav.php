<?php

session_start();
require_once('../../config/conn.php');

  if(empty($_SESSION['admin'])){
    header("Location: ../../index.php");
  }

  $query = $pdo->query("SELECT * FROM pending_orders");
  $pending = $query->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rakk Dashboard</title>
  <link rel="stylesheet" href="../css/nav.css">
</head>
<body>
  <nav>
    <ul>
      <li><a href="./dashboard.php"><button>Home</button></a></li>
      <li><a href="./admin.php"><button>Admins</button></a></li>
      <li><a href="./add.php"><button>Add Item</button></a></li>
      <li><a href="./pending.php"><button>Pending Orders <?php if(count($pending) > 0) { ?>
        <span id="pending"><?php echo count($pending) ?></span>
      <?php } ?></button></a></li>
      <li><a href="./accept.php"><button>Accepted Orders</button></a></li>
      <li><a href="./history.php"><button>Transaction History</button></a></li>
      <li><a href="./users.php"><button>App Users</button></a></li>
      <li><a href="../../remote/logout.php?admin=yes"><button>Log out</button></a></li>
    </ul>
  </nav>
</body>
</html>