<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Start Page</title>
</head>
<body>
<?php
$database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/database/Huel.db');

if (!$database) {
    $error = "Failed to connect to the database.";
}

$tablesQuery = "SELECT name FROM sqlite_master WHERE type='table'";
$tablesResult = $database->query($tablesQuery);

if ($tablesResult !== false) {
    $tableNames = array();
    while ($tableRow = $tablesResult->fetchArray()) {
        $tableName = $tableRow['name'];
        if ($tableName !== 'sqlite_sequence') {
            $tableNames[] = $tableName;
        }
    }
} else {
    $error = "Error retrieving tables.";
}

$selectedTable = isset($_POST['table_name']) ? $_POST['table_name'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $selectedTable) {
    // Store the selected table in session for future use
    session_start();
    $_SESSION['selected_table'] = $selectedTable;
}
?>

<h1>Welcome to the Database App</h1>

<ul>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>

    <h3>Work with data</h3>
    <li><a href="dataWork/insert/insertFront.php">Insert Data</a></li>
    <li><a href="dataWork/select/select.php">Select Data</a></li>
    <li><a href="dataWork/update/updateFront.php">Update Data</a></li>
    <li><a href="dataWork/delete/delete.html">Delete Data</a></li>

    <h3>Work with tables</h3>
    <li><a href="tableWork/createTable/create.html">Create Table</a></li>
    <li><a href="tableWork/updateTable/update.html">Update Table</a></li>
    <li><a href="tableWork/updateTable/add_column.html">Add Column</a></li>
    <li><a href="tableWork/updateTable/delete_column.html">Delete Column</a></li>
    <li><a href="tableWork/dropTable/drop.html">Drop Table</a></li>

    <h3>Select a table:</h3>
    <form method="POST" action="">
        <select id="table" name="table_name">
            <?php
            foreach ($tableNames as $tableName) {
                $selected = $tableName === $selectedTable ? 'selected' : '';
                echo "<option value='$tableName' $selected>$tableName</option>";
            }
            ?>
        </select>
        <br>
        <button type="submit">Submit</button>
    </form>
</ul>
</body>
</html>
