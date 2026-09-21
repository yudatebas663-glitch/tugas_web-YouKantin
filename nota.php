<?php
require_once 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Update Nama Pemesan
if (isset($_POST['update_nama'])) {
    $nama_baru = mysqli_real_escape_string($conn, trim($_POST['nama_pemesan']));
    mysqli_query($conn, "UPDATE pesanan SET nama_pemesan = '$nama_baru' WHERE id = $id");
    header("Location: nota.php?id=$id");
    exit();
}

// Update Qty / Tambah / Kurang Item
if (isset($_GET['action']) && isset($_GET['detail_id'])) {
    $detail_id = (int)$_GET['detail_id'];
    $action    = $_GET['action'];

    $q_detail = mysqli_query($conn, "SELECT * FROM pesanan_detail WHERE id = $detail_id AND pesanan_id = $id");
    $detail   = mysqli_fetch_assoc($q_detail);

    if ($detail) {
        if ($action === 'plus') {
            $new_qty = $detail['qty'] + 1;
            $new_sub = $new_qty * $detail['harga'];
            mysqli_query($conn, "UPDATE pesanan_detail SET qty = $new_qty, subtotal = $new_sub WHERE id = $detail_id");
        } elseif ($action === 'minus') {
            if ($detail['qty'] > 1) {
                $new_qty = $detail['qty'] - 1;
                $new_sub = $new_qty * $detail['harga'];
                mysqli_query($conn, "UPDATE pesanan_detail SET qty = $new_qty, subtotal = $new_sub WHERE id = $detail_id");
            } else {
                mysqli_query($conn, "DELETE FROM pesanan_detail WHERE id = $detail_id");
            }
        } elseif ($action === 'delete') {
            mysqli_query($conn, "DELETE FROM pesanan_detail WHERE id = $detail_id");
        }

        // Recalculate Total Harga Pesanan
        $q_sum = mysqli_query($conn, "SELECT SUM(subtotal) as total FROM pesanan_detail WHERE pesanan_id = $id");
        $sum_res = mysqli_fetch_assoc($q_sum);
        $total_baru = $sum_res['total'] ?? 0;

        mysqli_query($conn, "UPDATE pesanan SET total_harga = $total_baru WHERE id = $id");
    }

    header("Location: nota.php?id=$id");
    exit();
}

$query = "SELECT * FROM pesanan WHERE id = $id";
$res   = mysqli_query($conn, $query);
$trx   = mysqli_fetch_assoc($res);

if (!$trx) {
    echo "Pesanan tidak ditemukan.";
    exit();
}

$query_detail = "SELECT * FROM pesanan_detail WHERE pesanan_id = $id";
$res_detail   = mysqli_query($conn, $query_detail);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nota #<?php echo $trx['no_trx']; ?></title>
  <link rel="stylesheet" href="style.css">
  <style>
    .nota-card {
      max-width: 420px;
      margin: 30px auto;
      background: #fff;
      padding: 24px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      font-family: Arial, sans-serif;
    }
    .header-nota { text-align: center; margin-bottom: 15px; }
    .header-nota h2 { margin: 0; font-size: 22px; color: #1e293b; }
    .header-nota p { margin: 4px 0 0; font-size: 13px; color: #64748b; }
    .divider { border-bottom: 2px dashed #cbd5e1; margin: 12px 0; }
    .info-row { display: flex; justify-content: space-between; align-items: center; font-size: 13px; margin-bottom: 8px; color: #334155; }
    
    .edit-nama-form { display: flex; gap: 4px; }
    .input-nama { font-size: 12px; padding: 3px 6px; border: 1px solid #cbd5e1; border-radius: 4px; width: 130px; }
    .btn-save-nama { background: #2563eb; color: #fff; border: none; border-radius: 4px; padding: 3px 8px; font-size: 11px; cursor: pointer; }

    .nota-table { width: 100%; border-collapse: collapse; margin: 10px 0; }
    .nota-table td { padding: 6px 0; font-size: 13px; color: #1e293b; vertical-align: middle; }
    .qty-controls { display: inline-flex; align-items: center; gap: 4px; margin-right: 6px; }
    .btn-qty { 
      display: inline-block; width: 20px; height: 20px; line-height: 18px; text-align: center; 
      background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 4px; 
      color: #0f172a; text-decoration: none; font-weight: bold; font-size: 12px;
    }
    .btn-qty:hover { background: #e2e8f0; }
    .btn-del { color: #ef4444; text-decoration: none; font-weight: bold; font-size: 14px; margin-left: 6px; }

    .total-section { font-weight: bold; font-size: 15px; color: #0f172a; margin-top: 10px; }
    .status-box { background: #e2e8f0; text-align: center; padding: 8px; border-radius: 6px; font-weight: bold; font-size: 13px; margin: 15px 0; color: #334155; }
    
    .actions { display: flex; gap: 10px; }
    .btn-nota-action { flex: 1; text-align: center; padding: 10px; background: #2563eb; color: #fff; text-decoration: none; border: none; border-radius: 6px; font-size: 13px; font-weight: bold; cursor: pointer; }
    .btn-secondary { background: #64748b; }

    @media print {
      .btn-qty, .btn-del, .edit-nama-form button, .actions { display: none !important; }
      .input-nama { border: none; background: transparent; padding: 0; width: auto; font-weight: bold; }
    }
  </style>
</head>
<body class="nota-body">
  <div class="nota-card">
    <div class="header-nota">
      <h2>YouKantin</h2>
      <p>SMKN 1 TEBAS</p>
    </div>
    
    <div class="divider"></div>

    <div class="info-row">
      <span>No. Trx:</span>
      <span><strong><?php echo htmlspecialchars($trx['no_trx']); ?></strong></span>
    </div>
    
    <div class="info-row">
      <span>Pemesan:</span>
      <form action="" method="POST" class="edit-nama-form">
        <input type="text" name="nama_pemesan" class="input-nama" value="<?php echo htmlspecialchars($trx['nama_pemesan']); ?>" required>
        <button type="submit" name="update_nama" class="btn-save-nama">Simpan</button>
      </form>
    </div>

    <div class="info-row">
      <span>Waktu:</span>
      <span><?php echo $trx['created_at']; ?></span>
    </div>
    
    <div class="divider"></div>

    <table class="nota-table">
      <?php if (mysqli_num_rows($res_detail) > 0): ?>
        <?php while ($item = mysqli_fetch_assoc($res_detail)): ?>
        <tr>
          <td>
            <span class="qty-controls">
              <a href="nota.php?id=<?php echo $id; ?>&detail_id=<?php echo $item['id']; ?>&action=minus" class="btn-qty" title="Kurangi">-</a>
              <strong><?php echo $item['qty']; ?>x</strong>
              <a href="nota.php?id=<?php echo $id; ?>&detail_id=<?php echo $item['id']; ?>&action=plus" class="btn-qty" title="Tambah">+</a>
            </span>
            <?php echo htmlspecialchars($item['nama_menu']); ?>
            <a href="nota.php?id=<?php echo $id; ?>&detail_id=<?php echo $item['id']; ?>&action=delete" class="btn-del" onclick="return confirm('Hapus item ini?')" title="Hapus Menu">✕</a>
          </td>
          <td style="text-align: right;">Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></td>
        </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="2" style="text-align: center; color: #94a3b8;">Tidak ada item.</td>
        </tr>
      <?php endif; ?>
    </table>

    <div class="divider"></div>

    <div class="total-section info-row">
      <span>TOTAL:</span>
      <span>Rp <?php echo number_format($trx['total_harga'], 0, ',', '.'); ?></span>
    </div>

    <div class="status-box">
      STATUS: <?php echo strtoupper($trx['status']); ?>
    </div>

    <div class="actions">
      <button class="btn-nota-action" onclick="window.print()">Cetak Struk</button>
      <a href="index.php" class="btn-nota-action btn-secondary">Kembali Menu</a>
    </div>
  </div>
</body>
</html>
