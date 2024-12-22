<?php

session_start();
require_once('../config/conn.php');

$user = $_SESSION['username'];

if(isset($_POST['save'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $address = $_POST['address'];
  $mobile = $_POST['mobile'];
  $birthday = $_POST['birthday'];

  $newFileName = '';
  $_SESSION['username'] = $username;

  $file = $_FILES["profile_picture"];
  $fileName = $file["name"];
  $fileTmpName = $file["tmp_name"];
  $fileSize = $file["size"];
  $fileError = $file["error"];

  if ($fileError === 0) {
      $accepted_type = array('jpg', 'jpeg', 'gif', 'png', 'jfif');
      $getExtension = explode('.', $fileName);
      $extension = strtolower(end($getExtension));

      if (in_array($extension, $accepted_type)) {
          if ($fileSize < 10000000) {
              $newFileName = uniqid('img_', true) . "." . $extension;
              $fileDestination = '../src/images/profile_picture/' . $newFileName;
              move_uploaded_file($fileTmpName, $fileDestination);
          } 
      } 
  }

  $query = "UPDATE users_tbl SET name = ?,  username = ?, password = ?, email = ?, address = ?, mobile = ?, profile_picture = ? WHERE username = ?";
  $stmt = $pdo->prepare($query);
  $params = [$name, $username, $password, $email, $address, $mobile, $newFileName, $user];
  $stmt->execute($params);

}

header("Location: ../src/pages/main.php");

$pdo = null;

?>