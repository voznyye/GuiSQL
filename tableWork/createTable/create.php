<?php
$database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/database/Huel.db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['table_name']) && isset($_POST['column_names']) && isset($_POST['column_types'])) {
        $tableName = $_POST['table_name'];
        $columnNames = $_POST['column_names'];
        $columnTypes = $_POST['column_types'];

        // Ensure that the number of column names matches the number of column types
        if (count($columnNames) === count($columnTypes)) {
            // Build the CREATE TABLE query dynamically
            $query = "CREATE TABLE IF NOT EXISTS $tableName (";
            for ($i = 0; $i < count($columnNames); $i++) {
                $columnName = $columnNames[$i];
                $columnType = $columnTypes[$i];

                // Append the column definition to the query
                $query .= "$columnName $columnType,";

                // Remove any leading/trailing spaces or commas from the column name
                $columnNames[$i] = trim($columnName, " ,");
            }

            // Remove the trailing comma from the query
            $query = rtrim($query, ',');

            $query .= ")";

            $result = $database->exec($query);

            if ($result !== false) {
                echo "Table created successfully!";
                header("Location: success.html");
            } else {
                echo "Error creating table.";
                header("Location: error.html");

            }
        } else {
            echo "Mismatched number of column names and types.";
            header("Location: error.html");
        }
    }
}

$database->close();
?>
