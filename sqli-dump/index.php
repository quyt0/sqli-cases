<?php
$host = 'localhost';
$db = 'dump_db';
$user = 'root';
$pass = '*zdswir9AO3UyA@E';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

$id = $_GET['id'] ?? '';

$sql = "SELECT * FROM users WHERE id = $id";
$stmt = $pdo->query($sql);

if ($stmt) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "<h3>User Info:</h3><pre>" . print_r($row, true) . "</pre>";
    } else {
        echo "No user found.";
    }
} else {
    echo "Invalid query.";
}
?>
