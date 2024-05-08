<?php

/**
 * This code is responsible for handling comments on a website.
 * It checks if the user is logged in, adds a comment to the database,
 * deletes a comment from the database, and redirects the user to the
 * appropriate page based on the actions performed.
 */
session_status() === PHP_SESSION_ACTIVE ?: session_start();
require_once "crud.php";
date_default_timezone_set('Europe/Prague'); //Dirty hack, but I take into account that the site will be used only in the Czech Republic/Same time zone

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    redirectToLogin();
} else {
    if (isset($_GET['recipeId']) && isset($_GET['comment'])) {
        addDataToTable("comments", array(Null, htmlspecialchars($_GET['recipeId']), htmlspecialchars_decode(test_input($_GET['comment'])), $_SESSION['user_id'], date("H:i:s"), date("Y-m-d")));
        redirectToRecipe(htmlspecialchars($_GET['recipeId']));
    } else if (isset($_GET['delete']) && $_GET['delete'] == 'true' && isset($_GET['commentId']) && $_GET['commentId'] > 0 && isset($_GET['recipeId']) && $_GET['recipeId'] > 0) {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin' || $_SESSION['user_id'] == getByColumn('comments', 'id', $_GET['commentId'])[0]['author_id']) {
            deleteDataById('comments', $_GET['commentId']);
            redirectToRecipe(htmlspecialchars($_GET['recipeId']));
        } else {
            redirectToIndex();
        }
    } else if (isset($_GET['delete']) && $_GET['delete'] == 'true' && (isset($_GET['commentId']) && $_GET['commentId'] < 1 || isset($_GET['recipeId']) && $_GET['recipeId'] < 1)) {
        redirectToIndex();
    } else {
        redirectToIndex();
    }
}
