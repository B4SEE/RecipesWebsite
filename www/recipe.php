<?php

/**
 * This file is responsible for displaying a recipe page.
 * It retrieves the recipe details from the database and renders them on the page.
 * Users can view the recipe, edit the recipe (if authorized), delete the recipe (if the user is the author of the recipe or the admin),
 * and leave comments on the recipe (if authorized).
 */

require_once 'crud.php';

session_status() === PHP_SESSION_ACTIVE ?: session_start();

$nameErr = $descriptionErr = $ingredientsErr = $imageErr = "";
$recipe = $recipeName = $recipeDescription = $recipeIngredients = $recipeId = '';
$recipeImage = "uploads/default/default.png";

$createRecipe = false;
$isEdited = false;
$delete = false;
$editLink = "hidden";
$deleteLink = "hidden";
$commentLink = "hidden";

// Check if the recipe should be deleted
if (isset($_GET['delete']) && ($_GET['delete'] == 'true')) {
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        redirectToLogin();
    } else {
        $recipeAuthorId = getByColumn('recipes', 'id', $_GET['recipeId'])[0]['author_id'];
        if ($_SESSION['user_id'] == $recipeAuthorId) {
            $delete = true;
        } else if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin')) {
            $delete = true;
        }
    }
    if ($delete) {
        deleteDataById('recipes', $_GET['recipeId']);
        redirectToIndex();
    }
}

// Check if a new recipe should be created
if (isset($_GET['create']) && ($_GET['create'] == 'true')) {
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        redirectToLogin();
    }
    addDataToTable("recipes", array(getLastInsertedId() + 1, 'Recipe name', 'uploads/default/default.png', 'description', 'Water', $_SESSION['user_id']));
    $recipeId = getLastInsertedId();
    header("Location: edit.php?recipeId=$recipeId");
    exit();
}

// Check if a specific recipe is requested
if (isset($_GET['recipeId'])) {
    if ($_GET['recipeId'] > getLastInsertedId()) {
        redirectToIndex();
    } else if ($_GET['recipeId'] < 1) {
        redirectToIndex();
    } else {
        $recipeId = $_GET['recipeId'];
    }
} else {
    redirectToIndex();
}

// Check if the recipe should be edited
if (isset($_GET['edit']) && ($_GET['edit'] == 'true') || $isEdited) {
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        redirectToLogin();
    } else {
        if (getByColumn('recipes', 'id', $recipeId)[0]['author_id'] == $_SESSION['user_id'] || $_SESSION['role'] == 'admin') {
            header("Location: edit.php?recipeId=$recipeId");
            exit();
        } else {
            $isEdited = false;
        }
    }
}

// Check if the user is logged in and authorized to edit/delete the recipe
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    $commentLink = "visible";
    $recipeAuthorId = getByColumn('recipes', 'id', $recipeId)[0]['author_id'];
    if ($_SESSION['user_id'] == $recipeAuthorId) {
        $editLink = "visible";
        $deleteLink = "visible";
    } else if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'admin')) { // Update the condition to include 'admin'
        $editLink = "visible";
        $deleteLink = "visible";
    }
}

// Retrieve the recipe details from the database
if ($recipeId !== '') {
    $recipe = getByColumn('recipes', 'id', $recipeId);
    $recipeName = htmlspecialchars($recipe[0]['name']);
    $recipeDescription = htmlspecialchars($recipe[0]['description']);
    $recipeImage = cropImage(htmlspecialchars($recipe[0]['image_path']), 1920, 362);
    $recipeIngredients = htmlspecialchars($recipe[0]['ingredients']);
}

// Redirect to the edit page if the recipe was just edited
if ($isEdited) {
    header("Location: edit.php?recipeId=$recipeId");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./general_style.css" type="text/css">
    <link rel="stylesheet" href="./recipe_style.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="./PROJECT_files/favicon.ico">

    <script type="module" src="./comment.js"></script>

    <title>Recipe</title>
</head>

<body>
    <?php include './header.php'; ?>
    <?php
    if (!$isEdited) { ?>
        <main>
            <?php echo '<section class="hero" style="background-image: url(./' . htmlspecialchars($recipeImage) . ');">'; ?>
            <h1><?php echo $recipeName; ?></h1>
            </section>
            <p class="ingredients">Ingredients:</p>
            <p class="ingredientsList"><?php echo nl2br(str_replace(',', "\n", $recipeIngredients)); ?></p>
            <p class="description"><?php echo nl2br($recipeDescription); ?></p>

            <?php
            echo '<div class="buttons">';
            echo '<a ' . $editLink . ' href="./recipe.php?edit=true&recipeId=' . $recipeId . '" class="edit_button">Edit Recipe</a>';
            echo '<a ' . $deleteLink . ' href="./recipe.php?delete=true&recipeId=' . $recipeId . '" class="delete_button">Delete Recipe</a>';
            echo '</div>';
            echo '<div class="comment_bar"></div>';
            echo '<div class="comment_button_div">';
            echo '<button ' . $commentLink . ' id="comment" class="comment_button">Leave comment</button>';
            echo '</div>';
            echo '<input type="hidden" id="recipeId" value="' . $recipeId . '">';

            displayComments($recipeId);
            ?>

        </main>
    <?php } ?>
    <?php include './footer.html'; ?>
</body>

</html>