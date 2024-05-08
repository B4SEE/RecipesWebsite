<?php

/**
 * This file represents the admin page of the website.
 * It displays a form to select a user and retrieve their information.
 * Only logged-in users with the 'admin' role can access this page.
 */

require_once 'config.php';
require_once 'crud.php';
session_status() === PHP_SESSION_ACTIVE ?: session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  redirectToLogin();
} else if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin')) {
  redirectToIndex();
}

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="./general_style.css" type="text/css">
  <link rel="stylesheet" href="./admin_page_style.css" type="text/css">
  <link rel="icon" type="image/x-icon" href="./PROJECT_files/favicon.ico">
  <script type="module" src="./admin.js"></script>
  <title>Admin page</title>
</head>

<body>

  <h2>Get user information</h2>

  <form>
    <select name="users">
      <option value="">Select user:</option>
      <?php
      $users = getAllFromColumn('users', 'username');
      foreach ($users as $user) {
        echo '<option value="' . htmlspecialchars($user['id']) . '">' . htmlspecialchars($user['username']) . '</option>';
      }
      ?>
    </select>
    <input name="input_users" type="text" placeholder="or type user name" />
  </form>
  <br />
  <a href="./index.php">Back to index</a>
  <div id="txtHint">User info will be listed here...</div>
</body>

</html>