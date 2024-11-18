<?php
include 'db_config.php';

if (isset($_GET['id'])) {
    $imageId = $_GET['id'];

    // Fetch file path to delete the image file
    $query = "SELECT file_path FROM images WHERE id='$imageId'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    
    // Delete the image file from the server
    if ($row) {
        unlink($row['file_path']); // Remove the image file
    }

    // Delete the image record from the database
    $query = "DELETE FROM images WHERE id='$imageId'";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>