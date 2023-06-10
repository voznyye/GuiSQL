<?php
$database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/database/Huel.db');

// Retrieve the selected table from the session
session_start();
if (isset($_SESSION['selected_table'])) {
    $selectedTable = $_SESSION['selected_table'];

    // Fetch the column names for the selected table from the database
    $columnsQuery = "PRAGMA table_info('$selectedTable')";
    $columnsResult = $database->query($columnsQuery);

    if ($columnsResult !== false) {
        // Store the column names in an array
        $columnNames = array();
        while ($columnRow = $columnsResult->fetchArray()) {
            $columnName = $columnRow['name'];
            $columnNames[] = $columnName;
        }

        // Check if any columns exist in the table
        if (count($columnNames) > 0) {
            foreach ($columnNames as $column) {
                echo "<label for='$column'>$column:</label>";
                echo "<input type='text' id='$column' name='$column'><br>";
            }
        } else {
            echo 'Table has no columns.';
        }
    } else {
        echo 'Error retrieving columns for table: ' . $selectedTable;
    }
} else {
    echo 'Table not selected.';
}

$database->close();
?>
