<?php
$database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/database/Huel.db');

$response = array();

// Retrieve the selected table from the session
session_start();
if (isset($_SESSION['selected_table'])) {
    $selectedTable = $_SESSION['selected_table'];

    // Fetch the column names for the selected table from the database
    $columnsQuery = "PRAGMA table_info('$selectedTable')";
    $columnsResult = $database->query($columnsQuery);

    if ($columnsResult !== false) {
        // Store the column names in an array
        $columnNames = array();
        while ($columnRow = $columnsResult->fetchArray()) {
            $columnName = $columnRow['name'];
            $columnNames[] = $columnName;
        }

        // Check if any columns exist in the table
        if (count($columnNames) > 0) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $values = array();

                // Retrieve the input values for each column
                foreach ($columnNames as $column) {
                    if (isset($_POST[$column])) {
                        $values[$column] = $_POST[$column];
                    } else {
                        $values[$column] = null;
                    }
                }

                // Prepare the INSERT statement with the selected table and columns
                $columnsString = implode(', ', $columnNames);
                $placeholders = implode(', ', array_fill(0, count($columnNames), '?'));

                $statement = $database->prepare("INSERT INTO $selectedTable ($columnsString) VALUES ($placeholders)");

                // Bind the values to the placeholders in the statement
                $index = 1;
                foreach ($columnNames as $column) {
                    $statement->bindValue($index++, $values[$column], SQLITE3_TEXT);
                }

                // Execute the INSERT statement
                $result = $statement->execute();

                if ($result) {
                    $response['success'] = true;
                    $response['message'] = 'Data inserted successfully!';

                    // Set the HTTP status code to 200 (OK)
                    http_response_code(200);
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Error inserting data.';

                    // Set the HTTP status code to 500 (Internal Server Error)
                    http_response_code(500);
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'Invalid request.';

                // Set the HTTP status code to 400 (Bad Request)
                http_response_code(400);
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Table has no columns.';

            // Set the HTTP status code to 400 (Bad Request)
            http_response_code(400);
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Error retrieving columns for table: ' . $selectedTable;

        // Set the HTTP status code to 500 (Internal Server Error)
        http_response_code(500);
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Table not selected.';

    // Set the HTTP status code to 400 (Bad Request)
    http_response_code(400);
}

$database->close();

// Set the appropriate headers for JSON
header('Content-Type: application/json');

// Send the JSON response
echo json_encode($response);
?>
