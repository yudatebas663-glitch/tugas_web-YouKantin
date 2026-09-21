<?php
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'pembeli') {
    header("Location: login.php");
    exit();
}
$menu_gorengan = [
    [
        "nama" => "Tempe Mendoan", 
        "harga" => 1500, 
        "desc" => "Tempe mendoan hangat khas Jawa Tengah, digoreng setengah matang dengan adonan tepung berbumbu rempah halus dan irisan daun kucai segar. Disajikan pas untuk camilan.",
        "foto" => "https://cdn0-production-images-kly.akamaized.net/mkUcTt_2tgGWvJ7dG_r0fk0OUDs=/0x188:6000x3570/1200x675/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/3526754/original/022519500_1627702430-shutterstock_2012690735.jpg"
    ],
    [
        "nama" => "Tahu Goreng", 
        "harga" => 1500, 
        "desc" => "Tahu isi renyah dengan isian tumisan wortel, tauge, dan daun bawang gurih. Digoreng dengan balutan tepung crispy hingga berwarna kuning keemasan.",
        "foto" => "https://singaporelocalfavourites.com/wp-content/uploads/2017/09/makcik-secret-tahu-goreng-1536x1049.jpg"
    ],
    [
        "nama" => "Bakwan Sayur", 
        "harga" => 1500, 
        "desc" => "Bakwan sayur garing luar dalam berisi paduan iris wortel, kubis, dan kubis segar bersalut adonan rempah lezat. Paling enak disantap saat istirahat sekolah.",
        "foto" => "https://images.genpi.co/uploads/arsip/normal/2022/02/01/bakwan-sayur-foto-cookpad-aoeq.jpg"
    ]
];

$menu_nasi = [
    [
        "nama" => "Nasi Goreng", 
        "harga" => 5000, 
        "desc" => "Nasi goreng bumbu racikan tradisional khas kantin yang gurih dan harum. Disajikan lengkap dengan telur ceplok/dadar, taburan bawang goreng, dan irisan timun segar.",
        "foto" => "https://images.deliveryhero.io/image/fd-my/LH/qs1l-hero.jpg"
    ],
    [
        "nama" => "Nasi Kuning", 
        "harga" => 5000, 
        "desc" => "Nasi kuning harum beraroma santan, serai, dan daun jeruk. Dilengkapi lauk iris telur orek, kering tempe manis gurih, sambal pedas nikmat, serta kerupuk renyah.",
        "foto" => "https://i1.wp.com/blog.duniamasak.com/wp-content/uploads/nasi-kuning.jpg?fit=900%2C520"
    ],
    [
        "nama" => "Mie Goreng", 
        "harga" => 5000, 
        "desc" => "Mie tumis spesial bumbu manis gurih dengan campuran sayuran segar, bakso sapi irisan, dan taburan bawang goreng mekar. Porsi pas penambah energi.",
        "foto" => "https://media.istockphoto.com/id/1456194878/photo/mie-goreng-udang-or-bakmi-goreng-sea-food-or-fried-noodle-with-sea-food-indonesian-food-and.jpg?s=170667a&w=0&k=20&c=I5Oq-s7SlxXS7kpr6GSU1BXwOP71q32262ZX1VY_WCo="
    ]
];

$menu_minuman = [
    [
        "nama" => "Es Teh", 
        "harga" => 3000, 
        "desc" => "Seduhan teh Melati asli yang diseduh pekat dan manis, disajikan dingin dengan es batu melimpah. Sangat efektif menyegarkan dahaga setelah beraktivitas.",
        "foto" => "https://asset.kompas.com/crops/VEMd5H4lRZYH6QAc3zr0b003UfU=/0x0:880x587/1200x800/data/photo/2023/08/16/64dc53ca9f3db.jpg"
    ],
    [
        "nama" => "Es Milo", 
        "harga" => 5000, 
        "desc" => "Minuman rasa cokelat malt Milo kental dipadu susu manis lezat dan es batu dingin. Memberikan tambahan energi gizi penuh rasa cokelat favorit siswa.",
        "foto" => "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiS6u_DOM9FDMglxcDJoCcWWWxrI55oaiNurQ1FwgOB7OmGuZuOu7gzCOj3wBSEZEvQNazdyjbQA1cnaAhtO6CLhbxQVnEw27Jw0-JKN5Sh9ejbFL81GCZl_wZ9TyF_POZfPlyxD0LKom0Ip4z7vE1DXUk2_g8RXRrKykPhYoQKjzuitWiHp1Y5dk-5fA/s720/lg_5eb8e07fea50d.jpg"
    ],
    [
        "nama" => "Es Cincau", 
        "harga" => 3500, 
        "desc" => "Minuman es cincau hijau/hitam alami dipadu dengan siraman gula merah cair dan santan gurih. Rasanya legit, menyegarkan, dan menyehatkan tubuh.",
        "foto" => "https://i.pinimg.com/originals/95/34/52/95345216171219e6d3e7cc9deba9f951.jpg"
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
  <center>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YouKantin - SMKN 1 TEBAS</title>
  <link rel="stylesheet" href="style.css?v=7.0">
  <style>
    .app-container-full {
      width: 100%;
      padding: 24px 40px;
      box-sizing: border-box;
    }
    .card-grid-pc {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 24px;
    }
    .card-item-photo {
      background: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid #e2e8f0;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .card-item-photo:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }
    .card-img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .card-body {
      padding: 16px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      flex-grow: 1;
    }
  </style>
</head>
</center>

<center>
<body>

  <div class="app-container-full">
    <header class="hero-card" style="display: flex; justify-content: space-between; align-items: center; padding: 28px 36px;">
      <div>
        <p class="subtitle">SELAMAT DATANG DI</p>
        <h1 class="brand-title" style="font-size: 32px;">YouKantin</h1>
        <p class="tagline">KANTIN DIGITAL LOGISTIK & PEMESANAN · SMKN 1 TEBAS</p>
      </div>
      <div style="text-align: right; background: rgba(255,255,255,0.12); padding: 14px 24px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.2);">
        <p style="font-size: 14px; margin-bottom: 6px; color: #f8fafc;">Pembeli: <strong><?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? $_SESSION['username']); ?></strong></p>
        <a href="logout.php" class="btn-logout-head">Keluar (Logout)</a>
      </div>
    </header>

    <main>
      <h2 class="section-title">🍿 GORENGAN</h2>
      <div class="card-grid-pc">
        <?php foreach ($menu_gorengan as$item): ?>
          <div class="card-item-photo">
            <img src="<?php echo $item['foto']; ?>" alt="<?php echo $item['nama']; ?>" class="card-img">
            <div class="card-body">
              <div>
                <h3 style="font-size: 18px; color: #0f172a; margin-bottom: 6px;"><?php echo $item['nama']; ?></h3>
                <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 12px;"><?php echo $item['desc']; ?></p>
              </div>
              <div>
                <p class="price" style="font-size: 16px; font-weight: 700; color: #2563eb; margin-bottom: 10px;">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                <button class="btn-add" onclick="addToCart('<?php echo htmlspecialchars($item['nama'], ENT_QUOTES); ?>', <?php echo$item['harga']; ?>)">+ Tambah Pesanan</button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <h2 class="section-title" style="margin-top: 36px;">🍙 NASI & MIE</h2>
      <div class="card-grid-pc">
        <?php foreach ($menu_nasi as$item): ?>
          <div class="card-item-photo">
            <img src="<?php echo $item['foto']; ?>" alt="<?php echo $item['nama']; ?>" class="card-img">
            <div class="card-body">
              <div>
                <h3 style="font-size: 18px; color: #0f172a; margin-bottom: 6px;"><?php echo $item['nama']; ?></h3>
                <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 12px;"><?php echo $item['desc']; ?></p>
              </div>
              <div>
                <p class="price" style="font-size: 16px; font-weight: 700; color: #2563eb; margin-bottom: 10px;">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                <button class="btn-add" onclick="addToCart('<?php echo htmlspecialchars($item['nama'], ENT_QUOTES); ?>', <?php echo$item['harga']; ?>)">+ Tambah Pesanan</button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <h2 class="section-title" style="margin-top: 36px;">🥤 MINUMAN</h2>
      <div class="card-grid-pc">
        <?php foreach ($menu_minuman as$item): ?>
          <div class="card-item-photo">
            <img src="<?php echo $item['foto']; ?>" alt="<?php echo $item['nama']; ?>" class="card-img">
            <div class="card-body">
              <div>
                <h3 style="font-size: 18px; color: #0f172a; margin-bottom: 6px;"><?php echo $item['nama']; ?></h3>
                <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 12px;"><?php echo $item['desc']; ?></p>
              </div>
              <div>
                <p class="price" style="font-size: 16px; font-weight: 700; color: #2563eb; margin-bottom: 10px;">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                <button class="btn-add" onclick="addToCart('<?php echo htmlspecialchars($item['nama'], ENT_QUOTES); ?>', <?php echo$item['harga']; ?>)">+ Tambah Pesanan</button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </main>
  </div>

  <div class="cart-bar-floating" style="padding: 16px 40px;">
    <div class="cart-info-text" id="cart-summary" style="font-size: 16px;">0 Item dimasukkan ke keranjang</div>
    <form action="proses_bayar.php" method="POST">
      <input type="hidden" name="cart_data" id="cart_data_input">
      <button type="submit" id="btn-checkout" class="btn-checkout" style="padding: 12px 30px; font-size: 15px;" disabled>Lihat Nota Pesanan ➔</button>
    </form>
  </div>

  <script>
    let cart = JSON.parse(localStorage.getItem('youkantin_cart')) || [];

    function addToCart(title, price) {
      const existing = cart.find(item => item.title === title);
      if (existing) {
        existing.qty += 1;
      } else {
        cart.push({ title, price, qty: 1 });
      }
      saveAndUpdate();
    }

    function saveAndUpdate() {
      localStorage.setItem('youkantin_cart', JSON.stringify(cart));
      const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
      document.getElementById('cart-summary').innerText = `${totalQty} Item dimasukkan ke keranjang`;
      document.getElementById('btn-checkout').disabled = cart.length === 0;
      document.getElementById('cart_data_input').value = JSON.stringify(cart);
    }

    saveAndUpdate();
  </script>
</body>
        </center>
</html>

