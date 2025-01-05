<?php

session_start();
require_once('../../config/conn.php');

if(empty($_SESSION['username'])){
  header("Location: ../../index.php");
  die();
}

$username = $_SESSION['username'];

$search = $_GET['search'] ?? '';
$concatenateSearch = '%' . $search . '%';
$query = "SELECT * FROM product_tbl WHERE productName LIKE ?";
$stmt = $pdo->prepare($query);
$stmt->bindParam(1, $concatenateSearch);
$stmt->execute();
$data = $stmt->fetchALL();

$getData = $pdo->query("SELECT * FROM users_tbl WHERE username = '$username'");
$user = $getData->fetch();

$cartQuery = "SELECT * FROM rakkcart WHERE username = ?";
$stmtCart = $pdo->prepare($cartQuery);
$stmtCart->execute([$username]);
$cartItems = $stmtCart->fetchAll();

$pendingQuery = "SELECT * FROM placed_order WHERE username = ?";
$stmtPending = $pdo->prepare($pendingQuery);
$stmtPending->execute([$username]);
$pendingOrders = $stmtPending->fetchAll();

$notifQuery = "SELECT * FROM order_notifications WHERE username = ? AND is_read = ?";
$is_read = false;
$stmtNotif = $pdo->prepare($notifQuery);
$stmtNotif->execute([$username, $is_read]);
$notification = $stmtNotif->fetchAll();

$histoQuery = "SELECT * FROM transaction_history WHERE name = ?";
$stmtHisto = $pdo->prepare($histoQuery);
$stmtHisto->execute([$username]);
$history = $stmtHisto->fetchAll();

$id = uniqid();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rakk</title>
  <link rel="stylesheet" href="../css/main.css">
  <script src="https://kit.fontawesome.com/b70669fb91.js" crossorigin="anonymous"></script>
</head>
<body>

<nav>
  <ul>
    <li><a href="./main.php"><span>Rakk</span></a></li>
    <li>
      <form action="">
        <input type="text" name="search" placeholder="Search item">
        <button type="submit"><i class="fa-solid fa-magnifying-glass fa-lg" style="color: #4caf50;"></i></button>
      </form>
    </li>
    <li><?php if(!empty($cartItems)) { ?>
      <span id="num"><?php echo count($cartItems) ?></span>
    <?php } ?></span><button popovertarget="cart"><i class="fa-solid fa-cart-shopping fa-lg" style="color: #4caf50;"></i> Cart</button></li>
    <li><?php if(!empty($pendingOrders)) { ?>
      <span id="num"><?php echo count($pendingOrders) ?></span>
    <?php } ?></span><button popovertarget="orders"><i class="fa-solid fa-check fa-lg" style="color: #4caf50;"></i> My Orders</button></li>
    <li><button popovertarget="history"><i class="fa-regular fa-clock" style="color: #4caf50;"></i> History</button></li>
    <li><button popovertarget="account"><i class="fa-solid fa-gear" style="color: #4caf50;"></i> Account</button></li>
    <li><a href="../../remote/logout.php"><button><i class="fa-solid fa-right-from-bracket" style="color: #4caf50;"></i> Log out</button></a></li>
  </ul>
</nav>

<div class="pop-up" id="cart" popover>
    <h1>Cart</h1>
    <table>
      <thead>
        <tr>
          <th>Item Name</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php $total = 0; ?>
      <?php foreach($cartItems as $cartItem) { ?>
        <?php $total += ($cartItem->price * $cartItem->quantity) ?>
        <tr>
          <td><?php echo $cartItem->name ?></td>
          <td><?php echo $cartItem->quantity ?></td>
          <td><?php echo $cartItem->price ?></td>
          <td><a href="../../remote/remove.php?name=<?php echo $cartItem->name ?>&username=<?php echo $username ?>"><i class="fa-solid fa-trash fa-lg" style="color: #4caf50;"></i></a></td>
        </tr>
      <?php } ?>
      <?php if(!empty($cartItems)) { ?>
        <tr>
          <td>Total</td>
          <td>₱<?php echo $total ?></td>
          <td colspan="2"><button popovertarget="confirm" id="checkout">Checkout</button></td>
        </tr>
      <?php } else { ?>
        <tr>
          <td colspan=""4>Cart is empty</td>
        </tr>
      <?php } ?>
      </tbody>
    </table> 
</div>

<div class="confirm" id="confirm" popover>
    <h1>Confirm Order</h1>
    <span>MOP: Cash on Delivery</span>
    <br> <br>
    <span>Address: <?php echo $user->address ?></span>
    <div>
      <a href="../../remote/checkout.php?amount=<?php echo $total ?>&id=<?php echo $id ?>&username=<?php echo $username ?>&address=<?php echo $user->address ?>&status=yes"><button>Yes</button></a>
      <a href="./main.php"><button>No</button></a>
    </div>
</div>

<div class="pop-up" id="orders" popover>
  <h1>Pending Orders</h1>
  <table>
    <thead>
      <tr>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($pendingOrders as $order) { ?>
        <tr>
          <td><?php echo $order->name ?></td>
          <td><?php echo $order->quantity ?></td>
          <td><?php echo $order->price ?></td>
        </tr>
      <?php } ?>
      <?php if(empty($pendingOrders)) { ?>
        <tr>
          <td>No pending orders.</td>
        </tr>
      <?php } else if(!empty($pendingOrders) && empty($notification)){ ?>
        <tr>
          <td><span class="msg">Wait for Rakk's confirmation.</span></td>
        </tr>
      <?php } ?>
      <?php $orderIds = [] ?>
      <?php if(!empty($notification)) { ?>
        <?php foreach($notification as $notif) { ?>
          <?php if(!in_array($notif->order_id, $orderIds)) { ?>
            <?php array_push($orderIds, $notif->order_id) ?>
              <tr>
                <td colspan="2">Your order <span class="msg"><?php $toArr = json_decode($notif->items);echo implode(' & ', $toArr) ?></span> will arrive soon. Prepare <span class="msg">₱<?php echo $notif->amount ?></span></td>
                <td id="btn"><a href="../../remote/received.php?amount=<?php echo $notif->amount ?>&name=<?php echo $username ?>&status=success"><button class="btn">Received</button></a> <a href="../../remote/received.php?amount=<?php echo $notif->amount ?>&name=<?php echo $username ?>&status=failed"><button class="btn">Return</button></a></td>
              </tr>
          <?php } ?>
          <?php } ?>
        <?php } ?>
    </tbody>
  </table>
</div>

<div class="pop-up" id="history" popover>
  <h1>Purchase History</h1>
  <table>
    <thead>
      <tr>
        <th>Order Id</th>
        <th>Amount</th>
        <th>Date Delivered</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($history)) { ?>
        <?php foreach($history as $h) { ?>
          <tr>
            <td><?php echo $h->orderID ?></td>
            <td>₱<?php echo $h->amount ?></td>
            <td><?php echo $h->transactionDate ?></td>
          </tr>
        <?php } ?>
      <?php } ?>
    </tbody>
  </table>
</div>

<div class="account-settings" id="account" popover>
    <h1>Account Settings</h1>
    <div class="profile-section">
      <div class="profile-picture">
        <img src="../images/profile_picture/<?php echo $user->profile_picture ?>" alt="Profile Picture">
      </div>
    </div>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Username</th>
          <th>Address</th>
          <th>Mobile No.</th>
          <th>Birthday</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $user->name ?></td>
          <td><?php echo $user->email ?></td>
          <td><?php echo $user->username ?></td>
          <td><?php echo $user->address ?></td>
          <td><?php echo $user->mobile ?></td>
          <td><?php echo $user->birthday ?></td>
        </tr>
        <tr>
        <td colspan="6"><button popovertarget="update">Update Profile</button></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="account-settings" id="update" popover>
    <h1>Update Profile</h1>
    <form action="../../remote/update.php" method="POST" enctype="multipart/form-data">
      <div class="profile-section">
        <div class="profile-picture">
          <img src="../images/profile_picture/<?php echo $user->profile_picture ?>" alt="Profile Picture">
          <br>
          <input type="file" accept="image/*" name="profile_picture" value="<?php echo $user->profile_picture ?>" required>
        </div>
      </div>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Address</th>
            <th>Password</th>
            <th>Mobile No.</th>
            <th>Birthday</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td><input type="text" name="name" value="<?php echo $user->name ?>" required></td>
              <td><input type="text" name="email" value="<?php echo $user->email ?>" required></td>
              <td><input type="text" name="username" value="<?php echo $user->username ?>" required></td>
              <td><input type="text" name="address" value="<?php echo $user->address ?>" required></td>
              <td><input type="password" name="password" required></td>
              <td><input type="tel" name="mobile" value="<?php echo $user->mobile ?>" required></td>
              <td><input type="date" name="birthday" value="<?php echo $user->birthday ?>" required></td>
            </tr>
            <tr>
            <td colspan="7"><button type="submit" name="save">Save</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </form>

<section>
  <?php foreach($data as $item) { ?>
    <?php if($item->noOfStocks > 0) { ?>
      <div class="item-card">
        <img src="../images/<?php echo $item->productPicture ?>" alt="Shop Item">
        <div class="item-details">
          <h3><?php echo $item->productName ?></h3>
          <p class="description"><?php echo $item->productDetails ?>.</p>
          <form action="../../remote/addtocart.php" method="GET">
            <div class="price-qty">
              <span class="price">₱<?php echo $item->productPrice ?></span>
              <input type="number" value="1" min="1" name="qty">
            </div>
            <input type="hidden" name="name" value="<?php echo $item->productName ?>">
            <input type="hidden" name="price" value="<?php echo $item->productPrice ?>">
            <input type="hidden" name="username" value="<?php echo 
            $username ?>">
            <button type="submit" class="add-to-cart">Add to Cart</button>
          </form>
          <?php if($item->noOfStocks < 25) {?>
            <p><?php echo $item->noOfStocks . ' item(s) left' ?></p>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
  <?php } ?>
</section>
  
</body>
</html>