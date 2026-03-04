<?php
// Jalankan session hanya jika belum aktif
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = mysqli_connect("localhost", "root", "", "ukk_khoirunnisa_paket4");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
