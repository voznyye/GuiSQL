<?php
try {
    $database = new SQLite3('/home/letoff/PhpstormProjects/GuiSQl/database/Huel.db');
    echo "Database connection successful!";
    $database->close();
} catch (Exception $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>
