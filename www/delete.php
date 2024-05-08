<?php

/**
 * Deletes data from the specified table by the given ID.
 *
 * @param string $table_name The name of the table.
 * @param int $id The ID of the data to be deleted.
 * @return void
 */
function deleteDataById($table_name, $id)
{
    require_once "config.php";
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($table_name == "users") {
        $sql = "DELETE FROM users WHERE id = $id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    if ($table_name == "recipes") {
        deleteDataByColumn('comments', 'recipe_id', $id);
        $sql = "DELETE FROM recipes WHERE id = $id";
        $image_path = getByColumn('recipes', 'id', $id)[0]['image_path'];
        $image_cropped_path = cropImage($image_path, 1, 1);
        if (file_exists($image_path)) {
            unlink($image_path);
            unlink($image_cropped_path);
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    if ($table_name == "ingredients") {
        $sql = "DELETE FROM ingredients WHERE id = $id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    if ($table_name == "comments") {
        $sql = "DELETE FROM comments WHERE id = $id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    $conn->close();
}

/**
 * Deletes data from a table based on a specific column and its value.
 *
 * @param string $table_name The name of the table to delete data from.
 * @param string $column_name The name of the column to match for deletion.
 * @param mixed $column_value The value to match in the specified column for deletion.
 * @return void
 */
function deleteDataByColumn($table_name, $column_name, $column_value)
{
    require_once "config.php";
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($table_name == "users") {
        $sql = "DELETE FROM users WHERE $column_name = $column_value";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    if ($table_name == "recipes") {
        $sql = "DELETE FROM recipes WHERE $column_name = $column_value";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    if ($table_name == "ingredients") {
        $sql = "DELETE FROM ingredients WHERE $column_name = $column_value";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    if ($table_name == "comments") {
        $sql = "DELETE FROM comments WHERE $column_name = $column_value";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    $conn->close();
}
