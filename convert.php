<?php
require_once 'functions.php';

// Clean old files periodically (1% chance to run)
if (rand(1, 100) === 1) {
    cleanOldFiles();
}

$response = ['success' => false, 'message' => '', 'downloadUrl' => ''];

try {
    // Check if file was uploaded
    if (!isset($_FILES['wordFile']) || $_FILES['wordFile']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('File upload failed. Please try again.');
    }
    
    $file = $_FILES['wordFile'];
    
    // Validate file
    if ($file['size'] > MAX_FILE_SIZE) {
        throw new Exception('File is too large. Maximum size is ' . (MAX_FILE_SIZE / 1024 / 1024) . 'MB.');
    }
    
    $fileType = mime_content_type($file['tmp_name']);
    if (!in_array($fileType, ALLOWED_TYPES)) {
        throw new Exception('Invalid file type. Please upload a Word document (.doc or .docx).');
    }
    
    // Sanitize and prepare filenames
    $originalFilename = basename($file['name']);
    $sanitizedFilename = sanitizeFilename($originalFilename);
    $uploadPath = UPLOAD_DIR . $sanitizedFilename;
    $pdfFilename = pathinfo($sanitizedFilename, PATHINFO_FILENAME) . '.pdf';
    $pdfPath = CONVERTED_DIR . $pdfFilename;
    
    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        throw new Exception('Failed to save uploaded file.');
    }
    
    // Convert to PDF
    if (!convertWordToPDF($uploadPath, $pdfPath)) {
        throw new Exception('Conversion failed. Please try again or contact support.');
    }
    
    // Log conversion to database (if enabled)
    logConversion($originalFilename, $pdfFilename, $file['size']);
    
    // Prepare download URL
    $downloadUrl = 'download.php?file=' . urlencode($pdfFilename);
    $response['downloadUrl'] = $downloadUrl;
    $response['success'] = true;
    $response['message'] = 'Conversion successful!';
    
    // Send email notification if email was provided
    if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $absoluteUrl = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/' . $downloadUrl;
        sendEmailNotification($_POST['email'], $absoluteUrl);
    }
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);