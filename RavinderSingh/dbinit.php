<?php
define("INITIALIZING_DATABASE", 1);
require_once('db_conn.php');

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db->initializeDatabase();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Initialize Database</title>
</head>
<body>
    <form method="POST">
        <input type="submit" value="Initialize Database">
    </form>
</body>
</html>
