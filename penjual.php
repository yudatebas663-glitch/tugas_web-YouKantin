<?php
require_once 'config.php';

// Cek akses hanya untuk penjual
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'penjual') {
    header("Location: login.php");
    exit();
}

// Proses Perubahan Status Pesanan
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];
    $status = '';

    if ($action === 'proses') {
        $status = 'Diproses';
    } elseif ($action === 'selesai') {
        $status = 'Selesai';
    } elseif ($action === 'tolak') {
        $status = 'Ditolak';
    }

    if ($status !== '') {
        $stmt = mysqli_prepare($conn, "UPDATE pesanan SET status = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        mysqli_stmt_execute($stmt);
    }

    header("Location: penjual.php");
    exit();
}

// 1. Hitung ringkasan statistik
$q_total_pesanan = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan");
$total_pesanan   = mysqli_fetch_assoc($q_total_pesanan)['total'] ?? 0;

$q_pesanan_selesai = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status = 'Selesai'");
$pesanan_selesai   = mysqli_fetch_assoc($q_pesanan_selesai)['total'] ?? 0;

$q_total_penjualan = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM pesanan WHERE status = 'Selesai'");
$total_penjualan   = mysqli_fetch_assoc($q_total_penjualan)['total'] ?? 0;

// 2. Ambil semua data pesanan beserta detail itemnya
$query = "SELECT p.*, 
          GROUP_CONCAT(CONCAT(pd.qty, 'x ', pd.nama_menu) SEPARATOR '<br>') AS items 
          FROM pesanan p 
          LEFT JOIN pesanan_detail pd ON p.id = pd.pesanan_id 
          GROUP BY p.id 
          ORDER BY p.id DESC";

$res = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Penjual - YouKantin</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="dark-bg">
  <div class="dashboard-container">
    <div class="dashboard-header">
      <div>
        <h1>Dashboard Kantin</h1>
        <p>Kelola pesanan masuk SMKN 1 TEBAS</p>
      </div>
      <a href="logout.php" class="btn-logout">Keluar</a>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="stats-grid">
      <div class="stat-card">
        <span class="stat-title">TOTAL PESANAN</span>
        <span class="stat-value"><?php echo number_format($total_pesanan, 0, ',', '.'); ?></span>
      </div>
      <div class="stat-card">
        <span class="stat-title">PESANAN SELESAI</span>
        <span class="stat-value text-success"><?php echo number_format($pesanan_selesai, 0, ',', '.'); ?></span>
      </div>
      <div class="stat-card">
        <span class="stat-title">TOTAL PENJUALAN</span>
        <span class="stat-value text-primary">Rp <?php echo number_format($total_penjualan, 0, ',', '.'); ?></span>
      </div>
    </div>

    <div class="table-card">
      <table class="data-table">
        <thead>
          <tr>
            <th width="15%">NO. TRX</th>
            <th width="12%">PEMESAN</th>
            <th width="28%">DETAIL PESANAN</th>
            <th width="15%">WAKTU</th>
            <th width="10%">TOTAL</th>
            <th width="10%">STATUS</th>
            <th width="10%" style="text-align: center;">AKSI</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($res) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($res)): ?>
            <?php 
              $status_class = strtolower($row['status']);
              if ($status_class == 'diproses') $status_class = 'proses';
            ?>
            <tr>
              <td><strong class="trx-code"><?php echo htmlspecialchars($row['no_trx']); ?></strong></td>
              <td><span class="user-name"><?php echo htmlspecialchars($row['nama_pemesan']); ?></span></td>
              <td class="items-cell"><?php echo $row['items'] ? $row['items'] : '-'; ?></td>
              <td class="time-cell"><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
              <td class="price-cell">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
              <td>
                <span class="badge bg-<?php echo $status_class; ?>">
                  <?php echo htmlspecialchars($row['status']); ?>
                </span>
              </td>
              <td>
                <div class="action-btn-group">
                  <a href="penjual.php?action=proses&id=<?php echo $row['id']; ?>" class="btn-action btn-proses" title="Proses Pesanan">Proses</a>
                  <a href="penjual.php?action=selesai&id=<?php echo $row['id']; ?>" class="btn-action btn-selesai" title="Pesanan Selesai">Selesai</a>
                  <a href="penjual.php?action=tolak&id=<?php echo $row['id']; ?>" class="btn-action btn-tolak" onclick="return confirm('Yakin ingin menolak pesanan ini?')" title="Tolak Pesanan">Tolak</a>
                  <a href="nota.php?id=<?php echo $row['id']; ?>" class="btn-action btn-nota" target="_blank" title="Cetak Struk">Struk</a>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" style="text-align: center; padding: 30px; color: #94a3b8;">Belum ada pesanan masuk.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>