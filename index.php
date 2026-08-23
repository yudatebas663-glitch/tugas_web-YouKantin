<?php
// Data Menu YouKantin
$menu_gorengan = [
    [
        "nama" => "Tempe Mendoan",
        "harga" => 1500,
        "gambar" => "tempe.jpg",
        "laris" => true
    ],
    [
        "nama" => "Tahu Goreng",
        "harga" => 1500,
        "gambar" => "tahu isi.jpg",
        "laris" => false
    ],
    [
        "nama" => "Bakwan Sayur",
        "harga" => 1500,
        "gambar" => "maxresdefault.jpg",
        "laris" => true
    ]
];

$menu_nasi = [
    [
        "nama" => "Nasi Goreng",
        "harga" => 5000,
        "gambar" => "Nasi-Goreng-telor.jpg",
        "desc" => "Nasi goreng adalah hidangan nasi yang ditumis dengan bumbu-bumbu, kecap manis, dan aneka isian, menghasilkan cita rasa gurih, sedikit manis, dan beraroma khas"
    ],
    [
        "nama" => "Nasi Kuning",
        "harga" => 5000,
        "gambar" => "pngtree-indonesian-food-yellow-rice-png-image_6657257.jpg",
        "desc" => "Nasi kuning adalah hidangan nasi khas Indonesia yang dimasak dengan kunyit, santan, dan rempah-rempah, menghasilkan rasa gurih, wangi, dan warna kuning yang khas"
    ],
    [
        "nama" => "Mie Goreng",
        "harga" => 5000,
        "gambar" => "resep-bakmi-goreng-kemiri.jpeg",
        "desc" => "Mie goreng adalah hidangan mi tumis berumbu gurih-manis yang disajikan dengan aneka isian seperti telur, sayuran, dan daging."
    ]
];

$menu_minuman = [
    [
        "nama" => "Es Teh",
        "harga" => 3000,
        "gambar" => "images.jpg",
        "desc" => "Es teh adalah minuman seduhan teh dingin yang manis, segar, dan cocok dipadukan dengan makanan apa saja"
    ],
    [
        "nama" => "Es Milo",
        "harga" => 5000,
        "gambar" => "fa5d395078f21ce0e38f2bf1269fb5a4.jpg",
        "desc" => "Es Milo adalah minuman cokelat malt dingin yang manis, gurih, dan menyegarkan"
    ],
    [
        "nama" => "Es Cincau",
        "harga" => 3500,
        "gambar" => "4e270a3bc8f1b014e887baecbc359b17.jpg",
        "desc" => "Es cincau adalah minuman dingin berisi potongan cincau yang disiram kuah santan atau susu dan gula merah, memberikan sensasi segar, kenyal, dan manis alami"
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YouKantin - Angkringan Digital</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <style>
    /* Styling Floating Bar Keranjang Belanja */
    .cart-bar-floating {
      position: fixed;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 100%;
      max-width: 480px;
      background: #ffffff;
      padding: 12px 20px;
      box-shadow: 0 -5px 25px rgba(0,0,0,0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-sizing: border-box;
      border-top-left-radius: 18px;
      border-top-right-radius: 18px;
      z-index: 999;
    }
    .cart-info { display: flex; flex-direction: column; }
    .cart-info small { color: #666; font-size: 0.75rem; }
    .cart-info-text { font-weight: 700; font-size: 0.95rem; color: #1a1a1a; }
    .btn-checkout {
      background: #e63946;
      color: #fff;
      border: none;
      padding: 10px 18px;
      border-radius: 10px;
      font-weight: 700;
      cursor: pointer;
      transition: 0.2s;
    }
    .btn-checkout:disabled { background: #ccc; cursor: not-allowed; }
    
    /* Styling Tambahan untuk Tab Kategori */
    .category-tabs {
      display: flex;
      gap: 10px;
      overflow-x: auto;
      padding: 10px 15px;
      background: #fff;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .tab-btn {
      padding: 8px 16px;
      border: 1px solid #ddd;
      background: #f8f9fa;
      border-radius: 20px;
      font-weight: 600;
      cursor: pointer;
      white-space: nowrap;
      transition: all 0.2s ease;
    }
    .tab-btn.active {
      background: #e63946;
      color: #fff;
      border-color: #e63946;
    }

    body { padding-bottom: 80px; }
  </style>
</head>
<body>

  <div class="app-container">
    <header class="hero-card">
      <div class="hero-overlay"></div>
      <div class="hero-content">
        <p class="subtitle">SELAMAT DATANG DI</p>
        <h1 class="brand-title">YouKantin</h1>
        <p class="tagline">JAJANAN DIGITAL · EST. <?php echo date('Y'); ?></p>
        <div class="divider">◆ ◆ ◆</div>

        <div class="info-bar">
          <div class="info-item">
            <span class="icon">🕒</span>
            <div class="label">Buka</div>
            <div class="value">06.00 - 15.00</div>
          </div>
          <div class="info-item">
            <span class="icon">📍</span>
            <div class="label">Lokasi</div>
            <div class="value">Kantin SMKN 1 TEBAS</div>
          </div>
          <div class="info-item">
            <span class="icon">🪑</span>
            <div class="label">Meja</div>
            <div class="value">15 tersedia</div>
          </div>
        </div>
      </div>
    </header>

    <!-- Kategori Tab dengan data-category yang sudah disesuaikan -->
    <nav class="category-tabs">
      <button class="tab-btn active" data-category="all">🛍️ Semua</button>
      <button class="tab-btn" data-category="gorengan">🍿 Gorengan</button>
      <button class="tab-btn" data-category="nasi">🍙 Nasi & Mie</button>
      <button class="tab-btn" data-category="minuman">🥤 Minuman</button>
    </nav>

    <main id="menu-container">
      
      <!-- SECTION GORENGAN -->
      <section class="menu-section" id="section-gorengan">
        <div class="section-header">
          <h2>🍿 GORENGAN</h2>
          <a href="#" class="see-all">lihat semua ➔</a>
        </div>
        <div class="horizontal-scroll">
          <div class="card-grid-horizontal">
            <?php foreach ($menu_gorengan as $item): ?>
              <div class="card-item card-vertical">
                <div class="img-wrapper">
                  <img src="<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama']; ?>">
                  <?php if ($item['laris']): ?>
                    <span class="badge-laris">🔥 LARIS</span>
                  <?php endif; ?>
                </div>
                <div class="card-body">
                  <h3><?php echo $item['nama']; ?></h3>
                  <div class="card-footer">
                    <span class="price">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></span>
                    <button class="btn-add" onclick="addToCart('<?php echo htmlspecialchars($item['nama'], ENT_QUOTES); ?>', <?php echo $item['harga']; ?>)">+</button>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- SECTION NASI & MIE -->
      <section class="menu-section" id="section-nasi">
        <div class="section-header">
          <h2>🍙 NASI & MIE</h2>
          <a href="#" class="see-all">lihat semua ➔</a>
        </div>
        <div class="card-list-vertical">
          <?php foreach ($menu_nasi as $item): ?>
            <div class="card-item card-horizontal">
              <img src="<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama']; ?>">
              <div class="card-info">
                <h3><?php echo $item['nama']; ?></h3>
                <p class="desc"><?php echo $item['desc']; ?></p>
                <span class="price">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?> <small>/ bungkus</small></span>
              </div>
              <button class="btn-add" onclick="addToCart('<?php echo htmlspecialchars($item['nama'], ENT_QUOTES); ?>', <?php echo $item['harga']; ?>)">+</button>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- SECTION MINUMAN -->
      <section class="menu-section" id="section-minuman">
        <div class="section-header">
          <h2>🥤 MINUMAN</h2>
          <a href="#" class="see-all">lihat semua ➔</a>
        </div>
        <div class="card-list-vertical">
          <?php foreach ($menu_minuman as $item): ?>
            <div class="card-item card-horizontal">
              <img src="<?php echo $item['gambar']; ?>" alt="<?php echo $item['nama']; ?>">
              <div class="card-info">
                <h3><?php echo $item['nama']; ?></h3>
                <p class="desc"><?php echo $item['desc']; ?></p>
                <span class="price">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></span>
              </div>
              <button class="btn-add" onclick="addToCart('<?php echo htmlspecialchars($item['nama'], ENT_QUOTES); ?>', <?php echo $item['harga']; ?>)">+</button>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

    </main>
  </div>

  <!-- Bottom Floating Bar Keranjang -->
  <div class="cart-bar-floating">
    <div class="cart-info">
      <small>Total Belanjaan:</small>
      <div id="cart-summary" class="cart-info-text">0 Menu (0 Item)</div>
    </div>
    
    <form action="nota.php" method="POST">
      <input type="hidden" name="cart_data" id="cart_data_input">
      <button type="submit" id="btn-checkout" class="btn-checkout" disabled>Lihat Nota ➔</button>
    </form>
  </div>

  <script>
    // --- 1. SCRIPT UNTUK KLIK TOMBOL TAB KATEGORI ---
    document.addEventListener("DOMContentLoaded", function() {
      const tabButtons = document.querySelectorAll(".tab-btn");
      const sections = {
        gorengan: document.getElementById("section-gorengan"),
        nasi: document.getElementById("section-nasi"),
        minuman: document.getElementById("section-minuman")
      };

      tabButtons.forEach(button => {
        button.addEventListener("click", function() {
          // Hilangkan status active dari semua tombol
          tabButtons.forEach(btn => btn.classList.remove("active"));
          // Tambahkan status active ke tombol yang dipencet
          this.classList.add("active");

          const category = this.getAttribute("data-category");

          if (category === "all") {
            // Tampilkan semua kategori
            Object.values(sections).forEach(sec => {
              if (sec) sec.style.display = "block";
            });
          } else {
            // Sembunyikan semua section dulu
            Object.values(sections).forEach(sec => {
              if (sec) sec.style.display = "none";
            });
            // Tampilkan section yang dipilih
            if (sections[category]) {
              sections[category].style.display = "block";
            }
          }
        });
      });
    });

    // --- 2. SCRIPT MANAJEMEN KERANJANG BELANJA ---
    let cart = [];

    try {
      const storedCart = JSON.parse(localStorage.getItem('youkantin_cart'));
      if (Array.isArray(storedCart)) {
        cart = storedCart.filter(item =>
          item && typeof item.title === 'string' &&
          Number.isFinite(Number(item.price)) && Number(item.qty) > 0
        ).map(item => ({
          title: item.title,
          price: Number(item.price),
          qty: Math.floor(Number(item.qty))
        }));
      }
    } catch (error) {
      localStorage.removeItem('youkantin_cart');
    }

    function addToCart(title, price) {
      const existingIndex = cart.findIndex(item => item.title === title);

      if (existingIndex > -1) {
        cart[existingIndex].qty += 1;
      } else {
        cart.push({ title: title, price: price, qty: 1 });
      }

      saveAndUpdateUI();
    }

    function saveAndUpdateUI() {
      localStorage.setItem('youkantin_cart', JSON.stringify(cart));
      
      const totalJenisMenu = cart.length;
      const totalQtyItem = cart.reduce((sum, item) => sum + item.qty, 0);
      
      document.getElementById('cart-summary').innerText = `${totalJenisMenu} Menu (${totalQtyItem} Item)`;
      
      const checkoutBtn = document.getElementById('btn-checkout');
      checkoutBtn.disabled = cart.length === 0;

      document.getElementById('cart_data_input').value = JSON.stringify(cart);
    }

    saveAndUpdateUI();
  </script>
</body>
</html>