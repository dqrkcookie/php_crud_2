<?php  

require_once('../../config/conn.php');
require('./nav.php');

if(empty($_SESSION['admin'])){
  header("Location: ./login.php");
}

if($_SESSION['admin'] == 'customer support' || $_SESSION['admin'] == 'manager'){
  echo "<script>alert('You dont have permission to access this page!');
    window.location.href = './dashboard.php';
  </script>";
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
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php 
      
      if(isset($_GET['block'])){

        if($_GET['block'] == 'yes') {
          $name = $_GET['name'];

          $query = $pdo->query("UPDATE users_tbl SET status = 'Blocked' WHERE name = '$name'");  
        } else {
          $name = $_GET['name'];

          $query = $pdo->query("UPDATE users_tbl SET status = 'Active' WHERE name = '$name'");
        }
        header("Location: ./users.php?action=set");
      }
      
      ?>
        
      <?php if(!empty($users)) {  ?>
          <?php foreach($users as $user) { ?>
            <tr>
              <th><?php echo $user->userID ?></th>
              <th><?php echo $user->name ?></th>
              <th><?php echo $user->username ?></th>
              <th><?php echo $user->email ?></th>
              <th><?php echo $user->status ?></th>
              <th>

              <?php if($user->status !== 'Blocked') { ?>
                <a class="b" href="./users.php?block=yes&name=<?php echo $user->name ?>">Block</a>
              <?php } else { ?>
                <a class="b" href="./users.php?block=no&name=<?php echo $user->name ?>">Unblock</a>
              <?php } ?>

              </th>
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