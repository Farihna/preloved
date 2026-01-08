<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin - Preloved - <?php echo ucwords(uri_string() ?: 'Dashboard') ?></title>
    
    <link href="<?= base_url("img/logo-preloved-single.png") ?>" rel="icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="<?= base_url() ?>NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    
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
        }
        
        .main-admin {
            margin-left: 280px;
            margin-top: 72px;
            min-height: calc(100vh - 72px);
            padding: 32px;
            transition: all 0.3s ease;
        }
        
        .page-header-admin {
            margin-bottom: 32px;
        }
        
        .page-title-admin {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 8px 0;
        }
        
        .page-subtitle-admin {
            font-size: 15px;
            color: #64748b;
        }
        
        .content-card-admin {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 28px;
        }
        
        @media (max-width: 768px) {
            .main-admin {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('components/sidebar') ?>
    <?= $this->include('components/user/header') ?>
    
    <main class="main-admin">
        <?= $this->renderSection('content') ?>
    </main>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url() ?>NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js"></script>
    
    <?= $this->renderSection('script') ?>
</body>
</html>