<?php
// get_columns.php

// Connect to the SQLite database
$db = new PDO('sqlite:database.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Retrieve column names from a table
$stmt = $db->query('PRAGMA table_info(your_table)');
$columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);

// Generate <option> elements for each column
foreach ($columns as $column) {
    echo '<option value="' . $column . '">' . $column . '</option>';
}
?>
