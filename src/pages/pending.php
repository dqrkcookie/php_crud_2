<?php  

require_once('../../config/conn.php');
require('./nav.php');

if(empty($_SESSION['admin'])){
  header("Location: ../../index.php");
}

$stmt = $pdo->query("SELECT * FROM pending_orders");
$pendings = $stmt->fetchAll(); 

?>

<link rel="stylesheet" href="../css/table.css">

<section>
  <div class="container">
    <h1>Pending Orders</h1>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Item name</th>
          <th>Quantity</th>
          <th>Amount</th>
          <th>Delivery Address</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $displayedOrderIds = [];
        if (!empty($pendings)) {
          foreach ($pendings as $pending) {
            if (!in_array($pending->orderId, $displayedOrderIds)) {
              array_push($displayedOrderIds, $pending->orderId); ?>
              <tr>
                <td><?php echo $pending->username; ?></td>
                <td>
                  <?php
                  $query1 = "SELECT * FROM placed_order WHERE username = ? AND orderId = ?";
                  $stmt1 = $pdo->prepare($query1);
                  $stmt1->execute([$pending->username, $pending->orderId]);
                  $items = $stmt1->fetchAll();
                  
                  $itemsArr = [];
                  $qty = [];
                  if (!empty($items)) {
                    foreach ($items as $item) {
                      $itemsArr[] = $item->name;
                      array_push($qty, $item->name . ' ' .$item->quantity . 'pcs');
                    }
                  }
                  $toJson = json_encode($itemsArr);
                  $toUrl = urlencode($toJson);
                  echo implode(' & ', $itemsArr);
                  ?>
                </td>
                <td><?php foreach($qty as $q){echo $q . '<br>';} ?></td>
                <td><?php echo number_format($pending->amount, 2); ?></td>
                <td><?php echo $pending->address; ?></td>
                <td><a href="../../remote/accept.php?id=<?php echo $pending->orderId ?>&username=<?php echo $pending->username ?>&amount=<?php echo $pending->amount ?>&address=<?php echo $pending->address ?>&items=<?php echo $toUrl; ?>&accept=accepted"><button>Accept Order</button></a></td>
              </tr>
            <?php
            }
          }
        } else { ?>
          <tr>
            <td colspan="6">No pending orders</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</section>
