<?php

$data = $_POST['cart_data'] ?? '[]';
$cart = json_decode($data, true);

if (empty($cart)) {
    header("Location: index.php");
    exit;
}

$tanggal = date("d/m/Y H:i");

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouKantin - Nota & Edit Pesanan</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 15px;
            color: #111827;
        }

        .nota-card {
            width: 100%;
            max-width: 480px;
            margin: 20px auto;
            background: white;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            box-sizing: border-box;
        }

        .nota-header {
            text-align: center;
            border-bottom: 2px dashed #d1d5db;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .nota-header h2 {
            margin: 0 0 6px;
            font-size: 22px;
        }

        .nota-header p {
            margin: 5px;
            color: #555;
        }

        .cart-header {
            margin-bottom: 10px;
        }

        .cart-header h3 {
            margin: 0;
            font-size: 17px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 13px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .item-title {
            margin: 0 0 5px;
            font-size: 16px;
        }

        .item-price {
            color: #d90429;
            font-weight: bold;
        }

        /* Kontrol Jumlah / Qty */
        .qty-control {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f3f4f6;
            padding: 4px 8px;
            border-radius: 8px;
        }

        .btn-qty {
            background: #ffffff;
            border: 1px solid #d1d5db;
            color: #111827;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-qty:hover {
            background: #e5e7eb;
        }

        .qty-count {
            font-weight: bold;
            font-size: 15px;
            min-width: 20px;
            text-align: center;
        }

        .summary-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            padding: 15px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            color: #d90429;
            font-size: 18px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            box-sizing: border-box;
            font-size: 15px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #e63946;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #d62828;
        }

        .kembali {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #e63946;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="nota-card">

    <div class="nota-header">
        <h2>🛍️ Ringkasan Pesanan</h2>
        <p>YouKantin - Kantin SMKN 1 TEBAS</p>
        <p><small><?php echo $tanggal; ?></small></p>
    </div>

    <div class="cart-header">
        <h3>Edit Item Pesanan:</h3>
    </div>

    <!-- Container Daftar Pesanan Dinamis -->
    <div id="cart-list"></div>

    <div class="summary-box">
        <span>Total Bayar:</span>
        <span id="total-price">Rp 0</span>
    </div>

    <form action="proses_bayar.php" method="POST" id="checkout-form">

        <div class="form-group">
            <label>Nama Pemesan:</label>
            <input type="text" name="nama" placeholder="Masukkan nama kamu" required>
        </div>

        <div class="form-group">
            <label>Nomor Meja:</label>
            <input type="number" name="meja" placeholder="Contoh: 5" required>
        </div>

        <div class="form-group">
            <label>Metode Pembayaran:</label>
            <select name="pembayaran" required>
                <option value="QRIS">QRIS / E-Wallet</option>
                <option value="Tunai">Tunai di Kasir</option>
            </select>
        </div>

        <!-- Input Hidden yang akan diisi otomatis oleh JavaScript -->
        <input type="hidden" name="cart_detail" id="cart_detail_input">
        <input type="hidden" name="total_bayar" id="total_bayar_input">

        <button type="submit" class="btn-submit">
            Konfirmasi & Bayar Sekarang
        </button>

    </form>

    <a href="index.php" class="kembali">← Kembali / Tambah Menu Lain</a>

</div>

<script>
    // Ambil data keranjang awal dari PHP
    let cart = <?php echo json_encode($cart); ?>;

    function renderCart() {
        const cartList = document.getElementById('cart-list');
        cartList.innerHTML = '';
        let total = 0;

        if (cart.length === 0) {
            alert('Keranjang Anda kosong! Kembali ke menu utama.');
            window.location.href = 'index.php';
            return;
        }

        cart.forEach((item, index) => {
            const subtotal = item.price * item.qty;
            total += subtotal;

            cartList.innerHTML += `
                <div class="cart-item">
                    <div>
                        <h4 class="item-title">${escapeHtml(item.title)}</h4>
                        <span class="item-price">Rp ${formatRupiah(item.price)}</span>
                    </div>
                    <div class="qty-control">
                        <button type="button" class="btn-qty" onclick="updateQty(${index}, -1)">-</button>
                        <span class="qty-count">${item.qty}</span>
                        <button type="button" class="btn-qty" onclick="updateQty(${index}, 1)">+</button>
                    </div>
                </div>
            `;
        });

        // Update Tampilan Total Harga
        document.getElementById('total-price').innerText = `Rp ${formatRupiah(total)}`;

        // Sync ke hidden input untuk dikirim ke proses_bayar.php
        document.getElementById('cart_detail_input').value = JSON.stringify(cart);
        document.getElementById('total_bayar_input').value = total;
    }

    // Fungsi Tambah / Kurangi Porsi
    function updateQty(index, change) {
        cart[index].qty += change;

        // Jika porsi 0, hapus item dari daftar
        if (cart[index].qty <= 0) {
            cart.splice(index, 1);
        }

        renderCart();
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    function escapeHtml(text) {
        return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }

    // Jalankan render saat halaman pertama dimuat
    renderCart();
</script>

</body>
</html>