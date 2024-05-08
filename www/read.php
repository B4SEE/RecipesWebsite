<?php

/**
 * Retrieves rows from a database table based on a specific column value.
 *
 * @param string $table_name The name of the table to retrieve data from.
 * @param string $column_name The name of the column to filter the data by.
 * @param mixed $column_value The value to match in the specified column.
 * @return array|null Returns an array of rows matching the specified column value, or null if no rows are found.
 */
function getByColumn($table_name, $column_name, $column_value)
{
    require_once "config.php";
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $sql = "SELECT * FROM $table_name WHERE $column_name = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $column_value);

    $stmt->execute();
    $result = $stmt->get_result();

    $data = $result->fetch_all(MYSQLI_ASSOC);

    $conn->close();

    if (empty($data)) {
        return null;
    }

    return $data;
}

/**
 * Retrieves all rows from a table that have a specific column value.
 *
 * @param string $table_name The name of the table.
 * @param string $column_name The name of the column.
 * @param mixed $column_value The value to search for in the column.
 * @return array|null An array of rows matching the column value, or null if no rows are found.
 */
function getAllWithColumnValue($table_name, $column_name, $column_value)
{
    require_once "config.php";
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $sql = "SELECT * FROM $table_name WHERE $column_name = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $column_value);

    $stmt->execute();
    $result = $stmt->get_result();

    $data = $result->fetch_all(MYSQLI_ASSOC);

    $conn->close();

    if (empty($data)) {
        return null;
    }

    return $data;
}

/**
 * Retrieves all rows from a specified table, ordered by a specified column in descending order.
 *
 * @param string $table_name The name of the table to retrieve data from.
 * @param string $column_name The name of the column to order the data by.
 * @return array|null An array containing all rows from the table, or null if no data is found.
 */
function getAllFromColumn($table_name, $column_name)
{
    require_once "config.php";
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $sql = "SELECT * FROM $table_name ORDER BY $column_name DESC";

    $stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();

    $data = $result->fetch_all(MYSQLI_ASSOC);

    $conn->close();

    if (empty($data)) {
        return null;
    }

    return $data;
}
