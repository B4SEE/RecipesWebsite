<?php

/**
 * This file contains a collection of functions related to user control and validation.
 * It includes functions for sanitizing user input, setting login sessions, redirecting users to different pages, and deleting users from the database.
 */

/**
 * Sanitizes user input by removing leading/trailing whitespace, backslashes, and converting special characters to HTML entities.
 *
 * @param string $data The input data to be sanitized.
 * @return string The sanitized input data.
 */
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Sets the login session for the user.
 *
 * @param array $user The user data.
 * @return void
 */
function setLoginSession($user)
{
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    $_SESSION["username"] = $user["username"];
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["role"] = $user["role"];
    $_SESSION["user_image"] = $user["image_path"];
    $_SESSION["logged_in"] = true;
}

/**
 * Redirects the user to the index.php page.
 * This function sends a HTTP header to the browser to redirect the user to the specified page.
 * After sending the header, the function exits the script execution.
 */
function redirectToIndex()
{
    header('Location: index.php');
    exit();
}

/**
 * Redirects the user to the login page.
 * This function sends a HTTP header to the client's browser, instructing it to redirect to the login.php page.
 * After sending the header, the function exits the script execution.
 */
function redirectToLogin()
{
    header('Location: login.php');
    exit();
}

/**
 * Redirects the user to the recipe page with the specified recipe ID.
 *
 * @param int $recipeId The ID of the recipe to redirect to.
 * @return void
 */
function redirectToRecipe($recipeId)
{
    header('Location: recipe.php?recipeId=' . $recipeId);
    exit();
}

/**
 * Deletes a user and associated data from the database.
 *
 * @param int $userId The ID of the user to be deleted.
 * @return void
 */
function deleteUser($userId)
{
    $username = getByColumn('users', 'id', $userId)[0]['username'];
    rrmdir('uploads/' . $username);
    deleteDataById('users', $userId);
    $recipes = getAllWithColumnValue('recipes', 'author_id', $userId);
    if ($recipes) {
        foreach ($recipes as $recipe) {
            deleteDataByColumn('comments', 'recipe_id', $recipe['id']);
        }
    }
    deleteDataByColumn('recipes', 'author_id', $userId);
    deleteDataByColumn('comments', 'author_id', $userId);
}
?>