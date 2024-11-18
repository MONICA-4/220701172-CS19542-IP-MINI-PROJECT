<?php
include 'database.php'; // Ensure database connection is included correctly

header('Content-Type: application/json');

$sql = "SELECT * FROM blogs ORDER BY created_at DESC";
$result = $conn->query($sql);

$blogs = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blogs[] = [
            'id' => $row['id'],
            'title' => htmlspecialchars($row['title']),
            'description' => htmlspecialchars($row['description']),
            'image_path' => htmlspecialchars($row['image_path'])
        ];
    }
}

echo json_encode($blogs);
?>
