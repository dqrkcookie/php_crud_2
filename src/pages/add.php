<?php

require_once('../../config/conn.php');
require('./nav.php');

if(empty($_SESSION['admin'])){
  header("Location: ../../index.php");
}

$query = "SELECT * FROM product_tbl ORDER BY productID";

$stmt = $pdo->prepare($query);
$stmt->execute();

?>

<link rel="stylesheet" href="../css/add.css">

<section>
  <div class="button">
    <h1>Item List</h1>
    <button popovertarget="addItem">Add Item</button>
  </div>
  
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

            <button type="submit" name="add">Add now</button>
          </form>
        </div>
        <?php while($data = $stmt->fetch()) { ?>
          <div class="item-container" id="view<?php echo $data->productID ?>" popover>
              <strong><?php echo $data->productName ?></strong><br/>
              <div>
                <img src="../images/<?php echo $data->productPicture ?>" alt="Item picture">
              </div><br/>
              <h1>Price: ₱<?php echo $data->productPrice ?></h1><br/>
              <h1>Stock: <?php echo $data->productStocks ?></h1><br/>     
              <h1>Details: <?php echo $data->productDetails ?></h1><br/>
          </div>
          <div class="editItem" id="editItem-<?php echo $data->productID ?>" popover>
            <form id="addItemForm" action="../../remote/edit.php" method="POST" enctype="multipart/form-data">
              <h2>Edit Item</h2>
              <input type="hidden" name="productID" value="<?php echo $data->productID ?>">
              <label for="itemName">Item Name:</label>
              <input type="text" id="itemName" name="name" value="<?php echo $data->productName ?>">

              <label for="itemPicture">Picture:</label>
              <input type="file" id="itemPicture" name="picture" accept="image/*">

              <label for="itemDetails">Details:</label>
              <input type="text" id="itemDetails" name="details" value="<?php echo $data->productDetails ?>">

              <label for="itemPrice">Price:</label>
              <input type="text" id="itemPrice" name="price" step="0.01" value="<?php echo $data->productPrice ?>">

              <label for="itemStock">Stock:</label>
              <select id="itemStock" name="stock" value="<?php echo $data->productStocks ?>" required>
                  <option value="">Select Stock Status</option>
                  <option value="In Stock">In Stock</option>
                  <option value="Out of Stock">Out of Stock</option>
              </select>

              <button type="submit" name="update">Update now</button>
            </form>
          </div>
          <tr>
              <td><?php echo $data->productName; ?></td>
              <td id="img-td"><img src="../images/<?php echo $data->productPicture; ?>" alt="Item 1"></td>
              <td><?php echo $data->productDetails; ?></td>
              <td>₱<?php echo $data->productPrice; ?></td>
              <td><?php echo $data->productStocks; ?></td>
              <td class="action-buttons">
                  <button popovertarget="view<?php echo $data->productID ?>">View</button>
                  <button popovertarget="editItem-<?php echo $data->productID ?>">Edit</button>
                  <a href="../../remote/delete.php?id=<?php echo $data->productID ?>"><button>Delete</button></a>
              </td>
          </tr>
        <?php } ?>
      </tbody>
  </table>
</section>
    