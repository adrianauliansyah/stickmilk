<?php
session_start();

// Data menu sementara
$menus = [
  ["nama" => "Matcha Cloud Milk", "harga" => 15000, "gambar" => "img/matcha.jpg.jpg"],
  ["nama" => "Choco Cloud Milk", "harga" => 18000, "gambar" => "img/coklat.jpg.jpg"],
  ["nama" => "Taro Cloud Milk",  "harga" => 16000, "gambar" => "img/taro.jpg.jpg"],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Menu - StickyMilk Café</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            mint: '#7effa9',
            mintdark: '#059669',
            darkgreen: '#003d29',
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
      <a href="index.php" class="hover:text-mint transition">Home</a>

      <?php if (!isset($_SESSION['login'])): ?>
        <a href="login.php" class="hover:text-mint transition">Login</a>
      <?php else: ?>
        <a href="logout.php" class="hover:text-red-400 transition">Logout</a>
      <?php endif; ?>

      <a href="about.php" class="hover:text-mint transition">About Me</a>
    </nav>
  </header>

  <!-- JUDUL -->
  <h1 class="text-center text-3xl font-bold text-mint mb-10">
    ⚙️ Kelola Menu StickyMilk
  </h1>

  <!-- FORM TAMBAH MENU -->
  <div class="bg-white/10 backdrop-blur-xl p-6 rounded-2xl shadow-glow mb-10 max-w-xl mx-auto">

    <h2 class="text-xl font-semibold text-mint mb-4 text-center">
      Tambah Menu Baru
    </h2>

    <form method="POST" class="flex flex-col gap-3">

      <input type="text" name="nama" placeholder="Nama Menu"
        class="bg-white/20 px-4 py-2 rounded-lg outline-none" required>

      <input type="number" name="harga" placeholder="Harga"
        class="bg-white/20 px-4 py-2 rounded-lg outline-none" required>

      <input type="text" name="gambar" placeholder="Path Gambar (contoh: img/matcha.jpg)"
        class="bg-white/20 px-4 py-2 rounded-lg outline-none" required>

      <button name="tambah"
        class="mt-2 bg-mint text-black font-semibold py-2 rounded-full hover:bg-mintdark transition">
        Tambah Menu
      </button>

    </form>
  </div>

  <!-- LIST MENU -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

    <?php foreach ($menus as $index => $menu): ?>
      <div class="bg-white/10 backdrop-blur-xl p-6 rounded-2xl text-center shadow-glow">

        <img src="<?= $menu['gambar'] ?>"
          class="w-28 h-28 rounded-full mx-auto mb-4 object-cover border-4 border-mint/30">

        <h2 class="text-xl font-semibold"><?= $menu['nama'] ?></h2>

        <p class="text-mint font-bold mt-1">
          Rp <?= number_format($menu['harga']) ?>
        </p>

        <a href="admin.php?hapus=<?= $index ?>"
          class="mt-4 block bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-full font-semibold transition">
          Hapus Menu
        </a>

      </div>
    <?php endforeach; ?>

  </div>

</div>
<!-- =============== END CONTENT =============== -->

<!-- ================= FOOTER ================= -->
<footer class="w-full bg-green-800 text-green-200 py-6 mt-auto">
  <div class="max-w-6xl mx-auto text-center px-4">
    <p class="text-sm font-medium">
      JL. Gatot Subroto • 📞 WA 
      <span class="text-green-300">0857 5803 5644</span>
    </p>
    <p class="mt-1 text-xs opacity-70">
      © <?= date('Y'); ?> Kedai StickyMilk
    </p>
  </div>
</footer>
<!-- =============== END FOOTER =============== -->

</body>
</html>
