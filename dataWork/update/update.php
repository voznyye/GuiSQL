<?php
session_start();

if (isset($_SESSION['selected_table'])) {
    $selectedTable = $_SESSION['selected_table'];

    $database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/PutYourDatabaseHere/Huel.db');

    $response = array();

    // Retrieve the record ID from the session
    if (isset($_POST['id'])) {
        $recordID = $_POST['id'];
    } else {
        $response['success'] = false;
        $response['message'] = 'Record ID not provided.';

        // Set the HTTP status code to 400 (Bad Request)
        http_response_code(400);
        echo json_encode($response);
        exit; // Stop further execution
    }

    // Fetch the column names for the selected table from the PutYourDatabaseHere
    $columnsQuery = "PRAGMA table_info('$selectedTable')";
    $columnsResult = $database->query($columnsQuery);

    if ($columnsResult !== false) {
        // Store the column names in an array
        $columnNames = array();
        while ($columnRow = $columnsResult->fetchArray()) {
            $columnName = $columnRow['name'];
            $columnNames[] = $columnName;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $values = array();

            // Retrieve the input values for each column except the first column (id)
            foreach ($columnNames as $index => $column) {
                if ($index === 0) {
                    // Skip the first column (id)
                    continue;
                }

                if (isset($_POST[$column])) {
                    $values[$column] = $_POST[$column];
                } else {
                    $values[$column] = null;
                }
            }

            // Prepare the UPDATE statement with the selected table, columns, and record ID
            $updateString = implode(', ', array_map(function ($column) {
                return $column . ' = :' . $column;
            }, array_slice($columnNames, 1))); // Exclude the first column (id)

            $statement = $database->prepare("UPDATE $selectedTable SET $updateString WHERE id = :recordID");
            $statement->bindValue(':recordID', $recordID, SQLITE3_INTEGER);

            // Bind the values to the placeholders in the statement
            foreach ($values as $column => $value) {
                $statement->bindValue(':' . $column, $value, SQLITE3_TEXT);
            }

            // Execute the UPDATE statement
            $result = $statement->execute();

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Data updated successfully!';

                // Set the HTTP status code to 200 (OK)
                http_response_code(200);
            } else {
                $response['success'] = false;
                $response['message'] = 'Error updating data.';

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
        $response['message'] = 'Error retrieving columns for table: ' . $selectedTable;

        // Set the HTTP status code to 500 (Internal Server Error)
        http_response_code(500);
    }

    $database->close();

    // Set the appropriate headers for JSON
    header('Content-Type: application/json');

    // Send the JSON response
    echo json_encode($response);
} else {
    echo 'Table not selected.';
}
?>
