<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file was uploaded successfully
    if (isset($_FILES['database_file']) && $_FILES['database_file']['error'] === UPLOAD_ERR_OK) {
        // Specify the directory where you want to store the uploaded file
        $uploadDir = 'database/';

        // Generate a unique filename for the uploaded file
        $filename = uniqid('database_', true) . '.db';

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($_FILES['database_file']['tmp_name'], $uploadDir . $filename)) {
            // File uploaded successfully
            // Perform further processing with the uploaded file

            // Prepare the response data
            $response = array(
                'success' => true,
                'filename' => $filename
            );

            // Set the appropriate headers for JSON and HTTP status code
            http_response_code(200);
            header('Content-Type: application/json');

            // Send the JSON response
            echo json_encode($response);
        } else {
            // Error moving the uploaded file
            // Prepare the error response
            $response = array(
                'success' => false,
                'error' => 'Error moving the uploaded file.'
            );

            // Set the appropriate headers for JSON and HTTP status code
            http_response_code(500);
            header('Content-Type: application/json');

            // Send the JSON response
            echo json_encode($response);
        }
    } else {
        // Error uploading the file
        // Prepare the error response
        $response = array(
            'success' => false,
            'error' => 'Error uploading the file.'
        );

        // Set the appropriate headers for JSON and HTTP status code
        http_response_code(400);
        header('Content-Type: application/json');

        // Send the JSON response
        echo json_encode($response);
    }    exit();
}
?>
