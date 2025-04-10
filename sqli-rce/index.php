<?php
// Kết nối MySQL
$conn = new mysqli("localhost", "root", "*zdswir9AO3UyA@E", "rce_db");
if ($conn->connect_error)
    die("Kết nối thất bại: " . $conn->connect_error);

$result = "";

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['year'])) {
    $year = $_GET['year'];
    $sql = "SELECT * FROM books WHERE year_published = $year";
    $query = $conn->query($sql);

    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $result .= "<div style='margin-bottom:10px;'>
                <strong>📖 " . $row["title"] . "</strong><br>
                Tác giả: " . $row["author"] . "<br>
                Mô tả: " . $row["description"] . "<br>
                Năm xuất bản: " . $row["year_published"] . "
            </div>";
        }
    } else {
        $result = "❌ Không tìm thấy sách nào phù hợp.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Tra cứu sách</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: #2f3640;
            margin-bottom: 20px;
        }

        form {
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 10px;
        }

        input[type="text"] {
            padding: 10px;
            border: 1px solid #dcdde1;
            border-radius: 5px;
            width: 250px;
            font-size: 16px;
        }

        button {
            padding: 10px 20px;
            background-color: #00a8ff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #ketqua {
            margin-top: 30px;
            width: 600px;
        }

        .book {
            background: #fff;
            padding: 15px 20px;
            border-left: 5px solid #44bd32;
            margin-bottom: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
        }

        .book h3 {
            margin: 0 0 10px;
            color: #192a56;
        }

        .book p {
            margin: 5px 0;
        }

        .no-result {
            padding: 15px;
            background-color: #f8d7da;
            color: #721c24;
            border-left: 5px solid #e74c3c;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h1>🔍 Tìm kiếm sách theo năm xuất bản</h1>
    <form method="GET">
        <input type="text" name="year" placeholder="Nhập năm xuất bản ..." required>
        <button type="submit">Tìm sách</button>
    </form>

    <div id="ketqua" style="margin-top:20px;">
        <?php echo $result; ?>
    </div>
</body>

</html>