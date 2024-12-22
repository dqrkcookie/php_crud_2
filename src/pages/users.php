<?php  

require_once('../../config/conn.php');
require('./nav.php');

if(empty($_SESSION['admin'])){
  header("Location: ../../index.php");
}

$appUsers = $pdo->query("SELECT * FROM users_tbl");
$users = $appUsers->fetchAll();

?>

<link rel="stylesheet" href="../css/table.css">

<section>
  
  <div class="container">
    <h1>Application Users</h1>
    <table>
      <thead>
        <tr>
          <th>User Id</th>
          <th>Name</th>
          <th>Username</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
      <?php if(!empty($users)) {  ?>
          <?php foreach($users as $user) { ?>
            <tr>
              <th><?php echo $user->userID ?></th>
              <th><?php echo $user->name ?></th>
              <th><?php echo $user->username ?></th>
              <th><?php echo $user->email ?></th>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="6">Currently no users</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

</section>