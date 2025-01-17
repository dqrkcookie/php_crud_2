<?php  

require_once('../../config/conn.php');
require('./nav.php');

if(empty($_SESSION['admin'])){
  header("Location: ./login.php");
}

$stmt = $pdo->query("SELECT * FROM accepted_orders ORDER BY id");
$stmt->execute();

$accepted = $stmt->fetchAll();

?>

<link rel="stylesheet" href="../css/table.css">

<section>
  
  <div class="container">
    <h1>Accepted Orders</h1>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Order Id</th>
          <th>Amount</th>
          <th>Delivery Address</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php $amount = []; ?>
        <?php if(!empty($accepted)) { ?>
          <?php foreach($accepted as $accept) { ?>
            <?php if(!in_array($accept->payment, $amount)) {
              array_push($amount, $accept->payment)
             ?>
            <?php  ?>
            <tr>
              <td><?php echo $accept->username ?></td>
              <td><?php echo $accept->id ?></td>
              <td><?php echo $accept->payment  ?></td>
              <td><?php echo $accept->address  ?></td>
              <td><?php echo $accept->accept  ?></td>
            </tr>
            <?php } ?>
        <?php  } ?>
        <?php } else { ?>
          <tr>
            <td colspan="6">No accepted orders</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

</section>