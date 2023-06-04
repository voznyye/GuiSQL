<?php
$database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/database/Huel.db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['table_name'])) {
        $tableName = $_POST['table_name'];

        // Build the DROP TABLE query
        $query = "DROP TABLE IF EXISTS $tableName";

        $result = $database->exec($query);

        if ($result !== false) {
            echo "Table dropped successfully!";
        } else {
            echo "Error dropping table.";
        }
    }
}

$database->close();
?>
