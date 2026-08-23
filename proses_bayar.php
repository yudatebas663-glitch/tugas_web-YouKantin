<?php
require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['cart_detail'])) {
    header("Location: index.php");
    exit();
}

$nama = isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : 'Pelanggan';
$meja = isset($_POST['meja']) ? htmlspecialchars($_POST['meja']) : '-';
$pembayaran = 'Tunai';
$total_bayar = isset($_POST['total_bayar']) ? (int)$_POST['total_bayar'] : 0;

$cart_json = $_POST['cart_detail'];
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
    $cart_json = stripslashes($cart_json);
}
$cart_items = json_decode($cart_json, true);

$no_trx = "YK-" . date('Ymd') . "-" . rand(100, 999);
$tanggal = date('d/m/Y H:i');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YouKantin - Bukti Transaksi</title>
  <link rel="stylesheet" href="style.css?v=1.1">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="page-light">

<div class="struk-card">
  <div class="status-badge">
    <div class="icon">✅</div>
    <h3>Pesanan Berhasil Disimpan</h3>
    <p class="status-subtitle">YouKantin - SMKN 1 TEBAS</p>
  </div>

  <div class="info-box">
    <div class="info-row"><span>No. Transaksi:</span> <strong class="text-dark"><?php echo $no_trx; ?></strong></div>
    <div class="info-row"><span>Tanggal:</span> <strong class="text-dark"><?php echo $tanggal; ?></strong></div>
    <div class="info-row"><span>Nama Pemesan:</span> <strong class="text-dark"><?php echo $nama; ?></strong></div>
    <div class="info-row"><span>Nomor Meja:</span> <strong class="text-dark">Meja <?php echo $meja; ?></strong></div>
    <div class="info-row"><span>Metode Bayar:</span> <strong class="text-red"><?php echo $pembayaran; ?></strong></div>
  </div>

  <div class="cash-box">
    <strong class="cash-box-title">Bayar Langsung di Kasir (Tunai)</strong><br>
    <small class="cash-box-desc">Sebutkan <strong>No. Meja <?php echo $meja; ?></strong> atau <strong>Nama (<?php echo $nama; ?>)</strong> saat melakukan pembayaran di kasir.</small>
  </div>

  <h4 class="section-title-dark">Rincian Pesanan:</h4>
  <div>
    <?php foreach ($cart_items as $item): ?>
      <?php 
        $price = (int)$item['price'];
        $qty = (int)$item['qty'];
        $subtotal = $price * $qty;
      ?>
      <div class="item-row">
        <div>
          <span class="item-title"><?php echo htmlspecialchars($item['title']); ?></span><br>
          <span class="item-sub"><?php echo $qty; ?> x Rp <?php echo number_format($price, 0, ',', '.'); ?></span>
        </div>
        <div class="item-row-left">
          <strong class="text-dark">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></strong>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="total-box">
    <span>Total Tagihan:</span>
    <span>Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></span>
  </div>

  <div class="btn-group">
    <button type="button" onclick="window.print()" class="btn btn-print">🖨️ Cetak Struk</button>
    <a href="index.php" class="btn btn-home">Pesan Lagi ➔</a>
  </div>
</div>

<script>
  localStorage.removeItem('youkantin_cart');
</script>

</body>
</html>