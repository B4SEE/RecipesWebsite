<?php

/**
 * This file is responsible for displaying user information in HTML format.
 * It contains functions for echoing user information, handling user deletion, and user login.
 * It also includes database operations for retrieving user data.
 */

require_once "config.php";
require_once 'crud.php';

session_status() === PHP_SESSION_ACTIVE ?: session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    redirectToLogin();
} else if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin')) {
    redirectToIndex();
} else if (isset($_GET['delete']) && $_GET['delete'] == 'true' && isset($_GET['userId'])) {

    if ($_GET['userId'] == $_SESSION['user_id']) {
        header('Location: admin_page.php');
        exit();
    }

    $userId = htmlspecialchars($_GET['userId']);
    
    deleteUser($userId);

    header('Location: admin_page.php');
    exit();
} else if (isset($_GET['login']) && $_GET['login'] == 'true' && isset($_GET['userId'])) {
    $userId = htmlspecialchars($_GET['userId']);
    $user = getByColumn('users', 'id', $userId)[0];
    setLoginSession($user);
    redirectToIndex();
} else if (isset($_GET['username'])) {
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $username = htmlspecialchars($_GET['username']);
    $query = "SELECT * FROM users WHERE username LIKE '%$username%' OR email LIKE '%$username%'";
    $result = mysqli_query($conn, $query);
    $conn->close();

    foreach ($result as $user) {
        echoUserInformation($user);
    }
} else if (!isset($_GET['userId'])) {
    redirectToIndex();
} else {
    $userId = htmlspecialchars($_GET['userId']);

    echo "User information: <br />";

    $user = getByColumn('users', 'id', $userId)[0];
    echoUserInformation($user);
}
