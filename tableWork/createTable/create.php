<?php
$database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/PutYourDatabaseHere/Huel.db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['table_name']) && isset($_POST['column_names']) && isset($_POST['column_types'])) {
        $tableName = $_POST['table_name'];
        $columnNames = $_POST['column_names'];
        $columnTypes = $_POST['column_types'];

        // Ensure that the number of column names matches the number of column types
        if (count($columnNames) === count($columnTypes)) {
            // Add the first column with id INTEGER PRIMARY KEY AUTOINCREMENT
            array_unshift($columnNames, 'id');
            array_unshift($columnTypes, 'INTEGER PRIMARY KEY');

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
                // Set the HTTP status code to 200 (OK)
                http_response_code(200);
                echo "Table created successfully!";
            } else {
                // Set the HTTP status code to 500 (Internal Server Error)
                http_response_code(500);
                echo "Error creating table.";
            }
        } else {
            // Set the HTTP status code to 400 (Bad Request)
            http_response_code(400);
            echo "Mismatched number of column names and types.";
        }
    } else {
        // Set the HTTP status code to 400 (Bad Request)
        http_response_code(400);
        echo "Invalid request.";
    }
}

$database->close();
?>
