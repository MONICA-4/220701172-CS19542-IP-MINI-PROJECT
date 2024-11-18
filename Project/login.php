<?php
session_start();
include 'database.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to check user
    $sql = "SELECT id, username, password FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password); // Binding username and password
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Set session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $username;

        // Debug: Check if session variables are being set
        echo "Session user_id: " . $_SESSION['user_id'] . "<br>";
        echo "Session username: " . $_SESSION['username'] . "<br>";

        // Redirect to home.html where bookmarks will be shown based on user_id
        header("Location: home.html");
        exit(); // Ensure the script stops after redirection
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close();
}
?>
