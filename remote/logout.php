<?php

require_once("../config/conn.php");
session_start();

if(isset($_GET['logout'])){
  if($_GET['logout'] === 'yes'){
    session_unset();
    session_destroy();
    header("Location: ../index.php");
  }
}

$pdo = null;

?>