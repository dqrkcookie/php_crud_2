<?php

require_once("../../config/conn.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rakk</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div>
        <form action="../../remote/adminlogin.php" method="POST">
            <h1>Admin Log in</h1>
            <input id="email" type="text" placeholder="Username" name="username" required/>
            <input id="password" type="password" placeholder="Password" name="password" required/>
            <input id="submit" type="submit" value="Log in" name="submit" />
        </form>
    </div>
</body>

</html>