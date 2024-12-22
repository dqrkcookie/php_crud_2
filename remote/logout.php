<?php

session_start();
require_once("../config/conn.php");

try{

    if(isset($_GET['admin'])){
      unset($_SESSION['admin']);
      header("Location: ../index.php");
      die();
    } else {
      unset($_SESSION['username']);
      header("Location: ../index.php");
      die();
    }
    
} catch (PDOException $e){
    error_log("Connection close: " . $e->getMessage());
}

$pdo = null;

?>