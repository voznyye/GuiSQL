<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new SQLite3('Huel.db');

    if (isset($_POST['number'])) {
        $number = $_POST['number'];

        $query = 'SELECT * FROM guys WHERE id = :id';
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $number, SQLITE3_INTEGER);
        $result = $statement->execute();

        $data = array();

        while ($row = $result->fetchArray()) {
            $name = $row['name'];
            $surname = $row['surname'];
            $age = $row['age'];

            // Add the retrieved data to the array
            $data[] = array(
                'name' => $name,
                'surname' => $surname,
                'age' => $age
            );
        }

        // Close the database connection
        $database->close();

        // Convert the data array to JSON format
        $json_data = json_encode($data);

        // Encode the JSON data for URL
        $encoded_data = urlencode($json_data);

        // Redirect to result.html with the encoded data as URL parameter
        header("Location: result.html?data=$encoded_data");
        exit();
    }
}
?>

<form method="POST">
    <label for="number">Enter a guy ID:</label>
    <input type="number" id="number" name="number" required>
    <button type="submit">Submit</button>
</form>

</body>
</html>
