<?php
include 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

$username = $_SESSION['admin'];

/* ================= COUNT DATA ================= */
$buku = mysqli_query($conn, "SELECT COUNT(*) as total FROM buku");
$buku_count = $buku ? mysqli_fetch_assoc($buku)['total'] : 0;

$peminjaman = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman");
$peminjaman_count = $peminjaman ? mysqli_fetch_assoc($peminjaman)['total'] : 0;

$users = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$user_count = $users ? mysqli_fetch_assoc($users)['total'] : 0;

$kategori = mysqli_query($conn, "SELECT COUNT(*) as total FROM kategori");
$kategori_count = $kategori ? mysqli_fetch_assoc($kategori)['total'] : 0;

/* ================= PEMINJAMAN TERBARU ================= */
$data_peminjaman = mysqli_query($conn, "
    SELECT p.*, 
           u.username AS nama_user, 
           b.judul AS judul_buku
    FROM peminjaman p
    LEFT JOIN users u ON p.user_id = u.id
    LEFT JOIN buku b ON p.buku_id = b.id
    ORDER BY p.id DESC
    LIMIT 5
");

/* ================= ANGGOTA TERBARU ================= */
$data_anggota = mysqli_query($conn, "
    SELECT * FROM users
    ORDER BY id DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Poppins', sans-serif;
    background:#eef5f0;
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:230px;
    background:#2c3e50;
    color:white;
    height:100vh;
    position:fixed;
    display:flex;
    flex-direction:column;
    padding:30px 15px;
}

.sidebar h2{
    text-align:center;
    margin-bottom:30px;
}

.sidebar a{
    color:white;
    text-decoration:none;
    padding:12px;
    border-radius:10px;
    margin-bottom:10px;
    display:flex;
    align-items:center;
    gap:10px;
    transition:0.3s;
}

.sidebar a:hover,
.sidebar a.active{
    background:#3498db;
}

.logout{
    margin-top:auto;
    background:#e74c3c;
}

.logout:hover{
    background:#c0392b;
}

/* MAIN */
.main-content{
    margin-left:250px;
    padding:40px;
    flex:1;
}

.stats-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin-top:30px;
}

.card{
    background:white;
    padding:25px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.card h3{
    margin-bottom:10px;
}

.card p{
    font-size:28px;
    font-weight:bold;
}

.card-yellow{background:#ffeaa7;}
.card-green{background:#b8e994;}
.card-blue{background:#74b9ff;}
.card-purple{background:#dfe6e9;}

/* Table peminjaman */
table{
    width:100%;
    margin-top:20px;
    border-collapse:collapse;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

th,td{
    padding:10px;
    border:1px solid #ddd;
    text-align:center;
}

th{
    background:#0984e3;
    color:white;
}

/* Data Anggota */
.member-section {
    margin-top:50px;
}

.member-section h2{
    margin-bottom:20px;
    color:#333;
}

.member-cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:20px;
}

.member-card{
    background:#ffecb3;
    border-radius:15px;
    padding:20px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:0.3s;
    cursor:pointer;
}

.member-card:hover{
    transform: translateY(-5px) rotate(-1deg);
    box-shadow:0 8px 25px rgba(0,0,0,0.2);
}

.member-card img{
    width:60px;
    height:60px;
    border-radius:50%;
    margin-bottom:10px;
}

.member-card h4{
    margin-bottom:5px;
    font-size:16px;
    color:#333;
}

.member-card p{
    font-size:14px;
    color:#555;
}

/* Status badge untuk peminjaman */
.status-dipinjam{
    background:#ff7675;
    color:white;
    padding:5px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:500;
}

.status-kembali{
    background:#00b894;
    color:white;
    padding:5px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:500;
}

/* Responsive */
@media screen and (max-width:768px){
    .main-content{
        margin-left:0;
        padding:20px;
    }
    .stats-container, .member-cards{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<body>

<div class="sidebar">
    <h2>Admin</h2>

    <a href="dashboard_admin.php" class="active">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <a href="manage_books.php">
        <i class="fas fa-book"></i> Manajemen Buku
    </a>

    <a href="manage_peminjaman.php">
        <i class="fas fa-hand-holding"></i> Peminjaman
    </a>

    <a href="manage_anggota.php">
        <i class="fas fa-hand-holding"></i> Anggota
    </a>

    <!-- LOGOUT -->
    <a href="logout.php" class="logout">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<div class="main-content">

<h1>Dashboard Admin</h1>
<p>Selamat datang, <strong><?php echo $username; ?></strong> 👋</p>

<div class="stats-container">
    <div class="card card-yellow">
        <h3>Total Buku</h3>
        <p><?php echo $buku_count; ?></p>
    </div>
    <div class="card card-green">
        <h3>Total Peminjaman</h3>
        <p><?php echo $peminjaman_count; ?></p>
    </div>
    <div class="card card-blue">
        <h3>Total User</h3>
        <p><?php echo $user_count; ?></p>
    </div>
    <div class="card card-purple">
        <h3>Kategori Buku</h3>
        <p><?php echo $kategori_count; ?></p>
    </div>
</div>

<h2 style="margin-top:50px;">Peminjaman Terbaru</h2>

<table>
<tr>
<th>No</th>
<th>Nama User</th>
<th>Judul Buku</th>
<th>Tanggal Pinjam</th>
<th>Tanggal Kembali</th>
<th>Status</th>
</tr>

<?php
$no=1;
if($data_peminjaman && mysqli_num_rows($data_peminjaman)>0){
    while($row=mysqli_fetch_assoc($data_peminjaman)){
?>
<tr>
<td><?= $no++; ?></td>
<td><?= $row['nama_user'] ?? '-'; ?></td>
<td><?= $row['judul_buku'] ?? '-'; ?></td>
<td><?= $row['tanggal_pinjam'] ?? '-'; ?></td>
<td><?= $row['tanggal_kembali'] ?? '-'; ?></td>
<td>
<?php if($row['status']=="Dipinjam"){ ?>
<span class="status-dipinjam">Dipinjam</span>
<?php } else { ?>
<span class="status-kembali">Dikembalikan</span>
<?php } ?>
</td>
</tr>
<?php }} else { ?>
<tr>
<td colspan="6">Belum ada peminjaman</td>
</tr>
<?php } ?>
</table>

