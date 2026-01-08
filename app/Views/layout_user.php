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
        
        .main-content {
            min-height: calc(100vh - 72px);
            padding: 40px 0;
        }
        
        .container-custom {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        .page-header {
            margin-bottom: 32px;
        }
        
        .page-title {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        
        .page-subtitle {
            font-size: 16px;
            color: #64748b;
            margin-top: 8px;
        }
        
        .content-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 32px;
        }
        
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
    </style>
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
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url() ?>NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <?= $this->renderSection('script') ?>
</body>