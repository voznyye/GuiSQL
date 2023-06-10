<?php
$database = new SQLite3('path/to/database.db');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['table'])) {
    // Get the table name from the request
    $tableName = $_GET['table'];

    // Get the columns for the specified table
    $columnsQuery = "PRAGMA table_info('$tableName')";
    $columnsResult = $database->query($columnsQuery);

    if ($columnsResult !== false) {
        // Store the column names in an array
        $columnNames = array();
        while ($columnRow = $columnsResult->fetchArray(SQLITE3_ASSOC)) {
            $columnName = $columnRow['name'];
            $columnNames[] = $columnName;
        }

        // Query the table to get the rows
        $query = "SELECT * FROM $tableName";
        $result = $database->query($query);

        if ($result !== false) {
            // Store the rows in an array
            $rows = array();
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $rows[] = $row;
            }

            // Close the database connection
            $database->close();

            // Pass the column names and rows as data
            $data = array(
                'columns' => $columnNames,
                'rows' => $rows
            );

            // Set the response headers
            header('Content-Type: application/json');
            http_response_code(200);

            // Convert the data to JSON format
            $json_data = json_encode($data);

            // Send the JSON response
            echo $json_data;
            exit();
        } else {
            // Error retrieving rows from the table
            http_response_code(500);
            echo json_encode(array('error' => 'Error retrieving rows from table.'));
        }
    } else {
        // Error retrieving columns for the table
        http_response_code(500);
        echo json_encode(array('error' => 'Error retrieving columns for table.'));
    }
} else {
    // Invalid request
    http_response_code(400);
    echo json_encode(array('error' => 'Invalid request.'));
}
