<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Arsen - Gaming Hardware</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./src/css/index.css" />
  </head>
  <body>
    <header>
      <h1>Welcome to Arsen</h1>
      <p>Your one-stop shop for all needs!</p>
    </header>

    <nav>
      <a href="./index.php"><i class="fas fa-home"></i> Home</a>
      <a href="./src/pages/login.php"
        ><i class="fas fa-sign-in-alt"></i> Login</a
      >
      <a href="./src/pages/signup.php"
        ><i class="fas fa-user-plus"></i> Signup</a
      >
    </nav>

    <section class="hero">
      <h1>Discover Amazing Products</h1>
      <p>
        Explore unbeatable deals on gaming consoles, accessories, and more!
      </p>
      <a href="./src/pages/login.php" class="btn"
        >Shop Now <i class="fas fa-arrow-right"></i
      ></a>
    </section>

    <div class="features">
      <div class="feature">
        <i class="fas fa-truck"></i>
        <h3>Fast Delivery</h3>
        <p>Free shipping on orders over ₱1000</p>
      </div>
      <div class="feature">
        <i class="fas fa-shield-alt"></i>
        <h3>Secure Payment</h3>
        <p>100% secure payment processing</p>
      </div>
      <div class="feature">
        <i class="fas fa-headset"></i>
        <h3>24/7 Support</h3>
        <p>Dedicated support team</p>
      </div>
    </div>

    <section class="products">
      <div class="product">
        <img
          src="./src/images/featured/Memorysolution-GPU-Servers.png"
          alt="Graphics Card"
        />
        <h3>Graphics Card</h3>
        <div class="price">₱1,350</div>
        <button popovertarget="do" class="btn"
          ><i class="fas fa-shopping-cart"></i> Add to Cart</button
        >
      </div>

      <div class="product">
        <img
          src="./src/images/featured/nintendo-gameboy-advance-sp.jpg"
          alt="Gameboy 2008"
        />
        <h3>Gameboy 2008</h3>
        <div class="price">₱350</div>
        <button popovertarget="do" class="btn"
          ><i class="fas fa-shopping-cart"></i> Add to Cart</button
        >
      </div>

      <div class="product">
        <img
          src="./src/images/featured/psp-4d4df3dba73b41689d245d30ad2b6fb2.jpg"
          alt="PSP 2011"
        />
        <h3>PSP 2011</h3>
        <div class="price">₱699</div>
        <button popovertarget="do" class="btn"
          ><i class="fas fa-shopping-cart"></i> Add to Cart</button
        >
      </div>
    </section>

    <div id="do" popover>
      <h1>Login/Signup first to checkout products.</h1>
      <a href="./src/pages/login.php" class="btn" id="do-this">Login / Signup</a>
    </div>


    <footer>
      <p>&copy; 2025 Arsen. All rights reserved.</p>
    </footer>
  </body>
</html>
