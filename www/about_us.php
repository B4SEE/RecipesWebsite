<?php

/**
 * This file represents the "About Us" page of the website.
 * It includes the necessary HTML, CSS, and JavaScript files to display the page content.
 * The session is started if it is not already active.
 * The header, main content, and footer sections are included using PHP's include statement.
 */
session_status() === PHP_SESSION_ACTIVE ?: session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./general_style.css" type="text/css">
    <link rel="stylesheet" href="./about_us_style.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="./PROJECT_files/favicon.ico">

    <script type="module" src="./index.js"></script>

    <title>About us</title>
</head>

<body>
    <?php include './header.php'; ?>
    <main>
        <section class="hero">
            <h1>citatko</h1>
        </section>
        <?php include './about_us_content.html'; ?>

    </main>
    <?php include './footer.html'; ?>
</body>

</html>