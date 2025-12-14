<?php
session_start();

// HAPUS pesanan berdasarkan index
if (isset($_GET['hapus'])) {
  $index = $_GET['hapus'];
  if (isset($_SESSION["order"][$index])) {
    unset($_SESSION["order"][$index]);
    $_SESSION["order"] = array_values($_SESSION["order"]);
  }
}

// Ambil data POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $_SESSION["order"][] = [
    "menu" => $_POST["menu"],
    "harga" => $_POST["harga"],
    "pemesan" => $_POST["pemesan"],
    "catatan" => $_POST["catatan"],
    "waktu" => date("H:i / d-m-Y")
  ];
  $success = true;
} else {
  $success = false;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order - StickyMilk</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            mint: '#7effa9',
            mintdark: '#059669',
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

  <h1 class="text-3xl font-bold text-mint text-center mb-8">
    📦 Daftar Pesanan
  </h1>

  <!-- POPUP SUCCESS -->
  <?php if ($success): ?>
    <div class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
      <div class="bg-white/10 p-6 rounded-2xl text-center w-72">
        <h2 class="text-xl font-bold text-mint mb-3">Pesanan Berhasil!</h2>
        <p class="mb-4">Pesanan kamu sudah masuk 🎉</p>
        <button onclick="this.parentElement.parentElement.style.display='none'"
          class="bg-mint text-black px-5 py-2 rounded-full font-semibold">
          Tutup
        </button>
      </div>
    </div>
  <?php endif; ?>

  <!-- LIST ORDER -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <?php if (!empty($_SESSION["order"])): ?>
      <?php foreach ($_SESSION["order"] as $i => $o): ?>
        <div class="bg-white/10 rounded-xl p-4 shadow">
          <h2 class="text-lg font-bold text-mint"><?= $o['menu'] ?></h2>
          <p>Harga: Rp <?= number_format($o['harga']) ?></p>
          <p>Pemesan: <b><?= $o['pemesan'] ?></b></p>
          <p class="text-sm opacity-80">Catatan: <?= $o['catatan'] ?: "-" ?></p>
          <p class="text-xs opacity-60 mt-2"><?= $o['waktu'] ?></p>

          <a href="order.php?hapus=<?= $i ?>"
             class="inline-block mt-3 bg-red-500 px-3 py-1 rounded-lg text-sm hover:bg-red-700">
            Hapus
          </a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="col-span-full text-center">Belum ada pesanan</p>
    <?php endif; ?>
  </div>

  <div class="text-center mt-10">
    <a href="menu.php" class="px-6 py-3 bg-mint text-black rounded-full font-semibold">
      Kembali ke Menu
    </a>
  </div>

</div>
<!-- =============== END CONTENT =============== -->

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
