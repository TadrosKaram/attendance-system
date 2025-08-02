<?php

require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Note: The password is not hashed, which is insecure.
    // In real apps, use password_hash() and password_verify().
    // This is for non-sensitive, educational purposes only.

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM kada WHERE username = '$username' AND password = '$password'";
    $validateQuery = mysqli_query($conn, $query);

    if ($validateQuery) {
        if (mysqli_num_rows($validateQuery) > 0) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }
    } else {
        echo "<script>alert('Database query failed.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body style="background-color: #F7F7F7; display:flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column;">
    <h1>Login Page</h1>
    <img src="images.png" width="70px" alt="Logo" style="margin-bottom: 20px;">
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
    
</body>
</html>