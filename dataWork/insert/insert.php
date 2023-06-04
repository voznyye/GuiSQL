<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new SQLite3('database/*.db');

    if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['age'])) {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $age = $_POST['age'];

        $query = 'INSERT INTO guys (name, surname, age) VALUES (:name, :surname, :age)';
        $statement = $database->prepare($query);
        $statement->bindValue(':name', $name, SQLITE3_TEXT);
        $statement->bindValue(':surname', $surname, SQLITE3_TEXT);
        $statement->bindValue(':age', $age, SQLITE3_INTEGER);
        $result = $statement->execute();

        // Close the database connection
        $database->close();

        // Redirect to success.html
        header("Location: success.html");
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
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="surname">Surname:</label>
    <input type="text" id="surname" name="surname" required>
    <br>
    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required>
    <br>
    <button type="submit">Submit</button>
</form>
</body>
</html>
