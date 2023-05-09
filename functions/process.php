<?php
// process.php

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve the selected columns from the form
    $selectedColumns = $_POST['columns'];

    // Process the selected columns
    foreach ($selectedColumns as $column) {
        // Perform operations with the selected column, such as querying the database
        // Example: SELECT $column FROM your_table;
        // You can connect to the SQLite database using PDO and execute queries
        // Refer to the previous instructions on connecting to SQLite and querying the database
        // Display or store the results as needed
    }

    // Redirect or display a success message
    echo "Columns processed successfully!";
}
?>
