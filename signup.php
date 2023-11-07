<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up</title>
    <link rel="stylesheet" href="sstyle.css">
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
    <div class="signup-container">
        <h1>Sign-up</h1>
        <form id="signup-form" method="post" action="">
            <?php
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                };
            }
            ?>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="Email" required>
            <br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="Username" required>
            <br>
            <label for="phno">Phone Number:</label>
            <input type="text" id="phno" name="Phone_no" required>
            <br>
            <label for="password">Set password:</label>
            <input type="password" id="password" name="Set_Pwd" required>
            <br>
            <label for="cpassword">Confirm password:</label>
            <input type="password" id="cpassword" name="Confirm_Pwd" required>
            <br>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>

<?php
// Establish connections to the databases
$connUser = mysqli_connect("localhost", "root", "", "user_db");
$connLogin = mysqli_connect("localhost", "root", "", "websitelogin");

// Check the connections
if (!$connUser || !$connLogin) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $Email = mysqli_real_escape_string($connUser, $_POST['Email']);
    $User = mysqli_real_escape_string($connUser, $_POST['Username']);
    $Phone_no = mysqli_real_escape_string($connUser, $_POST['Phone_no']);
    $Set_Pwd = md5($_POST['Set_Pwd']);
    $Confirm_Pwd = md5($_POST['Confirm_Pwd']);

    // Check if the email already exists in the user_form table
    $checkEmailQuery = "SELECT * FROM user_form WHERE Email = '$Email'";
    $result = mysqli_query($connUser, $checkEmailQuery);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'Email already exists!';
    } else {
        // Check if passwords match
        if ($Set_Pwd !== $Confirm_Pwd) {
            $error[] = 'Passwords do not match!';
        } else {
            // Insert username and password into the logindetails table
            $insertQuery = "INSERT INTO logindetails (Username, Password) VALUES ('$User', '$Set_Pwd')";

            if (mysqli_query($connLogin, $insertQuery)) {
                header('location: login.php');
                exit();
            } else {
                $error[] = 'Error: ' . mysqli_error($connLogin);
            }
        }
    }
}

mysqli_close($connUser);
mysqli_close($connLogin);
?>
