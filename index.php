<?php
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word to PDF Converter | Transform Documents Instantly</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <path d="M16 13H8"></path>
                    <path d="M16 17H8"></path>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span>DocConvert</span>
            </div>
            <nav>
                <a href="#">Home</a>
                <a href="#">Features</a>
                <a href="#">Help</a>
            </nav>
        </header>

        <main class="container">
            <div class="hero">
                <h1>Convert Word to PDF in Seconds</h1>
                <p class="subtitle">Free online tool to transform your DOC/DOCX files to high-quality PDF documents</p>
                
                <form id="converter-form" action="convert.php" method="post" enctype="multipart/form-data">
                    <div class="upload-area" id="uploadArea">
                        <input type="file" id="wordFile" name="wordFile" accept=".doc,.docx" required>
                        <label for="wordFile">
                            <div class="upload-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#3498db" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                            </div>
                            <p class="upload-text">Drag & drop your Word file here or <span class="browse-link">browse files</span></p>
                            <p class="upload-hint">Supports: .doc, .docx (Max 20MB)</p>
                        </label>
                        <div id="fileInfo" class="file-info"></div>
                    </div>
                    
                    <div class="options">
                        <div class="form-group">
                            <label for="email">Get download link via email (optional):</label>
                            <input type="email" id="email" name="email" placeholder="your@email.com">
                        </div>
                        
                        <button type="submit" id="convertBtn">
                            <span class="btn-text">Convert to PDF</span>
                            <span class="btn-loader">
                                <svg viewBox="0 0 50 50">
                                    <circle cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="features-section">
                <h2>Why Choose Our Converter?</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3498db" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                        <h3>Secure Conversion</h3>
                        <p>Your files are automatically deleted from our servers after 1 hour. No one has access to your documents.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3498db" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <h3>Perfect Formatting</h3>
                        <p>Preserve all text formatting, images, and layout from your original Word document.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3498db" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                <line x1="15" y1="9" x2="15.01" y2="9"></line>
                            </svg>
                        </div>
                        <h3>Free Forever</h3>
                        <p>No registration required, no watermarks, completely free with unlimited conversions.</p>
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <div class="footer-content">
                <div class="footer-logo">DocConvert</div>
                <div class="footer-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Contact Us</a>
                </div>
                <div class="footer-copyright">
                    &copy; <?php echo date('Y'); ?> Word to PDF Converter. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>