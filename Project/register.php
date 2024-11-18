<?php
include 'database.php'; // Assumes a database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to insert new user
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);
    
    if ($stmt->execute()) {
        // Use header to redirect
        header("Location: login.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
