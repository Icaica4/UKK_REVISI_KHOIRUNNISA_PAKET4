<?php
include 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

/* ================= HAPUS ================= */
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {

    $id = (int)$_GET['hapus'];

    $stmt = mysqli_prepare($conn, "DELETE FROM buku WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    header("Location: manage_books.php");
    exit();
}

/* ================= PENCARIAN ================= */
$keyword = "";

if (isset($_GET['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
    $query = "SELECT * FROM buku 
              WHERE judul LIKE '%$keyword%' 
              OR penerbit LIKE '%$keyword%' 
              OR tahun LIKE '%$keyword%'
              ORDER BY id DESC";
} else {
    $query = "SELECT * FROM buku ORDER BY id DESC";
}

$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manajemen Buku</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Poppins',sans-serif;
    background:linear-gradient(135deg,#667eea,#764ba2);
    min-height:100vh;
    padding:40px 20px;
}

h2{
    text-align:center;
    color:white;
    font-weight:600;
    margin-bottom:30px;
}

.container{
    max-width:1100px;
    margin:auto;
    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 20px 60px rgba(0,0,0,0.2);
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.btn-dashboard{
    padding:10px 18px;
    border-radius:12px;
    background:#f1f5f9;
    color:#334155;
    text-decoration:none;
    font-weight:600;
}

.btn-add{
    padding:10px 18px;
    border-radius:12px;
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    text-decoration:none;
    font-weight:600;
}

.search-box{
    margin-bottom:20px;
    display:flex;
    gap:10px;
}

.search-box input{
    flex:1;
    padding:10px;
    border-radius:10px;
    border:1px solid #ddd;
}

.search-box button{
    padding:10px 15px;
    border:none;
    border-radius:10px;
    background:#667eea;
    color:white;
    cursor:pointer;
}

.search-box a{
    padding:10px 15px;
    border-radius:10px;
    background:#e2e8f0;
    text-decoration:none;
    color:#333;
}

table{
    width:100%;
    border-collapse:collapse;
    border-radius:15px;
    overflow:hidden;
}

table thead{
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
}

table th{padding:15px;}
table td{
    padding:14px;
    text-align:center;
    font-size:14px;
}

table tbody tr:nth-child(even){
    background:#f8fafc;
}

table tbody tr:hover{
    background:#eef2ff;
}

.aksi a{
    padding:6px 12px;
    border-radius:8px;
    font-size:13px;
    font-weight:500;
    text-decoration:none;
    margin:0 3px;
}

.edit{background:#3b82f6;color:white;}
.hapus{background:#ef4444;color:white;}

</style>
</head>

<body>

<h2>📚 Manajemen Buku</h2>

<div class="container">

<div class="top-bar">
    <a href="dashboard_admin.php" class="btn-dashboard">⬅ Dashboard</a>
    <a href="tambah_buku.php" class="btn-add">+ Tambah Buku</a>
</div>

<!-- FORM PENCARIAN -->
<form method="GET" class="search-box">
    <input type="text" name="keyword" 
    placeholder="Cari judul, penerbit, atau tahun..." 
    value="<?= htmlspecialchars($keyword) ?>">
    
    <button type="submit" name="cari">Cari</button>
    <a href="manage_books.php">Reset</a>
</form>

<table>
<thead>
<tr>
<th>No</th>
<th>Judul</th>
<th>Penerbit</th>
<th>Tahun</th>
<th>Stok</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
<?php
$no = 1;

if ($data && mysqli_num_rows($data) > 0) {

    while ($row = mysqli_fetch_assoc($data)) {
?>
<tr>
<td><?= $no++; ?></td>
<td><?= htmlspecialchars($row['judul'] ?? '-') ?></td>
<td><?= htmlspecialchars($row['penerbit'] ?? '-') ?></td>
<td><?= htmlspecialchars($row['tahun'] ?? '-') ?></td>
<td><?= htmlspecialchars($row['stok'] ?? '0') ?></td>

<td class="aksi">
<a class="edit" href="edit_buku.php?id=<?= $row['id']; ?>">Edit</a>
<a class="hapus" href="?hapus=<?= $row['id']; ?>" 
onclick="return confirm('Yakin hapus buku?')">Hapus</a>
</td>

</tr>
<?php
    }

} else {
    echo "<tr><td colspan='6'>Data buku tidak ditemukan</td></tr>";
}
?>
</tbody>
</table>

</div>

</body>
</html>