<?php

session_start(); 
include_once('../config/conn.php');

if(isset($_POST['submit'])){
  try{
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if($username == 'admin' && $password == 'admin'){
      $_SESSION['admin'] = $username;
      header("Location: ../src/pages/dashboard.php");
      die();
    }

    $query = "SELECT * FROM users_tbl where username = ?";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $username);
    $stmt->execute();

    $data = $stmt->fetch();

    if($data && password_verify($password, $data->password)){
        $_SESSION['username'] = $username;
        echo "<script> window.location.href = '../src/pages/main.php'; </script>";
    } else {
        header("Location: ../index.php");
    }
  }catch(PDOException $e){
    die("Login error: " . $e->getMessage());
  }

  $pdo = null;
}
?>