<?php

/**
 * This file contains functions related to searching and retrieving recipes from the database.
 * It includes functions for retrieving the last inserted ID, searching recipes based on input,
 * retrieving a specified number of recipes, and getting recipes with the maximum number of comments.
 */

/**
 * Retrieves the last inserted ID from the 'recipes' table.
 *
 * @return int The last inserted ID.
 */
function getLastInsertedId()
{
    require_once "config.php";
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql = "SELECT id FROM recipes ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $conn->close();
    return $row['id'];
}

/**
 * Search recipes based on the given search input, limit, and offset.
 *
 * @param string $searchInput The search input to match against recipe name, description, and ingredients.
 * @param int|null $limit The maximum number of recipes to retrieve. If null, retrieves all matching recipes.
 * @param int|null $offset The number of recipes to skip before retrieving results. If null, starts from the beginning.
 * @return mysqli_result|bool The result set of the query or false on failure.
 */
function searchRecipes($searchInput, $limit, $offset)
{
    require_once "config.php";
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($limit == Null && $offset == Null) {
        $query = "SELECT * FROM recipes WHERE name LIKE '%$searchInput%' OR description LIKE '%$searchInput%' OR ingredients LIKE '%$searchInput%' ORDER BY name";
    } else {
        $query = "SELECT * FROM recipes WHERE name LIKE '%$searchInput%' OR description LIKE '%$searchInput%' OR ingredients LIKE '%$searchInput%'LIMIT $limit OFFSET $offset";
    }
    $result = mysqli_query($conn, $query);
    $conn->close();
    return $result;
}

/**
 * Search for recipes based on a search input and return a specified number of results.
 *
 * @param string $searchInput The search input to match against recipe names, descriptions, and ingredients.
 * @param int $n The number of results to return.
 * @return mysqli_result|bool The result set of recipes matching the search input, or false on failure.
 */
function searchNRecipes($searchInput, $n)
{
    require_once "config.php";
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $query = "SELECT * FROM recipes WHERE name LIKE '%$searchInput%' OR description LIKE '%$searchInput%' OR ingredients LIKE '%$searchInput%' ORDER BY RAND() LIMIT $n";
    $result = mysqli_query($conn, $query);
    $conn->close();
    return $result;
}

/**
 * Retrieves the N recipes with the maximum number of comments.
 *
 * @param int $n The number of recipes to retrieve.
 * @return mysqli_result|bool The result set containing the recipe IDs, or false on failure.
 */
function getNRecipeWithMaxComments($n)
{
    require_once "config.php";
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql = "SELECT recipe_id FROM comments GROUP BY recipe_id ORDER BY COUNT(*) DESC LIMIT $n";
    $result = mysqli_query($conn, $sql);
    $conn->close();
    return $result;
}
?>