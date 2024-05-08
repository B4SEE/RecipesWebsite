<?php

/**
 * This file contains the login functionality of the website.
 * It handles user authentication and session management.
 */

require_once "crud.php";

$usernameErr = $passwordErr = "";
$username = $password =  "";

session_status() === PHP_SESSION_ACTIVE ?: session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
    session_destroy();

    redirectToIndex();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
        $user = getByColumn("users", "username", $username);
        if (!$user || !isset($user[0])) {
            $usernameErr = "Username does not exist";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        $user_password = isset($user[0]["password_hash"]) ? $user[0]["password_hash"] : null;
        if (!password_verify($password, $user_password)) {
            $passwordErr = "Wrong password";
        }
    }

    if ($usernameErr == "" && $passwordErr == "") {
        setLoginSession($user[0]);

        redirectToIndex();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./general_style.css" type="text/css">
    <link rel="stylesheet" href="./login_style.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="./PROJECT_files/favicon.ico">

    <script type="module" src="./login.js"></script>

    <title>Login</title>
</head>

<body>
    <main>
        <img src="./PROJECT_files/login_html_image.png" alt="food_image">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <a href="./index.php" class="logo">
                <img src="./PROJECT_files/website_icon.png" alt="logo">
                <span>Nazev</span>
            </a>
            <label for="username_input" hidden>Username</label>
            <input id="username_input" type="text" name="username" placeholder="Enter your username" value="<?php echo $username; ?>" maxlength="50">
            <span class="error"><?php echo $usernameErr; ?></span>
            <label for="password_input" hidden>Password</label>
            <input id="password_input" type="password" name="password" placeholder="Enter your password" value="<?php echo $password; ?>" maxlength="50">
            <span class="error"><?php echo $passwordErr; ?></span>
            <button class="login_button" type="submit">
                Login
            </button>
            <p>Don't have an account? <a href="./signup.php">Sign up</a></p>
        </form>
    </main>
</body>

</html>