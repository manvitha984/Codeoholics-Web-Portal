<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="lstyle.css">
</head>
<body>
    <header>
        <nav>
            <div class="user-actions">
                <a href="index.html">←</a>
            </div>
        </nav>
    </header>

    <div class="background-image"></div>
    <div class="login-container">
        <h1>Login</h1>
        <form id="login-form" method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="Username" name="Username">
            <br>
            <label for="password">Password:</label>
            <input type="password" id="Password" name="Password">
            <br>
            <input type="submit" value="Login" class="logBtn" name="login_btn">
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>

<?php
// Establish a connection to the database
$conn = mysqli_connect("localhost", "root", "", "websitelogin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login_btn'])) {
    $Username = mysqli_real_escape_string($conn, $_POST['Username']);
    $Password = md5($_POST['Password']); // Assuming passwords are stored as MD5 hashes

    $sql = "SELECT * FROM logindetails WHERE Username = '$Username' AND Password = '$Password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Login successful
        header('Location: index.html');
        exit();
    } else {
        echo "<script>alert('Login unsuccessful');</script>";
    }
}

mysqli_close($conn);
?>
