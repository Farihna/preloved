<style>
    table {
        border-collapse: collapse; /* Ini kunci untuk menghilangkan garis dobel */
        width: 100%;
        margin-bottom: 10px;
    }
    
    table, th, td {
        border: 1px solid black; /* Menentukan ketebalan dan warna garis tunggal */
    }

    th, td {
        padding: 8px; /* Menambah ruang agar teks tidak menempel ke garis */
    }
</style>

<h1>Data Produk</h1>

<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Deskripsi</th>
        <th>Foto</th>
    </tr>

    <?php
    $no = 1;
    foreach ($product as $index => $produk) :
        // Logika Base64 Anda tetap sama
        $path = "../public/img/" . $produk['foto'];
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    ?>
        <tr>
            <td align="center"><?= $index + 1 ?></td>
            <td><?= $produk['nama'] ?></td>
            <td align="right"><?= "Rp " . number_format($produk['harga'], 2, ",", ".") ?></td>
            <td><?= $produk['deskripsi'] ?></td>
            <td align="center">
                <img src="<?= $base64 ?>" width="50px">
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<span>Downloaded on <?= date("Y-m-d H:i:s") ?></span>