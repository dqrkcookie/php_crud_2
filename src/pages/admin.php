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

if(isset($_GET['save'])){
  $role = $_GET['c_role'];
  $user = $_GET['user'];

  $query = $pdo->query("UPDATE admins SET role = '$role' where username = '$user'");

  header("Location: ./admin.php?change=success");
}

if(isset($_POST['create'])){
  $username = $_POST['username'];
  $passkey = $_POST['passkey'];
  $role = $_POST['role'];

  $query = $pdo->query("INSERT INTO admins(username,passkey,role)VALUES('$username', '$passkey', '$role')");

  header("Location: ./admin.php?created=success");
}

?>

<link rel="stylesheet" href="../css/table.css">

<style>
#create, .create {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #fff;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  padding: 16px;
  width: 300px;
  font-family: Arial, sans-serif;
}

#create form, .create form {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

#create input,
#create select {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
}

#create input:focus,
#create select:focus,
.create input:focus,
.create select:focus {
  outline: none;
  border-color: #4caf50;
  box-shadow: 0 0 3px #45a049;
}

#create button,
.create button {
  background: #4caf50;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 10px;
  font-size: 14px;
  cursor: pointer;
  transition: background 0.3s;
}

#create button:hover,
.create button:hover {
  background: #45a049;
}

#create h1{
  text-align: center;
  margin: 4px 0;
  color: #333;
}

.create h1{
  text-align: center;
  font-size: 1.5rem;
}

.create select{
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
  margin-left: 1.5rem;
}

@media (max-width: 600px) {
  #create {
    width: 90%;
    padding: 12px;
  }
}

</style>

<section>
  <div>
    <button popovertarget="create">Create new</button>
  </div>
  
  <div class="container">
    <h1>Rakk Admins</h1>
    <table>
      <thead>
        <tr>
          <th>Username</th>
          <th>Key</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $query = $pdo->query("SELECT * FROM admins ORDER BY id")->fetchAll();
        ?>
        <?php foreach($query as $q) { ?>
          <tr>
            <td><?php echo $q->username ?></td>
            <td><?php echo $q->passkey ?></td>
            <td><?php echo $q->role ?></td>
            <td><button popovertarget="c_role<?php echo $q->username ?>">Change role</button></td>
            <div popover id="c_role<?php echo $q->username ?>" class="create">
                <h1>Changing role of <?php echo $q->username ?></h1>
                <form action="./admin.php" method="GET">
                  <input type="hidden" value="<?php echo $q->username ?>" name="user" required>
                    <select name="c_role" required>
                      <option value="">Select role</option>
                      <option value="superadmin">Super admin</option>
                      <option value="manager">Manager</option>
                      <option value="customer support">Customer support</option>
                    </select>
                    <button name="save">Save</button>
                </form>
            </div>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <div popover id="create">
      <h1>Create new admin account</h1>
      <form action="./admin.php" method="POST">
        <input type="text" placeholder="Username" name="username" required>
        <input type="password" placeholder="Passkey" name="passkey" required>
        <select name="role" required>
          <option value="">Select role</option>
          <option value="superadmin">Super admin</option>
          <option value="manager">Manager</option>
          <option value="customer support">Customer support</option>
        </select>
        <button name="create">Create</button>
      </form>
  </div>

</section>