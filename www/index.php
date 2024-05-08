<?php

/**
 * This file represents the home page of the website.
 * It includes HTML markup and PHP code to display popular recipes,
 * allow users to add new recipes, and provide user control for admins.
 * 
 * The file starts with session management code to ensure an active session.
 * It then includes CSS and JavaScript files for styling and interactivity.
 * The main content of the page includes a hero section and a section for displaying popular recipes.
 * The "add recipe" button is displayed if the user is logged in, otherwise it redirects to the login page.
 * The "user control" button is displayed for admins only.
 * The file also includes header and footer files for consistent layout.
 */

session_status() === PHP_SESSION_ACTIVE ?: session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./general_style.css" type="text/css">
    <link rel="stylesheet" href="./index_style.css" type="text/css">

    <link rel="icon" type="image/x-icon" href="./PROJECT_files/favicon.ico">

    <script type="module" src="./index.js"></script>

    <title>home</title>
</head>

<body>
    <?php include './header.php'; ?>
    <main>
        <section class="hero">
            <h1>citatko</h1>
        </section>
        <section class="cards">
            <h1>Popular recipes:</h1>
            <div class="cards_wraps">
                <?php
                require_once "crud.php";

                $result = getNRecipeWithMaxComments(3);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $recipe = getByColumn('recipes', 'id', $row['recipe_id'])[0];
                        displayRecipeCardRow($recipe);
                    }
                } else {
                    echo '<h2>No recipes found</h2>';
                }
                ?>
            </div>
        </section>
        <div class="add_recipe_button_div">
            <a class="add_recipe_button" <?php
                                            if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
                                                echo 'href="./recipe.php?create=true"';
                                            } else {
                                                echo 'href="./login.php"';
                                            }
                                            ?>>+</a>
        </div>
        <div class="user_control_button_div">
            <?php
            if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true && isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
                echo '<a class="user_control_button" href="./admin_page.php">User control</a>';
            } ?>
        </div>
    </main>
    <?php include './footer.html'; ?>
</body>

</html>