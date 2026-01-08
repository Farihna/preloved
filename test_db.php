// Buat file: test_db.php di root folder

<?php
require 'vendor/autoload.php';

$db = \Config\Database::connect();

if ($db->connID) {
    echo "✅ Database Connected!";
} else {
    echo "❌ Database Connection Failed!";
}