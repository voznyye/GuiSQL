<?php
session_start();

if (isset($_SESSION['selected_table'])) {
    $selectedTable = $_SESSION['selected_table'];

    $database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/PutYourDatabaseHere/Huel.db');

    $response = array();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['oldColumnName']) && isset($_POST['newColumnName'])) {
            $oldColumnName = $_POST['oldColumnName'];
            $newColumnName = $_POST['newColumnName'];

            // Prepare the ALTER TABLE statement to rename the column
            $alterTableQuery = "ALTER TABLE $selectedTable RENAME COLUMN $oldColumnName TO $newColumnName";

            // Execute the ALTER TABLE statement
            $result = $database->exec($alterTableQuery);

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Column name changed successfully!';

                // Set the HTTP status code to 200 (OK)
                http_response_code(200);
            } else {
                $response['success'] = false;
                $response['message'] = 'Error changing column name.';

                // Set the HTTP status code to 500 (Internal Server Error)
                http_response_code(500);
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Column names not provided.';

            // Set the HTTP status code to 400 (Bad Request)
            http_response_code(400);
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid request.';

        // Set the HTTP status code to 400 (Bad Request)
        http_response_code(400);
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
