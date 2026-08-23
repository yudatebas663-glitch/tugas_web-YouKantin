<?php
// Menerima data kiriman dari nota.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['cart_detail'])) {
    header("Location: index.php");
    exit();
}

$nama = isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : 'Pelanggan';
$meja = isset($_POST['meja']) ? htmlspecialchars($_POST['meja']) : '-';
$pembayaran = isset($_POST['pembayaran']) ? htmlspecialchars($_POST['pembayaran']) : 'Tunai';
$total_bayar = isset($_POST['total_bayar']) ? (int)$_POST['total_bayar'] : 0;

$cart_json = $_POST['cart_detail'];
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
    $cart_json = stripslashes($cart_json);
}
$cart_items = json_decode($cart_json, true);

// Nomor Transaksi Acak
$no_trx = "YK-" . date('Ymd') . "-" . rand(100, 999);
$tanggal = date('d/m/Y H:i');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YouKantin - Bukti Transaksi</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { 
      background-color: #f4f6f9; 
      font-family: 'Plus Jakarta Sans', sans-serif; 
      padding: 15px; 
      margin: 0; 
      color: #1a1a1a; /* Warna teks utama lebih gelap dan tajam */
    }
    
    .struk-card { 
      max-width: 480px; 
      margin: 0 auto; 
      background: #ffffff; 
      padding: 24px; 
      border-radius: 20px; 
      box-shadow: 0 10px 25px rgba(0,0,0,0.08); 
      box-sizing: border-box; 
    }
    
    .status-badge { 
      text-align: center; 
      margin-bottom: 15px; 
    }
    
    .status-badge .icon { 
      font-size: 3rem; 
      margin-bottom: 5px; 
    }
    
    .status-badge h3 { 
      margin: 0; 
      color: #1e7e34; 
      font-size: 1.25rem; 
      font-weight: 800; 
    }
    
    .info-box { 
      background: #f8f9fa; 
      border: 1px solid #e9ecef;
      padding: 14px; 
      border-radius: 12px; 
      font-size: 0.9rem; 
      margin-bottom: 15px; 
      line-height: 1.7; 
      color: #212529;
    }
    
    .info-row { 
      display: flex; 
      justify-content: space-between; 
    }
    
    .info-row span {
      color: #495057;
    }
    
    .item-row { 
      display: flex; 
      justify-content: space-between; 
      font-size: 0.95rem; 
      padding: 10px 0; 
      border-bottom: 1px dashed #dee2e6; 
      color: #212529;
    }
    
    .item-title {
      font-weight: 700;
      color: #111827;
    }

    .item-sub {
      color: #4b5563;
      font-size: 0.85rem;
      font-weight: 600;
    }
    
    /* QRIS Box dengan kontras warna yang aman dan terbaca jelas */
    .qris-box { 
      text-align: center; 
      background: #fff9db; 
      border: 2px dashed #f59f00; 
      padding: 15px; 
      border-radius: 12px; 
      margin: 15px 0; 
      color: #856404;
    }
    
    .qris-box img { 
      max-width: 180px; 
      border-radius: 8px; 
      margin-top: 10px; 
      border: 1px solid #ffe8cc;
    }

    /* Cash Box dengan kontras biru terang & teks gelap */
    .cash-box {
      text-align: center;
      background: #e7f5ff; 
      border: 2px dashed #339af0; 
      padding: 15px; 
      border-radius: 12px; 
      margin: 15px 0; 
      color: #1864ab;
    }
    
    .total-box { 
      display: flex; 
      justify-content: space-between; 
      font-weight: 800; 
      font-size: 1.2rem; 
      color: #d90429; 
      padding-top: 12px; 
      margin-top: 10px; 
      border-top: 2px solid #212529; 
    }
    
    .btn-group { 
      display: flex; 
      gap: 10px; 
      margin-top: 20px; 
    }
    
    .btn { 
      flex: 1; 
      padding: 12px; 
      border: none; 
      border-radius: 10px; 
      font-weight: 700; 
      cursor: pointer; 
      text-align: center; 
      text-decoration: none; 
      font-size: 0.95rem; 
    }
    
    .btn-print { background: #212529; color: #ffffff; }
    .btn-home { background: #e63946; color: #ffffff; }
    
    @media print {
      body { background: none; padding: 0; }
      .struk-card { box-shadow: none; max-width: 100%; border-radius: 0; padding: 0; }
      .btn-group { display: none; }
    }
  </style>
</head>
<body>

<div class="struk-card">
  <div class="status-badge">
    <div class="icon">✅</div>
    <h3>Pesanan Berhasil Disimpan</h3>
    <p style="font-size: 0.85rem; color: #495057; font-weight: 600; margin-top: 4px;">YouKantin - SMKN 1 TEBAS</p>
  </div>

  <div class="info-box">
    <div class="info-row"><span>No. Transaksi:</span> <strong style="color: #111827;"><?php echo $no_trx; ?></strong></div>
    <div class="info-row"><span>Tanggal:</span> <strong style="color: #111827;"><?php echo $tanggal; ?></strong></div>
    <div class="info-row"><span>Nama Pemesan:</span> <strong style="color: #111827;"><?php echo $nama; ?></strong></div>
    <div class="info-row"><span>Nomor Meja:</span> <strong style="color: #111827;">Meja <?php echo $meja; ?></strong></div>
    <div class="info-row"><span>Metode Bayar:</span> <strong style="color: #e63946;"><?php echo $pembayaran; ?></strong></div>
  </div>

  <?php if ($pembayaran === 'QRIS'): ?>
    <div class="qris-box">
      <strong style="font-size: 0.95rem; color: #d9480f;">Silakan Scan QRIS Ini untuk Membayar:</strong><br>
      <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=YouKantin-<?php echo $no_trx; ?>-Rp<?php echo $total_bayar; ?>" alt="QRIS Code"><br>
      <small style="color: #495057; font-weight: 600; display: block; margin-top: 8px;">Tunjukkan bukti bayar ini ke kasir/petugas kantin.</small>
    </div>
  <?php else: ?>
    <div class="cash-box">
      <strong style="font-size: 1rem;">Bayar Langsung di Kasir</strong><br>
      <small style="color: #212529; font-size: 0.85rem; display: block; margin-top: 4px;">Sebutkan <strong>No. Meja <?php echo $meja; ?></strong> atau <strong>Nama (<?php echo $nama; ?>)</strong> saat pembayaran di kasir.</small>
    </div>
  <?php endif; ?>

  <h4 style="margin: 15px 0 8px 0; font-size: 1rem; color: #111827;">Rincian Pesanan:</h4>
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
        <div style="align-self: center;">
          <strong style="color: #111827;">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></strong>
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
  // Pastikan keranjang di browser dibersihkan total
  localStorage.removeItem('youkantin_cart');
</script>

</body>
</html>