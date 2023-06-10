<?php
$database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/database/Huel.db');

$response = array();

// Retrieve the selected table from the session
session_start();
if (isset($_SESSION['selected_table'])) {
    $selectedTable = $_SESSION['selected_table'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            // Prepare the DELETE statement with the selected table
            $statement = $database->prepare("DELETE FROM $selectedTable WHERE id = :id");
            $statement->bindValue(':id', $id, SQLITE3_INTEGER);

            // Execute the DELETE statement
            $result = $statement->execute();

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Data deleted successfully!';

                // Set the HTTP status code to 200 (OK)
                http_response_code(200);
            } else {
                $response['success'] = false;
                $response['message'] = 'Error deleting data.';

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
        $response['message'] = 'Invalid request.';

        // Set the HTTP status code to 400 (Bad Request)
        http_response_code(400);
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
