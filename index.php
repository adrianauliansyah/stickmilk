<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StickyMilk - Matcha Mint</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            matcha: '#a8e063',
            mint: '#b3ffcc',
            mintdark: '#59c68f',
            neonmint: '#7effa9',
          },
          boxShadow: {
            glow: '0 0 25px rgba(127, 255, 169, 0.5)',
          },
        },
      },
    };
  </script>

  <style>
    body {
      background: radial-gradient(circle at 20% 20%, #004d3d, #004d3d 90%);
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }
  </style>
</head>

<body class="min-h-screen flex flex-col">

  <!-- CONTENT WRAPPER (PAKAI PADDING) -->
  <div class="flex-grow p-6 text-center">

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
    <!-- END NAVBAR -->

    <!-- MAIN -->
    <main>
      <div class="relative bg-white/20 backdrop-blur-2xl shadow-glow border border-mint/40 rounded-3xl p-10 max-w-2xl w-full mx-auto">

        <img src="img/milklogo.jpg.jpeg" class="w-32 mx-auto drop-shadow-2xl mb-5">

        <h1 class="text-4xl font-extrabold text-neonmint">
          Selamat Datang di Kedai StickyMilk
        </h1>

        <p class="text-white/90 mt-3">
          Rasakan kesegaran yang melekat di tiap tegukan StickyMilk ✨
        </p>

        <div class="mt-8 flex flex-col gap-4">
          <a href="menu.php" class="bg-neonmint text-gray-900 font-bold py-3 rounded-xl shadow-glow">
            🍹 Lihat Menu
          </a>
          <a href="status.php" class="bg-white/60 text-mintdark font-bold py-3 rounded-xl">
            📦 Status Pesanan
          </a>
        </div>
        <!-- Admin Section --> <div class="mt-10 border-t border-mint/30 pt-4"> <p class="text-sm text-white/70 mb-3 font-medium">👩‍💻 Khusus Admin</p> <div class="flex flex-col gap-3"> <a href="admin.php" class="w-full bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 rounded-lg transition-all hover:shadow-glow"> Kelola Menu </a> <a href="pesanan.php" class="w-full bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 rounded-lg transition-all hover:shadow-glow"> Daftar Pesanan </a> </div> </div> </div> </main> <!-- END MAIN -->
      </div>
    </main>

  </div>
  <!-- END CONTENT WRAPPER -->

  <!-- FOOTER -->
<footer class="w-full bg-green-800 text-green-200 py-4">

  <div class="max-w-6xl mx-auto text-center px-4">
    <h2 class="text-lg font-bold text-green-300">

    </h2>

    <p class="text-xs opacity-80 mt-1">
      
    </p>

    <p class="text-sm font-medium mt-1">
     JL.Gatot Subroto | 📞 WA: <span class="text-green-300">0857 5803 5644</span>
    </p>

    <div class="mt-2 text-xs opacity-70">
      © <?= date('Y'); ?> Kedai StickyMilk
    </div>
  </div>

</footer>
<!-- END FOOTER -->


</body>
</html>
