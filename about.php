<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Me - StickyMilk Café</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            mint: '#7effa9',
            mintdark: '#059669',
            darkgreen: '#003d29',
          }
        }
      }
    }
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

  <!-- HEADER -->
  <header class="flex justify-between items-center mb-10">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-full bg-mintdark"></div>
      <h1 class="text-2xl font-bold text-mint">Kedai StickyMilk</h1>
    </div>

    <nav class="flex gap-6 text-white text-lg">
      <a href="index.php" class="hover:text-mint">Home</a>

      <?php if (!isset($_SESSION['login'])): ?>
        <a href="login.php" class="hover:text-mint">Login</a>
      <?php else: ?>
        <a href="logout.php" class="hover:text-mint">Logout</a>
      <?php endif; ?>

      <a href="about.php" class="hover:text-mint">About Me</a>
    </nav>
  </header>

  <!-- ABOUT CARD -->
  <div class="bg-white/10 backdrop-blur-xl p-8 rounded-3xl max-w-2xl mx-auto border border-white/20 shadow-xl">

    <h2 class="text-3xl font-bold text-center text-mint mb-4">
      Tentang StickyMilk Café
    </h2>

    <p class="text-lg leading-relaxed mb-4">
      StickyMilk Café adalah kedai minuman modern yang menghadirkan berbagai menu berbasis susu,
      matcha, coklat, dan minuman kekinian lainnya.
    </p>

    <p class="text-lg leading-relaxed mb-4">
      Website ini dibuat sebagai project sederhana untuk menampilkan daftar menu, pemesanan,
      serta sistem login yang mudah digunakan.
    </p>

    <p class="text-mint text-lg font-semibold text-center">
      Terima kasih sudah berkunjung! 💚
    </p>

    <div class="text-center mt-6">
      <a href="menu.php"
         class="bg-mintdark px-6 py-2 rounded-xl text-white hover:bg-mint transition">
        Kembali ke Menu
      </a>
    </div>

  </div>

</div>
<!-- =============== END CONTENT =============== -->

<!-- ================= FOOTER ================= -->
<footer class="w-full bg-green-800 text-green-200 py-4 mt-auto">
  <div class="text-center text-sm">
    JL. Gatot Subroto. | WA
    <span class="text-green-300">0857 5803 5644</span><br>
    © <?= date('Y'); ?> Kedai StickyMilk
  </div>
</footer>
<!-- =============== END FOOTER =============== -->

</body>
</html>
