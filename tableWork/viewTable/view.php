<?php
$database = new SQLite3('path/to/database.db');

// Get the table name from the request
$tableName = $_GET['table'];

// Get the columns for the specified table
$columnsQuery = "PRAGMA table_info('$tableName')";
$columnsResult = $database->query($columnsQuery);

if ($columnsResult !== false) {
    // Store the column names in an array
    $columnNames = array();
    while ($columnRow = $columnsResult->fetchArray()) {
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

        // Pass the column names and rows to the view.html file
        $data = array(
            'columns' => $columnNames,
            'rows' => $rows
        );

        // Convert the data to JSON format
        $json_data = json_encode($data);

        // Encode the JSON data for URL
        $encoded_data = urlencode($json_data);

        // Redirect to view.html with the encoded data as URL parameter
        header("Location: view.html?data=$encoded_data");
        exit();
    } else {
        echo "Error retrieving rows from table: $tableName";
    }
} else {
    echo "Error retrieving columns for table: $tableName";
}
?>
