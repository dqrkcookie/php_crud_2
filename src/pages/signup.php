<?php

require_once("../../config/conn.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ipsum</title>
    <link rel="stylesheet" href="../css/signup.css">
</head>

<body>
    <a href="../../index.php" title="Go back to Log in.">Back</a>
    <div>
        <form action="../../remote/signup.php" method="POST" enctype="multipart/form-data">
            <h1>Sign Up</h1>
            <input id="name" type="text" placeholder="Name.." name="name" required/>
            <input id="address" type="text" placeholder="Address.." name="address" required/>
            <input id="number" type="text" placeholder="Mobile Number.." name="number" required/>
            <input id="email" type="text" placeholder="Email Address.." name="email" required/>
            <input id="username" type="text" placeholder="Username.." name="username" required/>
            <input id="password" type="password" placeholder="Password.." name="password" required/>
            <label for="birthday">Birthday:</label>
            <input id="birthday" type="date" placeholder="Birthday.." name="birthday" required/>
            <label for="birthday">Picture:</label>
            <input id="profile" type="file" placeholder="Profile Picture.." name="profile" required/>
            <input id="submit" type="submit" value="Submit" name="submit" />
        </form>
    </div>
</body>

</html>