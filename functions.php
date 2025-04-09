<?php
// Database configuration (optional)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'converter');

// File upload configuration
define('UPLOAD_DIR', 'uploads/');
define('CONVERTED_DIR', 'converted/');
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_TYPES', ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);

// Create directories if they don't exist
if (!file_exists(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}
if (!file_exists(CONVERTED_DIR)) {
    mkdir(CONVERTED_DIR, 0777, true);
}

/**
 * Connect to the database
 * @return PDO|null
 */
function connectDB() {
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        // In production, log this error instead of displaying it
        error_log("Database connection failed: " . $e->getMessage());
        return null;
    }
}

/**
 * Log conversion to database
 * @param string $originalFilename
 * @param string $convertedFilename
 * @param int $fileSize
 * @return bool
 */
function logConversion($originalFilename, $convertedFilename, $fileSize) {
    $pdo = connectDB();
    if (!$pdo) return false;
    
    try {
        $stmt = $pdo->prepare("INSERT INTO conversions (original_filename, converted_filename, file_size, ip_address) 
                             VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $originalFilename,
            $convertedFilename,
            $fileSize,
            $_SERVER['REMOTE_ADDR']
        ]);
    } catch (PDOException $e) {
        error_log("Failed to log conversion: " . $e->getMessage());
        return false;
    }
}

/**
 * Sanitize filename
 * @param string $filename
 * @return string
 */
function sanitizeFilename($filename) {
    $filename = preg_replace('/[^a-zA-Z0-9\-\._]/', '', $filename);
    return time() . '_' . $filename;
}

/**
 * Convert Word to PDF using LibreOffice (requires LibreOffice installed on server)
 * @param string $inputFile
 * @param string $outputFile
 * @return bool
 */
function convertWordToPDF($inputFile, $outputFile) {
    // This requires LibreOffice to be installed on the server
    $command = "libreoffice --headless --convert-to pdf --outdir " . escapeshellarg(dirname($outputFile)) . " " . escapeshellarg($inputFile);
    exec($command, $output, $returnCode);
    
    // Check if conversion was successful
    if ($returnCode === 0 && file_exists($outputFile)) {
        return true;
    }
    
    // Alternative PHP method if LibreOffice is not available
    // Note: This requires additional PHP libraries like phpword and tcpdf
    // This is a fallback and won't work out of the box
    return false;
}

/**
 * Send email notification
 * @param string $email
 * @param string $downloadLink
 * @return bool
 */
function sendEmailNotification($email, $downloadLink) {
    $subject = 'Your Word to PDF Conversion is Ready';
    $message = "Thank you for using our Word to PDF converter.\n\n";
    $message .= "You can download your converted file here:\n";
    $message .= $downloadLink . "\n\n";
    $message .= "This link will expire in 24 hours.\n";
    
    $headers = 'From: noreply@wordtopdfconverter.com' . "\r\n" .
               'Reply-To: noreply@wordtopdfconverter.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    
    return mail($email, $subject, $message, $headers);
}

/**
 * Clean old files from directories
 */
function cleanOldFiles() {
    // Define the directories to clean
    $directories = [UPLOAD_DIR, CONVERTED_DIR];
    $now = time();
    $deletedCount = 0;
    $errorCount = 0;

    foreach ($directories as $directory) {
        // Get all files in the directory
        $files = glob($directory . '*');
        
        foreach ($files as $file) {
            // Verify it's a file (not a directory)
            if (is_file($file)) {
                // Check if file is older than 24 hours (86400 seconds)
                if (($now - filemtime($file)) >= 86400) {
                    // Attempt to delete the file
                    if (@unlink($file)) {
                        $deletedCount++;
                    } else {
                        error_log("Failed to delete file: " . $file);
                        $errorCount++;
                    }
                }
            }
        }
    }

    // Return status information
    return [
        'deleted' => $deletedCount,
        'errors' => $errorCount,
        'message' => "Cleaned old files. Deleted: $deletedCount, Errors: $errorCount"
    ];
}