<?php

require_once("../../config/conn.php");
session_start();

if(empty($_SESSION['username'])){
  header("Location: ../../index.php");
}

$query = "SELECT * FROM product_tbl ORDER BY productID";

$stmt = $pdo->prepare($query);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Table</title>
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>

<nav>
    <button popovertarget="addItem">Add Item</button>
    <a href="../../remote/logout.php?logout=yes"><button>Logout</button></a>
</nav>

<h1>Item List</h1>

<table>
    <thead>
        <tr>
            <th>Item Name</th>
            <th>Picture</th>
            <th>Details</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
      <div id="addItem" popover>
        <form id="addItemForm" action="../../remote/add.php" method="POST" enctype="multipart/form-data">
          <h2>Add Item</h2>
          <label for="itemName">Item Name:</label>
          <input type="text" id="itemName" name="name" required>

          <label for="itemPicture">Picture:</label>
          <input type="file" id="itemPicture" name="picture" accept="image/*" required>

          <label for="itemDetails">Details:</label>
          <input type="text" id="itemDetails" name="details" required>

          <label for="itemPrice">Price:</label>
          <input type="text" id="itemPrice" name="price" step="0.01" required>

          <label for="itemStock">Stock:</label>
          <select id="itemStock" name="stock" required>
              <option value="">Select Stock Status</option>
              <option value="In Stock">In Stock</option>
              <option value="Out of Stock">Out of Stock</option>
          </select>

          <button type="submit" name="add">Add Item</button>
        </form>
      </div>
      <?php while($data = $stmt->fetch()) { ?>
        <div class="item-container" id="view<?php echo $data->productID ?>" popover>
            <strong><?php echo $data->productName ?></strong><br/>
            <div>
              <img src="../images/<?php echo $data->productPicture ?>" alt="Item 1" style="width:50px;">
            </div><br/>
            <h1>Price: ₱<?php echo $data->productPrice ?></h1><br/>
            <h1>Stock: <?php echo $data->productStocks ?></h1><br/>     
            <h1>Details: <?php echo $data->productDetails ?></h1><br/>
        </div>
        <tr>
            <td><?php echo $data->productName; ?></td>
            <td><img src="../images/<?php echo $data->productPicture; ?>" alt="Item 1"></td>
            <td><?php echo $data->productDetails; ?></td>
            <td><?php echo $data->productPrice; ?></td>
            <td><?php echo $data->productStocks; ?></td>
            <td class="action-buttons">
                <button popovertarget="view<?php echo $data->productID ?>">View</button>
                <button>Edit</button>
                <a href="../../remote/delete.php?id=<?php echo $data->productID ?>"><button>Delete</button></a>
            </td>
        </tr>
      <?php } ?>
    </tbody>
</table>

</body>
</html>
