<?php

/**
 * This script is responsible for handling the search functionality on the website.
 * It retrieves the search input from either the GET or POST request and performs a search in the database.
 * The search results are displayed in a paginated manner, with a limit of 5 results per page.
 * The script also handles the navigation between pages of search results.
 */

require_once "crud.php";
session_status() === PHP_SESSION_ACTIVE ?: session_start();

// Retrieve the search input from either GET or POST request
if (isset($_GET['searchInput'])) {
    $searchInput = htmlspecialchars($_GET['searchInput']);
} else if (isset($_POST['search_input'])) {
    $searchInput = htmlspecialchars($_POST['search_input']);
} else {
    $searchInput = "";
}

// Determine the current page number
if (!isset($_GET['page'])) {
    $page_number = 1;
} else if (is_numeric($_GET['page'])) {
    $page_number = $_GET['page'];
} else {
    $page_number = 1;
}

// Perform the search and retrieve the total number of results
$result = searchRecipes($searchInput, Null, Null);
$total_results = $result->num_rows;

// Set the limit and offset for pagination
$limit = 5;
$offset = ($page_number - 1) * $limit;

// Perform the search with pagination
$result = searchRecipes($searchInput, $limit, $offset);

// Calculate the total number of pages
$total_pages = ceil($total_results / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./general_style.css" type="text/css">
    <link rel="stylesheet" href="./search_style.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="./PROJECT_files/favicon.ico">

    <script type="module" src="./index.js"></script>

    <title>search</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <main>
        <section class="hero">
            <h1>citatko</h1>
        </section>
        <section class="cards">
            <h1>Search results:</h1>
            <div class="cards_wraps">
                <?php
                // Display search results
                if ($result->num_rows == 0) {
                    echo '<h2>No results found</h2>';
                }

                while ($row = mysqli_fetch_assoc($result)) {
                    $recipe = getByColumn('recipes', 'id', $row['id'])[0];

                    displayRecipeCardColumn($recipe);
                }
                ?>
            </div>
        </section>
        <div class="page-navigation">
            <?php
            // Display pagination buttons
            if ($total_pages > 1) {
                echo '<div class="page-navigation-buttons">';
                if ($page_number > 1) {
                    echo '<a href="doSearch.php?searchInput=' . $searchInput . '&page=' . ($page_number - 1) . '" class="previous-button">&#8810;</a>';
                }
                if ($page_number < $total_pages) {
                    echo '<a href="doSearch.php?searchInput=' . $searchInput . '&page=' . ($page_number + 1) . '" class="next-button">&#8811;</a>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </main>
    <?php include 'footer.html'; ?>
</body>

</html>