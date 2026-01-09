<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run()
    {
        // 1. Naikkan limit agar tidak mati di tengah jalan
        ini_set('memory_limit', '512M'); 
        set_time_limit(0);

        $sqlPath = ROOTPATH . 'db_region.sql';

        if (!file_exists($sqlPath)) {
            die("File SQL tidak ditemukan di: " . $sqlPath);
        }

        // 2. Gunakan koneksi mysqli asli untuk performa maksimal
        $conn = $this->db->connID; 

        // 3. Baca file dan eksekusi
        $sql = file_get_contents($sqlPath);
        
        echo "Sedang mengimpor data wilayah harap tunggu...\n";

        if (mysqli_multi_query($conn, $sql)) {
            do {
                if ($result = mysqli_store_result($conn)) {
                    mysqli_free_result($result);
                }
            } while (mysqli_next_result($conn));
            echo "Impor Berhasil!\n";
        } else {
            echo "Error: " . mysqli_error($conn) . "\n";
        }
    }
}
