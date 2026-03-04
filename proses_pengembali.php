<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = (int)$_GET['id'];

    // Ambil data peminjaman
    $data = mysqli_query($conn, "SELECT * FROM peminjaman WHERE id='$id'");
    $row = mysqli_fetch_assoc($data);

    if ($row) {

        $id_buku = $row['id_buku'];

        // Update status jadi Dikembalikan
        mysqli_query($conn, "UPDATE peminjaman 
                             SET status='Dikembalikan',
                             tanggal_kembali=NOW()
                             WHERE id='$id'");

        // Tambah stok buku
        mysqli_query($conn, "UPDATE buku 
                             SET stok = stok + 1 
                             WHERE id='$id_buku'");

        header("Location: dashboard_user.php?pesan=kembali");
        exit();
    }
}

header("Location: dashboard_user.php");
exit();
?>