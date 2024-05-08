<?php

/**
 * Updates data in the specified table based on the given ID.
 *
 * @param string $table_name The name of the table to update.
 * @param array $data An array containing the data to update.
 * @param int $id The ID of the record to update.
 * @return void
 */

function uploadDataById($table_name, $data, $id)
{
    require_once "config.php";
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($table_name == "users") {
        $sql = "UPDATE users SET username = ?, email = ?, password_hash = ?, image_path = ?, role = ? WHERE id = $id";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", ...$data);
        $stmt->execute();
    }
    if ($table_name == "recipes") {
        $sql = "UPDATE recipes SET name = ?, image_path = ?, description = ?, ingredients = ?, author_id = ? WHERE id = $id";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", ...$data);
        $stmt->execute();
    }
    if ($table_name == "ingredients") {
        $sql = "UPDATE ingredients SET name = ?, measurement_units = ? WHERE id = $id";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", ...$data);
        $stmt->execute();
    }

    if ($table_name == "comments") {
        $sql = "UPDATE comments SET recipe_id = ?, content = ?, author_id = ?, time = ?, date = ? WHERE id = $id";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", ...$data);
        $stmt->execute();
    }

    $conn->close();
}
