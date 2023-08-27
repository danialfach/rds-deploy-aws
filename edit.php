<?php
// Database configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'your_database';

// Create database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data by ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve data from the database
    $sql = "SELECT * FROM data WHERE id = '$id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
    } else {
        echo "No data found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// Update data in the database
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Check if a new image was uploaded
    if ($_FILES['image']['name'] != "") {
        $image = $_FILES['image']['name'];
        $targetDir = 'uploads/';
        $targetFile = $targetDir . basename($image);

        // Move uploaded file to target directory
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

        // Delete the previous image file
        unlink($row['image']);

        // Update data with the new image path
        $sql = "UPDATE data SET name='$name', email='$email', image='$targetFile' WHERE id='$id'";
    } else {
        // Update data without changing the image
        $sql = "UPDATE data SET name='$name', email='$email' WHERE id='$id'";
    }

    if ($conn->query($sql) === true) {
        header("Location: index.html");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Data</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1>Edit Data</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br><br>

        <label for="image">New Image:</label>
        <input type="file" id="image" name="image"><br><br>

        <input type="submit" name="update" value="Update">
    </form>
</body>

</html>