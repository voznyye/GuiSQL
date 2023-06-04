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

            // Redirect to a success page or display a success message
            header("Location: success.html");
            exit();
        } else {
            // Error moving the uploaded file
            // Handle the error scenario
            $error = 'Error moving the uploaded file.';
            header("Location: error.html");
        }
    } else {
        // Error uploading the file
        // Handle the error scenario
        $error = 'Error uploading the file.';
        header("Location: error.html");
    }
}
?>
