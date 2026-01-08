<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Preloved - <?php echo ucwords(uri_string() ?: 'Dashboard') ?></title>
    
    <link href="<?= base_url('img/logo-preloved-single.png') ?>" rel="icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- DataTables CSS (for admin tables) -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">

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
        }
        
        .main-admin {
            margin-left: 280px;
            min-height: calc(100vh - 72px);
            padding: 32px;
            transition: all 0.3s ease;
        }
        
        /* DataTable Styling */
        .datatable thead th {
            background: #f8fafc;
            font-weight: 700;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .datatable tbody tr:hover {
            background: #f8fafc;
        }
        
        @media (max-width: 768px) {
            .main-admin {
                margin-left: 0;
            }
        }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <?= $this->include('components/sidebar') ?>
    
    <main class="main-admin">
        <?= $this->renderSection('content') ?>
    </main>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Initialize DataTables
        $(document).ready(function() {
            $('.datatable').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>