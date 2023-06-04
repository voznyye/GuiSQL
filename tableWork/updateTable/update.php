<?php
$database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/database/Huel.db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['table_name']) && isset($_POST['id']) && isset($_POST['column_names']) && isset($_POST['column_values'])) {
        $tableName = $_POST['table_name'];
        $id = $_POST['id'];
        $columnNames = $_POST['column_names'];
        $columnValues = $_POST['column_values'];

        // Ensure that the number of column names matches the number of column values
        if (count($columnNames) === count($columnValues)) {
            // Build the UPDATE query dynamically
            $query = "UPDATE $tableName SET ";

            for ($i = 0; $i < count($columnNames); $i++) {
                $columnName = $columnNames[$i];
                $columnValue = $columnValues[$i];

                // Append each column name and value pair to the query
                $query .= "$columnName = '$columnValue', ";
            }

            // Remove the trailing comma and space from the query
            $query = rtrim($query, ', ');

            // Add the WHERE clause for the specific row to update
            $query .= " WHERE id = :id";

            $statement = $database->prepare($query);

            // Bind the ID parameter to the prepared statement
            $statement->bindValue(':id', $id, SQLITE3_INTEGER);

            $result = $statement->execute();

            if ($result !== false) {
                echo "Table updated successfully!";
            } else {
                echo "Error updating table.";
            }
        } else {
            echo "Mismatched number of column names and values.";
        }
    }
}

$database->close();
?>
