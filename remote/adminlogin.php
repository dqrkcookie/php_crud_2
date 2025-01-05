<?php

session_start(); 
include_once('../config/conn.php');

if(isset($_POST['submit'])){
  try{
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $query = $pdo->query("SELECT * FROM admins WHERE username = '$username'")->fetch();

    if($query){
      if($query->passkey == $password){
        $_SESSION['admin'] = $query->role;
        header("Location: ../src/pages/dashboard.php");
      }
    }

  }catch(PDOException $e){
    die("Login error: " . $e->getMessage());
  }

  $pdo = null;
}
?>