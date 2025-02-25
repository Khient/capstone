<?php
require '/phpqrcode/qrlib.php'; // Include the QR code library

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $treeName = $_POST['treeName'];
    $scientificName = $_POST['scientificName'];
    $description = $_POST['description'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $treeImage = $_FILES['treeImage'];
     // Handle image upload
     if (isset($treeImage) && $treeImage['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Make sure this directory exists
        $uploadFile = $uploadDir . basename($treeImage['name']);
        move_uploaded_file($treeImage['tmp_name'], $uploadFile);
    }


    // Generate QR Code
    $qrCodeFile = 'qr_codes/qrcode.png';
    $qrData = "Tree Name: $treeName\nScientific Name: $scientificName\nLatitude: $latitude\nLongitude: $longitude";
    QRcode::png($qrData, $qrCodeFile);

    // Return success response with QR code URL
    echo json_encode(['success' => true, 'qrCodeUrl' => $qrCodeFile]);
}
?>