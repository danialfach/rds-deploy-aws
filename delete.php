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

// Delete data by ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve image path before deleting the data
    $sql = "SELECT image FROM data WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Delete the image file
        unlink($row['image']);

        // Delete the data from the database
        $sql = "DELETE FROM data WHERE id = '$id'";
        if ($conn->query($sql) === true) {
            header("Location: index.html");
            exit;
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "No data found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

$conn->close();
?>