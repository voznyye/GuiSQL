<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new SQLite3('Huel.db');

    if (isset($_POST['number'])) {
        $number = $_POST['number'];
        $columns = isset($_POST['columns']) ? $_POST['columns'] : '*';

        $query = "SELECT $columns FROM guys";
        if ($number) {
            $query .= " WHERE id = :id";
        }

        $statement = $database->prepare($query);

        if ($number) {
            $statement->bindValue(':id', $number, SQLITE3_INTEGER);
        }

        $result = $statement->execute();

        $data = array();

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $data[] = $row;
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form method="POST">
    <label for="number">Enter a guy ID or leave empty:</label>
    <input type="number" id="number" name="number">
    <br>
    <label for="columns">Select columns:</label>
    <select id="columns" name="columns">
        <option value="*">All</option>
        <option value="name">Name</option>
        <option value="surname">Surname</option>
        <option value="age">Age</option>
    </select>
    <br>
    <button type="submit">Submit</button>
</form>
</body>
</html>
