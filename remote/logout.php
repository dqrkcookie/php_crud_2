<?php

session_start();
require_once("../config/conn.php");

try{

    if(isset($_GET['admin'])){
      unset($_SESSION['admin']);
      header("Location: ../src/pages/login.php");
      die();
    } else {
      unset($_SESSION['username']);
      header("Location: ../src/pages/login.php");
      die();
    }
    
} catch (PDOException $e){
    error_log("Connection close: " . $e->getMessage());
}

$pdo = null;

?>