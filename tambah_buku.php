<?php
include 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

if (isset($_POST['tambah'])) {

    $judul      = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis    = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit   = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $tahun      = (int)$_POST['tahun'];
    $stok       = (int)$_POST['stok'];

    mysqli_query($conn, "INSERT INTO buku 
        (judul, penulis, penerbit, tahun, stok)
        VALUES 
        ('$judul','$penulis','$penerbit','$tahun','$stok')");

    echo "<script>
            alert('Buku berhasil ditambahkan!');
            window.location='manage_books.php';
          </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Buku</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
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
    box-shadow: 0 25px 50px rgba(0,0,0,0.25);
    animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
}

h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

input {
    width: 100%;
    padding: 12px 14px;
    border-radius: 12px;
    border: 1px solid #ddd;
    font-size: 14px;
    transition: 0.3s;
}

input:focus {
    border-color: #667eea;
    outline: none;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.2);
}

button {
    padding: 12px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.back {
    display: block;
    text-align: center;
    margin-top: 15px;
    text-decoration: none;
    color: #667eea;
    font-weight: 500;
}

.back:hover {
    text-decoration: underline;
}

@media(max-width: 500px){
    .card {
        width: 90%;
        padding: 25px;
    }
}

</style>
</head>
<body>

<div class="card">
<h2>📚 Tambah Buku</h2>

<form method="POST">
    <input type="text" name="judul" placeholder="Judul Buku" required>
    <input type="text" name="penulis" placeholder="Penulis" required>
    <input type="text" name="penerbit" placeholder="Penerbit" required>
    <input type="number" name="tahun" placeholder="Tahun Terbit" required>
    <input type="number" name="stok" placeholder="Stok Buku" required>
    <button type="submit" name="tambah">Tambah Buku</button>
</form>

<a href="manage_books.php" class="back">⬅ Kembali</a>
</div>

</body>
</html>