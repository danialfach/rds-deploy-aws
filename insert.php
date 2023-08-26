<?php
// Database configuration
$dbHost = 'localhost';
$dbUsername = 'your_username';
$dbPassword = 'your_password';
$dbName = 'your_database';

// Create database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data into table
if (isset($_POST['name']) && isset($_POST['email']) && isset($_FILES['image'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $image = $_FILES['image']['name'];
    $targetDir = 'uploads/';
    $targetFile = $targetDir . basename($image);

    // Move uploaded file to target directory
    move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

    // Insert data into database
    $sql = "INSERT INTO data (name, email, image) VALUES ('$name', '$email', '$targetFile')";
    if ($conn->query($sql) === true) {
        header('Location: index.html');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>