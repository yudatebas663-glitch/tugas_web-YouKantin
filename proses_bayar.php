<?php
require_once 'config.php';

date_default_timezone_set('Asia/Jakarta');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pemesan = $_SESSION['nama_lengkap'] ?? $_SESSION['username'] ?? 'Pembeli';
    $nomor_meja   = '-';
    $cart_raw     = $_POST['cart_data'] ?? '[]';
    $cart_data    = json_decode($cart_raw, true);

    if (empty($cart_data) || !is_array($cart_data)) {
        echo "<script>alert('Keranjang belanja kosong!'); window.location.href='index.php';</script>";
        exit();
    }

    $nama_pemesan_clean = mysqli_real_escape_string($conn, $nama_pemesan);
    $nomor_meja_clean   = mysqli_real_escape_string($conn, $nomor_meja);

    $total_harga = 0;
    foreach ($cart_data as $item) {
        $q = (int)($item['qty'] ?? 1);
        $p = (int)($item['price'] ?? 0);
        $total_harga += ($p * $q);
    }

    $no_trx     = 'TRX-' . date('Ymd') . rand(1000, 9999);
    $created_at = date("Y-m-d H:i:s");

    $query_pesanan = "INSERT INTO pesanan (no_trx, nama_pemesan, nomor_meja, total_harga, status, created_at) 
                      VALUES ('$no_trx', '$nama_pemesan_clean', '$nomor_meja_clean', $total_harga, 'Menunggu', '$created_at')";

    if (mysqli_query($conn, $query_pesanan)) {
        $pesanan_id = mysqli_insert_id($conn);

        foreach ($cart_data as $item) {
            $nama_item  = mysqli_real_escape_string($conn, $item['title'] ?? 'Menu');
            $harga_item = (int)($item['price'] ?? 0);
            $qty_item   = (int)($item['qty'] ?? 1);
            $subtotal   = $harga_item * $qty_item;

            $query_detail = "INSERT INTO pesanan_detail (pesanan_id, nama_menu, harga, qty, subtotal) 
                             VALUES ($pesanan_id, '$nama_item', $harga_item, $qty_item, $subtotal)";
            
            mysqli_query($conn, $query_detail);
        }

        echo "<script>
                localStorage.removeItem('youkantin_cart');
                window.location.href = 'nota.php?id=" . $pesanan_id . "';
              </script>";
        exit();
    } else {
        echo "<script>alert('Gagal menyimpan pesanan: " . mysqli_error($conn) . "'); window.history.back();</script>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
