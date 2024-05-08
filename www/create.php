<?php

/**
 * Adds data to the specified table in the database.
 *
 * @param string $table_name The name of the table to add data to.
 * @param array $data An array containing the data to be added to the table.
 * @return void
 */
function addDataToTable($table_name, $data)
{
    require_once "config.php";
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($table_name == "users") {

        $sql = "INSERT INTO users (id, username, email, password_hash, image_path, role)
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", ...$data);
        $stmt->execute();
    }
    if ($table_name == "recipes") {
        $sql = "INSERT INTO recipes (id, name, image_path, description, ingredients, author_id)
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", ...$data);
        $stmt->execute();
    }
    if ($table_name == "ingredients") {
        $sql = "INSERT INTO ingredients (id, name, measurement_units)
        VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", ...$data);
        $stmt->execute();
    }

    if ($table_name == "comments") {
        $sql = "INSERT INTO comments (id, recipe_id, content, author_id, time, date)
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", ...$data);
        $stmt->execute();
    }

    $conn->close();
}
