<?php
$database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/database/Huel.db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) || isset($_POST['surname']) || isset($_POST['age'])) {
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $surname = isset($_POST['surname']) ? $_POST['surname'] : null;
        $age = isset($_POST['age']) ? $_POST['age'] : null;

        // Prepare the INSERT statement
        $statement = $database->prepare("INSERT INTO guys (name, surname, age) VALUES (:name, :surname, :age)");
        $statement->bindValue(':name', $name, SQLITE3_TEXT);
        $statement->bindValue(':surname', $surname, SQLITE3_TEXT);
        $statement->bindValue(':age', $age, SQLITE3_INTEGER);

        // Execute the INSERT statement
        $result = $statement->execute();

        if ($result) {
            echo "Data inserted successfully!";
        } else {
            echo "Error inserting data.";
        }
    }
}

$database->close();
?>
