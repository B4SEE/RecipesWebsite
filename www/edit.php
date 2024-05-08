<?php

/**
 * This file is responsible for handling the editing of a recipe. It checks if the user is logged in,
 * retrieves the recipe details from the session, and updates the recipe information in the database.
 * It also handles file uploads for the recipe image.
 */

require_once "crud.php";
session_status() === PHP_SESSION_ACTIVE ?: session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    redirectToLogin();
}

if (isset($_SESSION['image_path'])) {
    $image_path = $_SESSION['image_path'];
} else {
    $image_path = "uploads/default/default.png";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars_decode(test_input($_POST["name"]));
    $description = htmlspecialchars_decode(test_input($_POST["description"]));
    $ingredientsList = test_input($_POST['ingredientsList']);

    $image = $_FILES['image']['name'];
    $image = $image . $_SESSION['recipeId'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $extension = pathinfo($image, PATHINFO_EXTENSION);

    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        $user = getByColumn('users', 'id', $_SESSION['recipe'][0]['author_id']);
        $username = $user[0]['username'];
        $user_id = $user[0]['id'];
    } else {
        $username = $_SESSION['username'];
        $user_id = $_SESSION['user_id'];
    }

    $image_path = "uploads/" . $username . "/" . preg_replace("/[^a-zA-Z0-9\-]/", "", $image) . "." . $extension;
    if ($image_path == "") {
        $image_path = "uploads/default/default.png";
    }
    if (!empty($image_tmp)) {
        copy($image_tmp, $image_path);
    }
    uploadDataById("recipes", array($name, $image_path, $description, $ingredientsList, $user_id), $_SESSION['recipeId']);

    header("Location: recipe.php?recipeId={$_SESSION['recipeId']}");

    unset($_SESSION['recipeId']);
    unset($_SESSION['recipe']);
    unset($_SESSION['recipeName']);
    unset($_SESSION['recipeDescription']);
    unset($_SESSION['recipeIngredients']);
    unset($_SESSION['image_path']);

    exit();
} else {
    if (isset($_GET['recipeId'])) {
        $_SESSION['recipeId'] = $_GET['recipeId'];
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != getByColumn('recipes', 'id', $_SESSION['recipeId'])[0]['author_id']) {
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            } else {
                header("Location: recipe.php?recipeId={$_SESSION['recipeId']}");
                unset($_SESSION['recipeId']);
                exit();
            }
        }
        $_SESSION['recipe'] = getByColumn('recipes', 'id', $_SESSION['recipeId']);
        $_SESSION['recipeName'] = htmlspecialchars_decode(test_input($_SESSION['recipe'][0]['name']));
        $_SESSION['recipeDescription'] = htmlspecialchars_decode(test_input($_SESSION['recipe'][0]['description']));
        $_SESSION['recipeIngredients'] = test_input($_SESSION['recipe'][0]['ingredients']);
        $_SESSION['image_path'] = test_input($_SESSION['recipe'][0]['image_path']);
        $name = $_SESSION['recipeName'];
        $description = $_SESSION['recipeDescription'];
        $ingredientsList = $_SESSION['recipeIngredients'];
    } else {
        redirectToIndex();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./general_style.css" type="text/css">
    <link rel="stylesheet" href="./recipe_style.css" type="text/css">
    <link rel="stylesheet" href="./edit_style.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="./PROJECT_files/favicon.ico">

    <script type="module" src="./edit.js"></script>

    <noscript>
        <meta http-equiv="Refresh" content="0; url=./index.php">
    </noscript>

    <title>Edit</title>
</head>
<main>
    <?php echo '<section class="hero" style="background-image: url(./' . htmlspecialchars($image_path) . ');">'; ?>
    <h1>Edit <?php echo htmlspecialchars($_SESSION['recipeName']); ?></h1>
    </section>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label class="input_label" for="name">Recipe Name</label>
        <input class="name" type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="<?php echo htmlspecialchars($_SESSION['recipeName']); ?>">
        <label class="input_label" for="description">Recipe Description</label>
        <textarea class="description" id="description" name="description" placeholder="<?php echo htmlspecialchars($_SESSION['recipeDescription']); ?>"><?php echo htmlspecialchars($description); ?></textarea>
        <label class="input_label" for="ingredients">Recipe Ingredients</label>
        <select class="ingredients" id="ingredients" name="ingredients">
            <?php
            $ingredients = getAllFromColumn('ingredients', 'name');
            for ($i = 0; $i < count($ingredients); $i++) {
                echo '<option class="ingredient" value="' . htmlspecialchars($ingredients[$i]['name']) . '">' . htmlspecialchars($ingredients[$i]['name']) . '</option>';
            }
            ?>
        </select>
        <input type="hidden" id="ingredientsList" name="ingredientsList" value="<?php echo $ingredientsList; ?>">
        <button class="add_ingredient_button" id="add_ingredient">
            +
        </button>
        <button class="undo_button" id="undo">
            Undo
        </button>
        <p class="text">
            The selected ingredients will be shown here:
        </p>
        <br>
        <p class="text" id="resultShowHere">
            "Please select ingredient."
        </p>
        <br>
        <div class="file_input_button_div">
            <label class="file_input_button" for="image">Select image</label>
        </div>
        <input type="file" id="image" name="image" accept="image/*" hidden>
        <input class="submit" type="submit" value="Save">
        <?php
        echo '<div class="cancel_div">';
        echo '<a class="cancel" href="./recipe.php?recipeId=' . htmlspecialchars($_SESSION['recipeId']) . '"> Cancel </a>'; ?>
        </div>
    </form>
</main>