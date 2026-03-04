<?php
include 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_books.php");
    exit();
}

$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM buku WHERE id=$id");

if (!$result || mysqli_num_rows($result) == 0) {
    header("Location: manage_books.php");
    exit();
}

$data = mysqli_fetch_assoc($result);

/* ================= UPDATE ================= */
if (isset($_POST['update'])) {

    $judul    = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis  = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun    = (int)$_POST['tahun'];
    $stok     = (int)$_POST['stok'];

    mysqli_query($conn, "UPDATE buku SET
        judul='$judul',
        penulis='$penulis',
        penerbit='$penerbit',
        tahun='$tahun',
        stok='$stok'
        WHERE id=$id");

    echo "<script>
            alert('Buku berhasil diupdate!');
            window.location='manage_books.php';
          </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Buku</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.card {
    background: white;
    padding: 40px;
    width: 420px;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.25);
}
h2 {
    text-align: center;
    margin-bottom: 25px;
}
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
input {
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #ddd;
}
input:focus {
    border-color: #4f46e5;
    outline: none;
    box-shadow: 0 0 0 3px rgba(79,70,229,0.2);
}
button {
    padding: 12px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
    font-weight: 600;
    cursor: pointer;
}
button:hover {
    transform: translateY(-3px);
}
.back {
    display: block;
    text-align: center;
    margin-top: 15px;
    text-decoration: none;
    color: #4f46e5;
}
</style>
</head>
<body>

<div class="card">
<h2>✏ Edit Buku</h2>

<form method="POST">

<input type="text" name="judul"
       value="<?= htmlspecialchars($data['judul'] ?? ''); ?>"
       placeholder="Judul Buku" required>

<input type="text" name="penulis"
       value="<?= htmlspecialchars($data['penulis'] ?? ''); ?>"
       placeholder="Penulis" required>

<input type="text" name="penerbit"
       value="<?= htmlspecialchars($data['penerbit'] ?? ''); ?>"
       placeholder="Penerbit" required>

<input type="number" name="tahun"
       value="<?= htmlspecialchars($data['tahun'] ?? ''); ?>"
       placeholder="Tahun" required>

<input type="number" name="stok"
       value="<?= htmlspecialchars($data['stok'] ?? ''); ?>"
       placeholder="Stok" required>

<button type="submit" name="update">Update Buku</button>
</form>

<a href="manage_books.php" class="back">⬅ Kembali</a>
</div>

</body>
</html>