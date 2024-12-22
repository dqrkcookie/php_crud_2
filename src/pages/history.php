<?php  

require_once('../../config/conn.php');
require('./nav.php');

if(empty($_SESSION['admin'])){
  header("Location: ../../index.php");
}

$query = $pdo->query("SELECT * FROM transaction_history");
$history = $query->fetchAll();

?>

<link rel="stylesheet" href="../css/table.css">

<section>
  
  <div class="container">
    <h1>Transaction History</h1>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Amount</th>
          <th>Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($history)) { ?>
          <?php foreach($history as $histo) { ?>
            <tr>
              <td><?php echo $histo->name ?></td>
              <td><?php echo $histo->amount ?></td>
              <td><?php echo $histo->transactionDate ?></td>
              <td><?php echo $histo->status ?></td>
            </tr>
        <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="6">No transaction history</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

</section>