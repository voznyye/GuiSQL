<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file was uploaded successfully
    if (isset($_FILES['database_file']) && $_FILES['database_file']['error'] === UPLOAD_ERR_OK) {
        // Specify the directory where you want to store the uploaded file
        $uploadDir = '';

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
        }
    } else {
        // Error uploading the file
        // Handle the error scenario
        $error = 'Error uploading the file.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Database File</title>
</head>
<body>
<?php if (isset($error)) { ?>
    <p>Error: <?php echo $error; ?></p>
<?php } ?>
<form method="POST" enctype="multipart/form-data">
    <label for="database_file">Choose a database file:</label>
    <input type="file" id="database_file" name="database_file" required>
    <button type="submit">Upload</button>
</form>
</body>
</html>
