<?php
session_start();

$menus = [
  [
    "nama" => "Matcha Cloud Milk",
    "harga" => 15000,
    "gambar" => "img/matcha.jpg.jpg",
    "desc"  => "Minuman matcha premium dengan susu creamy dan foam lembut."
  ],
  [
    "nama" => "Choco Cloud Milk",
    "harga" => 18000,
    "gambar" => "img/coklat.jpg.jpg",
    "desc"  => "Coklat pekat dengan susu segar dan tekstur lembut."
  ],
  [
    "nama" => "Taro Cloud Milk",
    "harga" => 16000,
    "gambar" => "img/taro.jpg.jpg",
    "desc"  => "Minuman taro lembut dengan aroma khas dan susu creamy."
  ],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu - StickyMilk Café</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    function toggleDesc(btn) {
      const desc = btn.nextElementSibling;
      desc.classList.toggle("hidden");
      btn.textContent = desc.classList.contains("hidden")
        ? "Lihat Deskripsi ▼"
        : "Tutup Deskripsi ▲";
    }

    function openOrderPopup(nama, harga) {
      document.getElementById("popup").classList.remove("hidden");
      document.getElementById("popupItem").innerText =
        nama + " - Rp " + harga.toLocaleString();

      document.getElementById("menuNama").value = nama;
      document.getElementById("menuHarga").value = harga;
    }

    function closePopup() {
      document.getElementById("popup").classList.add("hidden");
    }

    tailwind.config = {
      theme: {
        extend: {
          colors: {
            mint: '#7effa9',
            mintdark: '#059669',
          },
          boxShadow: {
            glow: '0 0 25px rgba(126,255,169,0.4)',
          },
        },
      },
    };
  </script>

  <style>
    body {
      background: radial-gradient(circle at 20% 20%, #003d29, #000);
      font-family: "Poppins", sans-serif;
      color: white;
    }
  </style>
</head>

<body class="min-h-screen flex flex-col">

<!-- ================= CONTENT ================= -->
<div class="flex-grow p-10">

  <!-- NAVBAR -->
  <header class="flex justify-between items-center mb-12 px-4">
    <div class="flex items-center gap-3">
      <img src="img/milklogo.jpg.jpeg" class="w-12 h-12 rounded-full shadow-lg">
      <h1 class="text-2xl font-bold text-mint">Kedai StickyMilk</h1>
    </div>

    <nav class="flex gap-6 text-white/90 font-semibold text-lg">
      <a href="index.php" class="hover:text-mint">Home</a>
      <a href="about.php" class="hover:text-mint">About Me</a>
    </nav>
  </header>

  <!-- JUDUL -->
  <h1 class="text-center text-3xl font-bold text-mint mb-10">
    🍵 Menu Favorit StickyMilk
  </h1>

  <!-- CARD MENU -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
    <?php foreach ($menus as $menu): ?>
      <div class="bg-white/10 backdrop-blur-xl p-6 rounded-2xl text-center shadow-glow">

        <img src="<?= $menu['gambar'] ?>"
             class="w-28 h-28 rounded-full mx-auto mb-4 object-cover border-4 border-mint/30">

        <button onclick="toggleDesc(this)"
                class="text-white/70 text-sm underline mb-2 hover:text-mint">
          Lihat Deskripsi ▼
        </button>

        <p class="hidden text-white/80 text-sm bg-white/5 p-3 rounded-xl mb-3">
          <?= $menu['desc'] ?>
        </p>

        <h2 class="text-xl font-semibold"><?= $menu['nama'] ?></h2>
        <p class="text-mint font-bold mt-1">
          Rp <?= number_format($menu['harga']) ?>
        </p>

        <button
          onclick="openOrderPopup('<?= $menu['nama'] ?>', <?= $menu['harga'] ?>)"
          class="mt-4 bg-mint text-black px-5 py-2 rounded-full font-semibold hover:bg-mintdark">
          Pesan Sekarang
        </button>

      </div>
    <?php endforeach; ?>
  </div>

</div>
<!-- =============== END CONTENT =============== -->

<!-- ================= POPUP PESANAN ================= -->
<div id="popup" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50">
  <div class="bg-white/10 backdrop-blur-xl p-6 rounded-2xl w-80 shadow-glow">

    <h2 class="text-xl font-bold text-mint mb-2">Konfirmasi Pesanan</h2>
    <p id="popupItem" class="text-white mb-4"></p>

    <form action="order.php" method="POST">
      <input type="hidden" id="menuNama" name="menu">
      <input type="hidden" id="menuHarga" name="harga">

      <label class="text-sm">Nama Pemesan</label>
      <input name="pemesan" required
             class="w-full mt-1 mb-3 px-3 py-2 rounded-lg bg-white/20 outline-none">

      <label class="text-sm">Catatan</label>
      <textarea name="catatan"
                class="w-full mt-1 mb-4 px-3 py-2 rounded-lg bg-white/20 outline-none"></textarea>

      <div class="flex justify-between">
        <button type="button" onclick="closePopup()"
                class="px-4 py-2 bg-gray-300 text-black rounded-full">
          Batal
        </button>
        <button class="px-4 py-2 bg-mint text-black rounded-full">
          Pesan
        </button>
      </div>
    </form>

  </div>
</div>
<!-- =============== END POPUP =============== -->

<!-- ================= FOOTER ================= -->
<footer class="w-full bg-green-800 text-green-200 py-4 mt-auto">
  <div class="text-center text-sm">
    JL. Gatot Subroto • WA <span class="text-green-300">0857 5803 5644</span><br>
    © <?= date('Y'); ?> Kedai StickyMilk
  </div>
</footer>
<!-- =============== END FOOTER =============== -->

</body>
</html>