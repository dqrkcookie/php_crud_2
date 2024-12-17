<?php

include_once('../config/conn.php');
session_start();  

if(isset($_POST['submit'])){
  try{
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $query = "SELECT * FROM users_tbl where username = ?";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $username);
    $stmt->execute();

    $data = $stmt->fetch();

    if($data && password_verify($password, $data->password)){
        $_SESSION['username'] = $username;
        echo "<script> window.location.href = '../src/pages/home.php'; </script>";
    } else {
        header("Location: ../index.php");
    }
  }catch(PDOException $e){
    die("Login error: " . $e->getMessage());
  }

  $pdo = null;
}
?>