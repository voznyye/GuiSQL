<?php
$database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/database/Huel.db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Prepare the DELETE statement
        $statement = $database->prepare("DELETE FROM guys WHERE id = :id");
        $statement->bindValue(':id', $id, SQLITE3_INTEGER);

        // Execute the DELETE statement
        $result = $statement->execute();

        if ($result) {
            echo "Data deleted successfully!";
        } else {
            echo "Error deleting data.";
        }
    }
}

$database->close();
?>
