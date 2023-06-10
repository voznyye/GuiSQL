<?php
$database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/database/Huel.db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Get the existing data by ID
        $existingData = $database->querySingle("SELECT * FROM guys WHERE id = $id", true);

        if ($existingData) {
            // Update the values based on the submitted form data
            $name = isset($_POST['name']) ? $_POST['name'] : $existingData['name'];
            $surname = isset($_POST['surname']) ? $_POST['surname'] : $existingData['surname'];
            $age = isset($_POST['age']) ? $_POST['age'] : $existingData['age'];

            // Prepare the UPDATE statement
            $statement = $database->prepare("UPDATE guys SET name = :name, surname = :surname, age = :age WHERE id = :id");
            $statement->bindValue(':name', $name, SQLITE3_TEXT);
            $statement->bindValue(':surname', $surname, SQLITE3_TEXT);
            $statement->bindValue(':age', $age, SQLITE3_INTEGER);
            $statement->bindValue(':id', $id, SQLITE3_INTEGER);

            // Execute the UPDATE statement
            $result = $statement->execute();

            if ($result) {
                // Set the HTTP status code to 200 (OK)
                http_response_code(200);
                echo "Data updated successfully!";
            } else {
                // Set the HTTP status code to 500 (Internal Server Error)
                http_response_code(500);
                echo "Error updating data.";
            }
        } else {
            // Set the HTTP status code to 404 (Not Found)
            http_response_code(404);
            echo "Data not found.";
        }
    } else {
        // Set the HTTP status code to 400 (Bad Request)
        http_response_code(400);
        echo "Invalid request.";
    }
}

$database->close();
?>