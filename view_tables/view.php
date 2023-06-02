<?php

// Path to your SQLite database file
$databaseFile = 'Huel.db';

try {
    // Connect to the SQLite database
    $pdo = new PDO('sqlite:' . $databaseFile);

    // Query to retrieve all table names
    $query = "SELECT name FROM sqlite_master WHERE type='table'";

    // Prepare and execute the query
    $statement = $pdo->prepare($query);
    $statement->execute();

    // Fetch all table names
    $tables = $statement->fetchAll(PDO::FETCH_COLUMN);

    // Prepare the response array
    $response = [
        'tables' => $tables,
    ];

    // Convert the response array to JSON
    $jsonResponse = json_encode($response, JSON_PRETTY_PRINT);

    // Set the response headers
    header('Content-Type: application/json');

    // Output the JSON response
    echo $jsonResponse;
} catch (PDOException $e) {
    // Handle any database errors
    $errorResponse = [
        'error' => $e->getMessage(),
    ];

    // Convert the error response to JSON
    $jsonError = json_encode($errorResponse, JSON_PRETTY_PRINT);

    // Set the response headers
    header('Content-Type: application/json');

    // Output the JSON error response
    echo $jsonError;
}
?>