function openOrderPopup(nama, harga) {
  document.getElementById("popup").classList.remove("hidden");
  document.getElementById("popupItem").innerText = nama + " - Rp " + harga.toLocaleString();
  document.getElementById("menuNama").value = nama;
  document.getElementById("menuHarga").value = harga;
}

function closePopup() {
  document.getElementById("popup").classList.add("hidden");
}

// FULLSCREEN GAMBAR
document.addEventListener("click", function (e) {
  if (e.target.classList.contains("zoomable")) {
    openFullImage(e.target.src);
  }
});

function openFullImage(src) {
  const full = document.createElement("div");
  full.className = "fixed inset-0 bg-black/90 flex items-center justify-center";
  full.innerHTML = `
    <img src="${src}" class="max-w-[90%] max-h-[90%] rounded-xl shadow-lg">
  `;
  full.onclick = () => full.remove();
  document.body.appendChild(full);
}



function toggleDesc(btn) {
  const box = btn.parentElement.querySelector(".desc-box");

  // Show / hide deskripsi
  box.classList.toggle("hidden");

  // Ubah teks tombol
  if (box.classList.contains("hidden")) {
    btn.innerHTML = "Lihat Deskripsi ▼";
  } else {
    btn.innerHTML = "Tutup Deskripsi ▲";
  }
}