<?php
$database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/database/Huel.db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['table_name'])) {
        $tableName = $_POST['table_name'];

        // Build the DROP TABLE query
        $query = "DROP TABLE IF EXISTS $tableName";

        $result = $database->exec($query);

        if ($result !== false) {
            // Set the HTTP status code to 200 (OK)
            http_response_code(200);
            echo "Table dropped successfully!";
        } else {
            // Set the HTTP status code to 500 (Internal Server Error)
            http_response_code(500);
            echo "Error dropping table.";
        }
    } else {
        // Set the HTTP status code to 400 (Bad Request)
        http_response_code(400);
        echo "Invalid request.";
    }
}

$database->close();
?>
