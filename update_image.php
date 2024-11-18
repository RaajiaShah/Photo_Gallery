<?php
include 'db_config.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id']; 
    
    $label = mysqli_real_escape_string($conn, $_POST['label']); 
    $filePath = '';

    // Handle image upload if a file is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['image']['name']);
        $filePath = $uploadDir . uniqid() . '_' . $fileName;
        

        if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
          
            $query = "UPDATE images SET title = ?, file_path = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssi', $label, $filePath, $id);
        } else {
            $response['error'] = 'Failed to move uploaded file.';
            echo json_encode($response);
            exit;
        }
    } else {
       
        $query = "UPDATE images SET title = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('si', $label, $id);
    }

    // Execute the query and check for success
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['id'] = $id;
        $response['new_title'] = $label;
        $response['new_image'] = $filePath ?: ''; 
        
    } else {
        $response['error'] = 'Database update failed: ' . $stmt->error;
    }

    $stmt->close();
}

echo json_encode($response);
?>