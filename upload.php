<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "treeid";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tree_name = isset($_POST['treeName']) ? $_POST['treeName'] : null;
    $scientific_name = isset($_POST['scientificName']) ? $_POST['scientificName'] : null;
    $description = isset($_POST['treeDescription']) ? $_POST['treeDescription'] : null;

    // Check if the form fields are being received
    echo "Tree Name: " . htmlspecialchars($tree_name) . "<br>";
    echo "Scientific Name: " . htmlspecialchars($scientific_name) . "<br>";
    echo "Description: " . htmlspecialchars($description) . "<br>";

    // Check if file is uploaded without errors
    if (isset($_FILES['videoFile']) && $_FILES['videoFile']['error'] == UPLOAD_ERR_OK) {
        $video = addslashes(file_get_contents($_FILES['videoFile']['tmp_name']));
        echo "Video Size: " . strlen($video) . " bytes<br>";

        // Prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO tree_videos (tree_name, scientific_name, description, video) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $tree_name, $scientific_name, $description, $video);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Video uploaded successfully!";
            } else {
                echo "No rows affected. Data not inserted.";
            }
        } else {
            echo "Error executing query: " . $stmt->error . "<br>";
        }

        // Debugging: Log the SQL query
        echo "SQL Query: INSERT INTO tree_videos (tree_name, scientific_name, description, video) VALUES ('$tree_name', '$scientific_name', '$description', [video data])<br>";

        $stmt->close();
    } else {
        echo "File upload error: " . $_FILES['videoFile']['error'] . "<br>";
    }
}

$conn->close();
?>
