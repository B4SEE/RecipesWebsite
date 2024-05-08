<?php

/**
 * This file handles the sign up functionality of the website.
 * It validates the user input for username, email, password, and profile image.
 * If the input is valid, it creates a new user account and redirects to the index page.
 * If there are any errors in the input, it displays error messages on the form.
 */

require_once "crud.php";
session_status() === PHP_SESSION_ACTIVE ?: session_start();

$usernameErr = $emailErr = $passwordErr = $confirm_passwordErr = $profile_imageErr = "";
$username = $email = $password = $confirm_password =  "";
$image_path = "uploads/default/default.png";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $usernameErr = "Only letters and numbers allowed";
        }
    }

    if (getByColumn("users", "username", $username)) {
        $usernameErr = "Username already exists";
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $password)) {
            $passwordErr = "Only letters and numbers allowed";
        }
    }

    if (empty($_POST["confirm_password"])) {
        $confirm_passwordErr = "Confirm password";
    } else {
        $confirm_password = test_input($_POST["confirm_password"]);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $confirm_password)) {
            $confirm_passwordErr = "Only letters and numbers allowed";
        } else if ($confirm_password != $password) {
            $confirm_passwordErr = "Passwords do not match";
        }
    }

    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    if ($image) {
        $image_size = $_FILES['image']['size'];
        $image_type = $_FILES['image']['type'];
        $image_parts = explode('.', $image);
        $image_ext = strtolower(end($image_parts));
        $extensions = array("jpeg", "jpg", "png");

        if (in_array($image_ext, $extensions) === false) {
            $profile_imageErr = "Extension not allowed, please choose a JPEG or PNG file.";
        }

        if ($image_size > 5000000) {
            $profile_imageErr = 'File size must be less than 5MB';
        }
    } else {
        $profile_imageErr = "Select an image";
    }

    if ($usernameErr == "" && $emailErr == "" && $passwordErr == "" && $confirm_passwordErr == "" && $profile_imageErr == "") {
        $image_path = "uploads/" . $username . "/" . $image;
        mkdir("uploads/" . $username);
        copy($image_tmp, $image_path);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        addDataToTable("users", array(Null, $username, $email, $hashed_password, $image_path, 'default'));
        $user = getByColumn("users", "username", $username);
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
    <link rel="stylesheet" href="./sign_up_style.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="./PROJECT_files/favicon.ico">

    <script type="module" src="./signup.js"></script>

    <title>Sign up</title>
</head>

<body>
    <main>
        <img src="./PROJECT_files/login_html_image.png" alt="food_image">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <a href="./index.php" class="logo">
                <img src="./PROJECT_files/website_icon.png" alt="logo">
                <span>Nazev</span>
            </a>
            <label for="username_input" hidden>Username *</label>
            <input id="username_input" type="text" name="username" placeholder="Enter your username *" value="<?php echo $username; ?>" maxlength="50">
            <span class="error"><?php echo $usernameErr; ?></span>
            <label for="email_input" hidden>Email *</label>
            <input id="email_input" type="email" name="email" placeholder="Enter your email *" value="<?php echo $email; ?>" maxlength="50">
            <span class="error"><?php echo $emailErr; ?></span>
            <label for="password_input" hidden>Password *</label>
            <input id="password_input" type="password" name="password" placeholder="Enter your password *" value="<?php echo $password; ?>" maxlength="50">
            <span class="error"><?php echo $passwordErr; ?></span>
            <label for="confirm_password_input" hidden>Confirm password *</label>
            <input id="confirm_password_input" type="password" name="confirm_password" placeholder="Repeat your password *" value="<?php echo $confirm_password; ?>" maxlength="50">
            <span class="error"><?php echo $confirm_passwordErr; ?></span>
            <p>Image</p>
            <div class="file_input_div">
                <label class="file_input" for="file_input">Choose file *</label>
            </div>
            <input id="file_input" type="file" name="image" accept="image/*" hidden>
            <span class="error"><?php echo $profile_imageErr; ?></span>
            <button class="submit_button" type="submit">
                Sign up
            </button>
        </form>
    </main>
</body>

</html>