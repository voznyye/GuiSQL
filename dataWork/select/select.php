<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Data</title>
</head>
<body>
<h1>Select Data</h1>

<?php
$database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/database/Huel.db');

$response = array();

// Retrieve the selected table from the session
session_start();
if (isset($_SESSION['selected_table'])) {
    $selectedTable = $_SESSION['selected_table'];

    // Fetch all data from the selected table
    $dataQuery = "SELECT * FROM $selectedTable";
    $dataResult = $database->query($dataQuery);

    if ($dataResult !== false) {
        // Check if any data exists in the table
        if ($dataResult->numColumns() > 0) {
            // Create a table to display the data
            echo '<table>';
            echo '<tr>';

            // Fetch the column names and display them as table headers
            for ($i = 0; $i < $dataResult->numColumns(); $i++) {
                $columnName = $dataResult->columnName($i);
                echo "<th>$columnName</th>";
            }

            echo '</tr>';

            // Fetch each row of data and display it as table rows
            while ($row = $dataResult->fetchArray(SQLITE3_ASSOC)) {
                echo '<tr>';
                foreach ($row as $columnValue) {
                    echo "<td>$columnValue</td>";
                }
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "Table has no data.";
        }
    } else {
        echo "Error retrieving data from table: $selectedTable";
    }
} else {
    echo "Table not selected.";
}

$database->close();
?>
</body>
</html>
