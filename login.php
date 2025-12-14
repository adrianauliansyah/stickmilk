<?php
session_start();
include "koneksi.php";

$showPopup = false;
$error = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT id, email, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        $error = "Query gagal dibuat: " . mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if ($res && mysqli_num_rows($res) === 1) {
            $row = mysqli_fetch_assoc($res);

            if ($password === $row['password']) {
                $_SESSION['login'] = true;
                $_SESSION['email'] = $row['email'];
                $showPopup = true;
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Email tidak ditemukan!";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - StickyMilk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-900 min-h-screen flex flex-col">

<!-- NAVBAR -->
<header class="flex justify-between items-center px-4 py-4 bg-green-800 shadow-md">
  <div class="flex items-center gap-3">
    <img src="img/milklogo.jpg.jpeg" class="w-12 h-12 rounded-full shadow-lg">
    <h1 class="text-2xl font-bold text-green-200">Kedai StickyMilk</h1>
  </div>

  <nav class="flex gap-6 text-white font-semibold text-lg">
    <a href="index.php" class="hover:text-green-300 transition">Home</a>

    <?php if (!isset($_SESSION['login'])): ?>
      <a href="login.php" class="hover:text-green-300 transition">Login</a>
    <?php else: ?>
      <a href="logout.php" class="hover:text-red-400 transition">Logout</a>
    <?php endif; ?>

    <a href="about.php" class="hover:text-green-300 transition">About Me</a>
  </nav>
</header>
<!-- END NAVBAR -->

<?php if ($showPopup): ?>
<div id="popupBox"
     class="fixed top-10 left-1/2 -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-xl shadow-xl font-semibold text-lg opacity-0 transition-opacity duration-500">
  ✔ Login Berhasil
</div>

<script>
  setTimeout(() => {
    document.getElementById("popupBox").classList.remove("opacity-0");
  }, 50);
  setTimeout(() => {
    window.location.href = "index.php";
  }, 1500);
</script>
<?php endif; ?>

<!-- MAIN CONTENT -->
<main class="flex-grow flex items-center justify-center px-4">
  <div class="bg-white/20 backdrop-blur-xl p-8 rounded-3xl shadow-lg w-full max-w-md border border-green-300">
    <h2 class="text-3xl text-center text-green-200 font-bold mb-6">Login StickyMilk</h2>

    <?php if ($error): ?>
      <p class="text-red-300 text-center mb-3 font-semibold"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" class="flex flex-col gap-4">
      <input type="email" name="email" placeholder="Masukkan Gmail" required
             class="p-3 rounded-xl bg-white/60 focus:bg-white outline-none" />

      <input type="password" name="password" placeholder="Password" required
             class="p-3 rounded-xl bg-white/60 focus:bg-white outline-none" />

      <button type="submit" name="login"
              class="bg-green-400 hover:bg-green-500 text-white font-bold py-3 rounded-xl transition-all">
        Login
      </button>

      <!-- TAMBAHAN -->
      <p class="text-center text-white/80 text-sm mt-2">
        Belum punya akun?
        <a href="register.php" class="text-green-300 font-semibold hover:underline">
          Daftar dulu
        </a>
      </p>
    </form>
  </div>
</main>
<!-- END MAIN CONTENT -->

<!-- FOOTER -->
<footer class="bg-green-800 text-green-200 py-6 w-full mt-auto">
  <div class="text-center">
    <p class="font-semibold">JL. Gatot Subroto | CP: 0857 5803 5644</p>
    <p class="text-sm opacity-80">© <?= date('Y'); ?> Kedai StickyMilk</p>
  </div>
</footer>
<!-- END FOOTER -->

</body>
</html>