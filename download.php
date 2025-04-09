<?php
require_once 'functions.php';

if (!isset($_GET['file'])) {
    header('HTTP/1.0 400 Bad Request');
    die('File parameter is missing.');
}

$filename = basename($_GET['file']);
$filepath = CONVERTED_DIR . $filename;

if (!file_exists($filepath)) {
    header('HTTP/1.0 404 Not Found');
    die('File not found. It may have expired.');
}

// Check if file is a PDF (for security)
$mime = mime_content_type($filepath);
if ($mime !== 'application/pdf') {
    header('HTTP/1.0 403 Forbidden');
    die('Invalid file type.');
}

// Set headers for download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($filepath));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

// Output the file
readfile($filepath);

// Optionally delete the file after download
// unlink($filepath);
exit;