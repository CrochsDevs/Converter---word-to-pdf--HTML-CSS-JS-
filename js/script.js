document.addEventListener('DOMContentLoaded', function() {
    const wordFileInput = document.getElementById('wordFile');
    const uploadArea = document.getElementById('uploadArea');
    const fileInfo = document.getElementById('fileInfo');
    const convertBtn = document.getElementById('convertBtn');
    const converterForm = document.getElementById('converter-form');
    
    // Handle file selection
    wordFileInput.addEventListener('change', function(e) {
        if (this.files.length > 0) {
            handleFileSelection(this.files[0]);
        }
    });
    
    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', function() {
        this.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        if (e.dataTransfer.files.length > 0) {
            wordFileInput.files = e.dataTransfer.files;
            handleFileSelection(e.dataTransfer.files[0]);
        }
    });
    
    // Form submission
    converterForm.addEventListener('submit', function(e) {
        if (!wordFileInput.files || wordFileInput.files.length === 0) {
            e.preventDefault();
            showAlert('Please select a Word file first.', 'error');
            return;
        }
        
        // Show loading state
        convertBtn.classList.add('loading');
    });
    
    // Handle file selection
    function handleFileSelection(file) {
        const fileSize = formatFileSize(file.size);
        
        fileInfo.innerHTML = `
            <p><strong>Selected file:</strong> ${file.name}</p>
            <p><strong>Size:</strong> ${fileSize}</p>
            <p><strong>Type:</strong> ${file.type || 'Word document'}</p>
        `;
        fileInfo.style.display = 'block';
        uploadArea.classList.add('active');
    }
    
    // Show alert message
    function showAlert(message, type = 'success') {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.textContent = message;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }
    
    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});