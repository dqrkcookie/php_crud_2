<?php

require_once("../config/conn.php");

if(isset($_POST['add'])){
  try{
    $name = $_POST['name'] ?? '';
    $details = $_POST['details'] ?? '';
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $noOfStocks = $_POST['noOfStocks'] ?? '';
    $category = $_POST['category'] ?? '';
    
    $newFileName = '';

    $file = $_FILES["picture"];
    $fileName = $file["name"];
    $fileTmpName = $file["tmp_name"];
    $fileSize = $file["size"];
    $fileError = $file["error"];

    if ($fileError === 0) {
        $accepted_type = array('jpg', 'jpeg', 'gif', 'png', 'jfif');
        $getExtension = explode('.', $fileName);
        $extension = strtolower(end($getExtension));

        if (in_array($extension, $accepted_type)) {
            if ($fileSize < 5000000) {
                $newFileName = uniqid('img_', true) . "." . $extension;
                $fileDestination = '../src/images/' . $newFileName;
                move_uploaded_file($fileTmpName, $fileDestination);
            } 
        } 
    }

    $query = "INSERT INTO product_tbl(productName, productPrice, productDetails, productPicture, productStocks, noOfStocks, category)VALUES(?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($query);
    $parameters = [$name, $price, $details, $newFileName, $stock, $noOfStocks, $category];

    if(!$stmt->execute($parameters)){
      header("Location: ../src/pages/add.php");
    } else {
      header("Location: ../src/pages/add.php");
    }
  }catch(PDOException $e){
    error_log("Failed to add Item: " . $e->getMessage());
  }
}

$pdo = null;

?>