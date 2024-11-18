<?php
include 'database.php'; // Ensure this file establishes a proper database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blog_id = $_POST['blog_id'];

    // Prepare and execute delete statement
    $sql = "DELETE FROM blogs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blog_id);

    if ($stmt->execute()) {
        header("Location: blog.php"); // Redirect back to blog page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
