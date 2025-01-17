<?php

require_once("../config/conn.php");

if(isset($_POST['submit'])){

  try{
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $number = $_POST['number'] ?? '';
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT) ?? '';

    $newFileName = '';

    $file = $_FILES["profile"];
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

    $query = "INSERT INTO users_tbl(name,username,password,address,email,birthday,mobile,profile_picture)VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $params = [$name, $username, $password, $address, $email, $birthday, $number, $newFileName];

    if(!$stmt->execute($params)){ 
      die('Unable to create an account');
    } else {
      header("Location: ../src/pages/login.php");
      die();
    }
  }catch(PDOException $e){
    die("Unable to create an account: " . $e->getMessage());
  }

}

$pdo = null;

?>