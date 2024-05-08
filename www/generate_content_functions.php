<?php

/**
 * This file contains functions for generating and displaying content on a website.
 * It includes functions for generating menus, recipe cards, comments, and user information.
 */

/**
 * Generates a menu based on the given result set.
 *
 * @param mysqli_result $result The result set containing the data.
 * @return void
 */
function generateMenu($result)
{
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $recipe = getByColumn('recipes', 'id', $row['id'])[0];
            $recipeName = htmlspecialchars($recipe['name']);
            $recipeId = htmlspecialchars($recipe['id']);
            echo '<li><a href="recipe.php?recipeId=' . $recipeId . '">' . substr($recipeName, 0, 15) . '</a></li>';
        }
    } else {
        echo '<li>No recipes found</li>';
    }
}

/**
 * Displays a recipe card row with the given recipe data.
 *
 * @param array $recipe The recipe data.
 * @return void
 */
function displayRecipeCardRow($recipe)
{
    $recipeName = htmlspecialchars($recipe['name']);
    $recipeDescription = htmlspecialchars($recipe['description']);
    $recipeImage = cropImage(htmlspecialchars($recipe['image_path']), 403, 212.04);
    $recipeId = htmlspecialchars($recipe['id']);

    echo '<div class="card">';
    echo '<div class="card_image_div">';
    echo '<img class="card_image" src="./' . $recipeImage . '" alt="recipe_image_cropped">';
    echo '</div>';
    if (strlen($recipeName) > 15) {
        echo '<h2>' . substr($recipeName, 0, 15) . '...' . '</h2>';
    } else {
        echo '<h2>' . $recipeName . '</h2>';
    }
    if (strlen($recipeDescription) > 30) {
        echo '<p>' . substr($recipeDescription, 0, 30) . '...' . '</p>';
    } else {
        echo '<p>' . $recipeDescription . '</p>';
    }
    echo '<div class="button">';
    echo '<a href="recipe.php?recipeId=' . $recipeId . '">More</a>';
    echo '</div>';
    echo '</div>';
}

/**
 * Display a recipe card column with the given recipe data.
 *
 * @param array $recipe The recipe data.
 * @return void
 */
function displayRecipeCardColumn($recipe)
{
    $recipeName = htmlspecialchars($recipe['name']);
    $recipeDescription = htmlspecialchars($recipe['description']);
    $recipeImage = cropImage(htmlspecialchars($recipe['image_path']), 403, 322);
    $recipeId = htmlspecialchars($recipe['id']);

    echo '<div class="card">';
    echo '<div class="card_image_div">';
    echo '<img src="./' . $recipeImage . '" alt="recipe_image_cropped">';
    echo '</div>';
    echo '<div class="card_content">';
    if (strlen($recipeName) > 25) {
        echo '<h2>' . substr($recipeName, 0, 25) . '...' . '</h2>';
    } else {
        echo '<h2>' . $recipeName . '</h2>';
    }
    if (strlen($recipeDescription) > 70) {
        echo '<p>' . substr($recipeDescription, 0, 70) . '...' . '</p>';
    } else {
        echo '<p>' . $recipeDescription . '</p>';
    }
    echo '<div class="button">';
    echo '<a href="recipe.php?recipeId=' . $recipeId . '">More</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

/**
 * Displays comments for a given recipe ID.
 *
 * @param int $recipeId The ID of the recipe.
 * @return void
 */
function displayComments($recipeId)
{
    require_once "config.php";
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $query = "SELECT * FROM comments WHERE recipe_id LIKE '%$recipeId%' ORDER BY date DESC, time DESC";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $content = htmlspecialchars($row['content']);
            $author = htmlspecialchars(getByColumn('users', 'id', $row['author_id'])[0]['username']);
            $image = htmlspecialchars(getByColumn('users', 'id', $row['author_id'])[0]['image_path']);
            $time = htmlspecialchars($row['time']);
            $date = htmlspecialchars($row['date']);

            echo '<div class="comment">';
            echo '<div class="user">';
            echo '<div class="comment_profile_picture_div">';
            echo '<img src="./' . $image . '" alt="profile picture" class="comment_profile_picture">';
            echo '</div>';
            echo '<p class="comment_author">' . $author . '</p>';
            echo '</div>';
            echo '<p class="comment_content">' . $content . '</p>';
            echo '<p class="comment_time">' . $time . '</p>';
            echo '<p class="comment_date">' . $date . '</p>';
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
                if ($_SESSION['user_id'] == $row['author_id'] || $_SESSION['role'] == 'admin') {
                    echo '<a href="comment.php?delete=true&commentId=' . $row['id'] . '&recipeId=' . $recipeId . '" class="comment_delete_button">Delete</a>';
                }
            }
            echo '</div>';
        }
    } else {
        echo '<h2>No comments</h2>';
    }

    mysqli_close($conn);
}

/**
 * Displays user information in an HTML format.
 *
 * @param array $user The user information.
 * @return void
 */
function echoUserInformation($user)
{
    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<script src="admin.js"></script>';
    echo '<body>';
    echo "<p>Username: " . $user['username'] . "</p>";
    echo "<p>Email: " . $user['email'] . "</p>";
    echo "<p>Role: " . $user['role'] . "</p>";
    echo "<br />";
    echo '<a class="delete_button" href="getUser.php?delete=true&userId=' . $user['id'] . '">Delete user</a>';
    echo '<a class="normal_button" href="getUser.php?login=true&userId=' . $user['id'] . '">Login as</a>';
    echo "<br /><br /><br />";
    echo '</body>';
    echo '</html>';
}
?>