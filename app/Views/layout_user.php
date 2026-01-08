<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preloved - <?php echo ucwords(uri_string() ?: 'Home') ?></title>
    
    <!-- Favicon -->
    <link href="<?= base_url('img/logo-preloved-single.png') ?>" rel="icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Custom Global Styles -->

    <link rel="stylesheet" href="<?= base_url('style/style.css') ?>">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
        }
        
        /* Main Content */
        .main-content {
            min-height: calc(100vh - 72px);
            padding: 40px 0;
        }
        
        .container-custom {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        /* Footer */
        .footer-user {
            background: #1e293b;
            color: white;
            padding: 32px 0;
            margin-top: 60px;
        }
        
        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
            text-align: center;
        }
        
        .footer-content p {
            margin: 0;
            font-size: 14px;
            opacity: 0.8;
        }
        
        /* Modal Fixes */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header {
            border-bottom: 1px solid #e2e8f0;
            padding: 20px 24px;
        }
        
        .modal-body {
            padding: 24px;
        }
        
        .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 16px 24px;
        }
        
        /* Button Resets */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        
        /* Form Controls */
        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }
        
        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Loading Overlay */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        
        .loading-overlay.show {
            display: flex;
        }
        
        .loading-spinner {
            background: white;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
        }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <?= $this->include('components/user/header') ?>
    
    <main class="main-content">
        <div class="container-custom">
            <?= $this->renderSection('content') ?>
        </div>
    </main>
    
    <footer class="footer-user">
        <div class="footer-content">
            <p>&copy; <?= date('Y') ?> Preloved-U. All Rights Reserved</p>
        </div>
    </footer>
    
    <!-- Loading Overlay (Global) -->
    <div class="loading-overlay" id="globalLoading">
        <div class="loading-spinner">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p style="margin-top: 16px; color: #64748b;">Loading...</p>
        </div>
    </div>
    
    <!-- jQuery (Required for some interactions) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap 5 JS Bundle (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Global JavaScript -->
    <script>
        // Show loading overlay
        function showLoading() {
            document.getElementById('globalLoading').classList.add('show');
        }
        
        // Hide loading overlay
        function hideLoading() {
            document.getElementById('globalLoading').classList.remove('show');
        }
        
        // Format currency
        function formatCurrency(amount) {
            return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
        }
        
        // Show toast notification (Bootstrap Toast)
        function showToast(message, type = 'success') {
            const toastHtml = `
                <div class="toast align-items-center text-white bg-${type} border-0" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', toastHtml);
            const toastElement = document.querySelector('.toast:last-child');
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            
            // Remove after hide
            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>