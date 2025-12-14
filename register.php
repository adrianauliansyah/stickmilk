<?php
session_start();
include "koneksi.php";

$error = "";
$success_redirect = false;

if (isset($_POST['register'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($password !== $confirm) {
        $error = "Password tidak sama!";
    } else {
        // 1. Cek email sudah ada atau belum
        $cek = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($cek, "s", $email);
        mysqli_stmt_execute($cek);
        mysqli_stmt_store_result($cek);

        if (mysqli_stmt_num_rows($cek) > 0) {
            $error = "Email sudah terdaftar!";
            // Statement $cek akan ditutup di akhir blok besar.
        } else {
            // 2. Insert data baru
            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO users (email, password) VALUES (?, ?)" 
            );
            mysqli_stmt_bind_param($stmt, "ss", $email, $password);

            if (mysqli_stmt_execute($stmt)) {
                // Pendaftaran BERHASIL! Kita set variabel sukses.
                $success_redirect = true; 
                // Statement $stmt ditutup setelah berhasil.
                mysqli_stmt_close($stmt); 
                
            } else {
                $error = "Gagal mendaftar! " . mysqli_error($conn);
                // Statement $stmt ditutup setelah gagal.
                mysqli_stmt_close($stmt); 
            }
        }
        // Statement $cek (SELECT) ditutup setelah selesai digunakan. 
        // Ini adalah Baris 49 yang seharusnya (atau di sekitar baris 49)
        mysqli_stmt_close($cek); 
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun - StickyMilk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-900 min-h-screen flex flex-col">

<header class="flex justify-between items-center px-4 py-4 bg-green-800 shadow-md">
  <div class="flex items-center gap-3">
    <img src="img/milklogo.jpg.jpeg" class="w-12 h-12 rounded-full shadow-lg">
    <h1 class="text-2xl font-bold text-green-200">Kedai StickyMilk</h1>
  </div>

  <nav class="flex gap-6 text-white font-semibold text-lg">
    <a href="index.php" class="hover:text-green-300 transition">Home</a>
    <a href="login.php" class="hover:text-green-300 transition">Login</a>
    <a href="about.php" class="hover:text-green-300 transition">About Me</a>
  </nav>
</header>
<?php if ($success_redirect): ?>
<div id="popupBox"
     class="fixed top-10 left-1/2 -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-xl shadow-xl font-semibold text-lg opacity-0 transition-opacity duration-500 z-50">
  ✔ Pendaftaran Berhasil! Mengalihkan ke halaman Login...
</div>

<script>
  // Tampilkan popup
  setTimeout(() => {
    document.getElementById("popupBox").classList.remove("opacity-0");
  }, 50);

  // Tunggu 2 detik, lalu redirect ke login.php
  setTimeout(() => {
    window.location.href = "login.php?status=success_register";
  }, 2000); 
</script>
<?php endif; ?>
<main class="flex-grow flex items-center justify-center px-4">
  <div class="bg-white/20 backdrop-blur-xl p-8 rounded-3xl shadow-lg w-full max-w-md border border-green-300">

    <h2 class="text-3xl text-center text-green-200 font-bold mb-6">
      Daftar Akun StickyMilk
    </h2>

    <?php if ($error): ?>
      <p class="text-red-300 text-center mb-3 font-semibold">
        <?= htmlspecialchars($error) ?>
      </p>
    <?php endif; ?>

    <form method="POST" class="flex flex-col gap-4">
      <input type="email" name="email" placeholder="Masukkan Gmail" required
             class="p-3 rounded-xl bg-white/60 focus:bg-white outline-none"
             value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"> 

      <input type="password" name="password" placeholder="Password" required
             class="p-3 rounded-xl bg-white/60 focus:bg-white outline-none">

      <input type="password" name="confirm" placeholder="Konfirmasi Password" required
             class="p-3 rounded-xl bg-white/60 focus:bg-white outline-none">

      <button type="submit" name="register"
              class="bg-green-400 hover:bg-green-500 text-white font-bold py-3 rounded-xl transition-all">
        Daftar
      </button>

      <p class="text-center text-white/80 text-sm">
        Sudah punya akun?
        <a href="login.php" class="text-green-300 font-semibold hover:underline">
          Login
        </a>
      </p>
    </form>
  </div>
</main>
<footer class="bg-green-800 text-green-200 py-6 w-full mt-auto">
  <div class="text-center">
    <p class="font-semibold">JL. Gatot Subroto | CP: 0857 5803 5644</p>
    <p class="text-sm opacity-80">© <?= date('Y'); ?> Kedai StickyMilk</p>
  </div>
</footer>
</body>
</html>