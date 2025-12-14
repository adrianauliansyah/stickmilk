<?php
session_start();
include 'koneksi.php'; 

$success = false;

// =================================================================
// LOGIKA HAPUS
// =================================================================
if (isset($_GET['hapus'])) {
    $id_pesanan_hapus = (int)$_GET['hapus'];
    
    // Hapus detail item (Foreign Key Constraint)
    $conn->query("DELETE FROM detail_pesanan WHERE id_pesanan = $id_pesanan_hapus");
    
    // Hapus header pesanan
    $conn->query("DELETE FROM pesanan WHERE id_pesanan = $id_pesanan_hapus");

    header("Location: order.php");
    exit();
}

// =================================================================
// LOGIKA PENYIMPANAN DATA (POST KE DATABASE) - Sudah DIBERSIHKAN
// =================================================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Asumsi data POST yang dikirim dari menu.php
    $menu_name = $conn->real_escape_string($_POST["menu"]); 
    
    // Safety check dan sanitasi
    $id_produk = isset($_POST["id_produk"]) ? (int)$_POST["id_produk"] : 0; 
    $harga_item = isset($_POST["harga"]) ? (float)$_POST["harga"] : 0; 
    $pemesan = $conn->real_escape_string($_POST["pemesan"]);
    $catatan = $conn->real_escape_string($_POST["catatan"]);
    $jumlah_item = 1; 

    // Perhitungan
    $subtotal = $harga_item * $jumlah_item;
    $total_pesanan = $subtotal; 
    $waktu_sekarang = date("Y-m-d H:i:s"); 
    
    // 1. INSERT KE TABEL pesanan (HEADER) - DIBERSIHKAN
    $sql_pesanan = "INSERT INTO pesanan (pemesan, tanggal, total) 
                    VALUES ('$pemesan', '$waktu_sekarang', $total_pesanan)"; 

    if ($conn->query($sql_pesanan) === TRUE) {
        $last_id_pesanan = $conn->insert_id; 

        // 2. INSERT KE TABEL detail_pesanan (ITEM) - DIBERSIHKAN
        // Menyimpan nama_menu di detail_pesanan
        $sql_detail = "INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, harga, subtotal, catatan, nama_menu) 
                        VALUES ($last_id_pesanan, $id_produk, $jumlah_item, $harga_item, $subtotal, '$catatan', '$menu_name')";
        
        if ($conn->query($sql_detail) === TRUE) {
            $success = true;
        } else {
            // Jika detail gagal, hapus order headernya
            $conn->query("DELETE FROM pesanan WHERE id_pesanan = $last_id_pesanan");
            // Sebaiknya log error ini: die("Error detail: " . $conn->error); 
        }
    } else {
        // Sebaiknya log error ini: die("Error order: " . $conn->error); 
    }
} else {
    $success = false;
}
?>
<!DOCTYPE html>
<div class="overflow-x-auto mb-10">
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
    
<body class="min-h-screen flex flex-col">

    <div class="flex-grow p-6 text-center">

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
        <h2 class="text-3xl font-bold text-mint text-center mb-10">
            📝 Daftar Semua Pesanan
        </h2>

        <?php
            // Query untuk mengambil data pesanan. 
            // PERBAIKAN: Mengambil d.nama_menu dan menghapus GROUP BY
            $sql_select = "SELECT 
                                o.id_pesanan,
                                d.nama_menu, /* <<< Perbaikan 1: Ambil nama_menu dari detail */
                                o.pemesan, 
                                o.tanggal, 
                                o.total, 
                                d.jumlah,
                                d.catatan 
                            FROM pesanan o
                            JOIN detail_pesanan d ON o.id_pesanan = d.id_pesanan
                            ORDER BY o.tanggal DESC"; // <<< Perbaikan 2: GROUP BY Dihapus

            $result = $conn->query($sql_select);
        ?>

        <?php if ($result && $result->num_rows > 0): ?>
            <table class="min-w-full bg-white/10 rounded-xl shadow-lg text-left">
                <thead>
                    <tr class="bg-mint/20 text-mint">
                        <th class="py-3 px-4 font-bold rounded-tl-xl">ID</th>
                        <th class="py-3 px-4 font-bold">Menu</th>            <th class="py-3 px-4 font-bold">Pemesan</th>         <th class="py-3 px-4 font-bold">Jumlah Item</th>
                        <th class="py-3 px-4 font-bold">Catatan</th>
                        <th class="py-3 px-4 font-bold">Total Harga</th>
                        <th class="py-3 px-4 font-bold hidden sm:table-cell">Waktu</th>
                        <th class="py-3 px-4 font-bold rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($o = $result->fetch_assoc()): ?>
                        <tr class="border-b border-white/10 hover:bg-white/5">
                            <td class="py-3 px-4 font-bold text-mint">#<?= $o['id_pesanan'] ?></td>
                            <td class="py-3 px-4"><b><?= htmlspecialchars($o['nama_menu']) ?></b></td> <td class="py-3 px-4"><?= htmlspecialchars($o['pemesan']) ?></td>         <td class="py-3 px-4"><?= $o['jumlah'] ?> Item</td>
                            <td class="py-3 px-4 text-sm opacity-80"><?= htmlspecialchars($o['catatan']) ?: "-" ?></td>
                            <td class="py-3 px-4">Rp <?= number_format($o['total']) ?></td>
                            <td class="py-3 px-4 text-xs opacity-80 hidden sm:table-cell"><?= date('H:i / d-m-Y', strtotime($o['tanggal'])) ?></td>
                            <td class="py-3 px-4">
                                <a href="order.php?hapus=<?= $o['id_pesanan'] ?>"
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-700 transition duration-200"
                                    onclick="return confirm('Hapus pesanan #<?= $o['id_pesanan'] ?>?')">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="col-span-full text-center text-white/70">Belum ada pesanan</p>
        <?php endif; ?>
    </div>
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