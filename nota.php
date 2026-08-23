
<?php
require_once 'config.php';
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
    <title>YouKantin - Ringkasan Pesanan</title>
    <link rel="stylesheet" href="style.css?v=1.1">
</head>

<body class="page-light">

<div class="nota-card">

    <div class="nota-header">
        <h2>🛍️ Ringkasan Pesanan</h2>
        <p>YouKantin - Kantin SMKN 1 TEBAS</p>
        <p><small><?php echo $tanggal; ?></small></p>
    </div>

    <div class="cart-header">
        <h3>Edit Item Pesanan:</h3>
    </div>

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
            <label>Nomor Meja (1 - 15):</label>
            <input 
                type="number" 
                name="meja" 
                id="input-meja"
                min="1" 
                max="15" 
                placeholder="Contoh: 5" 
                oninput="validateMeja(this)"
                required
            >
        </div>

        <input type="hidden" name="pembayaran" value="Tunai">

        <input type="hidden" name="cart_detail" id="cart_detail_input">
        <input type="hidden" name="total_bayar" id="total_bayar_input">

        <button type="submit" class="btn-submit">
            Konfirmasi Pesanan (Bayar Tunai)
        </button>

    </form>

    <a href="index.php" class="kembali">← Kembali / Tambah Menu Lain</a>

</div>

<script>
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

        document.getElementById('total-price').innerText = `Rp ${formatRupiah(total)}`;

        document.getElementById('cart_detail_input').value = JSON.stringify(cart);
        document.getElementById('total_bayar_input').value = total;
    }

    function updateQty(index, change) {
        cart[index].qty += change;

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

    function validateMeja(input) {
        if (input.value > 15) {
            input.value = 15;
        } else if (input.value < 1 && input.value !== '') {
            input.value = 1;
        }
    }

    renderCart();
</script>

</body>
</html>