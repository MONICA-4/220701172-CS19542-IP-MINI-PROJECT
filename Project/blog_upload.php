<?php
include 'database.php'; // Ensure database connection is included correctly

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    // Directory where files will be saved
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($image["name"]);

    // Check if uploads directory exists, if not create it
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $uploadOk = 1;

    // Validate the image
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $check = getimagesize($image["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo json_encode(['success' => false, 'error' => 'File is not an image.']);
        exit();
    }

    // Check allowed file types
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo json_encode(['success' => false, 'error' => 'Only JPG, JPEG, PNG & GIF files are allowed.']);
        exit();
    }

    // If the file is valid, upload and insert blog details in the database
    if ($uploadOk && move_uploaded_file($image["tmp_name"], $targetFile)) {
        $sql = "INSERT INTO blogs (title, description, image_path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $title, $description, $targetFile);

            if ($stmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'id' => $stmt->insert_id,
                    'title' => htmlspecialchars($title),
                    'description' => htmlspecialchars($description),
                    'image_path' => htmlspecialchars($targetFile)
                ]);
                exit();
            } else {
                echo json_encode(['success' => false, 'error' => 'Database Insertion Error: ' . $stmt->error]);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Database Statement Preparation Error: ' . $conn->error]);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'There was an issue uploading your file.']);
        exit();
    }
}
?>


