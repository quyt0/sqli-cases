<?php
$conn = new mysqli("localhost", "root", "*zdswir9AO3UyA@E", "rce_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$book_id_raw = $_GET['book_id'] ?? '';
$book_id = str_rot13($book_id_raw);

$sql = "SELECT * FROM books WHERE id = '$book_id'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
        echo "<p><strong>Author:</strong> " . htmlspecialchars($row['author']) . "</p>";
        echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
        echo "<p><strong>Published:</strong> " . htmlspecialchars($row['year_published']) . "</p>";
    }
} else {
    echo "No book found.";
}
?>