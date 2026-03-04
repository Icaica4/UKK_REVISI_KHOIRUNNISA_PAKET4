<?php
include 'config.php';

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['admin'])){
    header("Location: login_admin.php");
    exit();
}

/* ================= TAMBAH ================= */
if(isset($_POST['tambah'])){
    $user_id = $_POST['user_id'];
    $buku_id = $_POST['buku_id'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $status = "Dipinjam";

    $insert = mysqli_query($conn,"INSERT INTO peminjaman 
        (user_id,buku_id,tanggal_pinjam,tanggal_kembali,status)
        VALUES 
        ('$user_id','$buku_id','$tanggal_pinjam','$tanggal_kembali','$status')
    ");

    if(!$insert){
        die("Error tambah: ".mysqli_error($conn));
    }

    header("Location: manage_peminjaman.php");
    exit();
}

/* ================= HAPUS ================= */
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($conn,"DELETE FROM peminjaman WHERE id='$id'");
    header("Location: manage_peminjaman.php");
    exit();
}

/* ================= QUERY ================= */
$users = mysqli_query($conn,"SELECT * FROM users");
$buku  = mysqli_query($conn,"SELECT * FROM buku");

$data = mysqli_query($conn,"
    SELECT peminjaman.*, 
           users.username AS nama_user,
           buku.judul
    FROM peminjaman
    LEFT JOIN users ON peminjaman.user_id = users.id
    LEFT JOIN buku ON peminjaman.buku_id = buku.id
    ORDER BY peminjaman.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Peminjaman</title>
    <link rel="stylesheet" href="style.css">
<style>
body.manage-peminjaman {
    background: linear-gradient(135deg, #667eea, #764ba2);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding: 40px;
    min-height: 100vh;
}

/* ==================== TOMBOL KEMBALI ==================== */
.top-bar {
    position: absolute;
    top: 20px;
    right: 40px;
}

.btn-kembali {
    text-decoration: none;
    background: white;
    color: #667eea;
    padding: 8px 18px;
    border-radius: 30px;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.btn-kembali:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
}

/* ==================== JUDUL HALAMAN ==================== */
.manage-title {
    color: white;
    text-align: center;
    margin-bottom: 30px;
    font-size: 28px;
}

/* ==================== CONTAINER ==================== */
.container {
    background: white;
    padding: 30px;
    border-radius: 20px;
    margin-top: 30px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.25);
}

/* ==================== FORM ==================== */
.manage-form {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 25px;
}

.manage-form select,
.manage-form input {
    flex: 1;
    min-width: 150px;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ccc;
    transition: 0.3s;
}

.manage-form select:focus,
.manage-form input:focus {
    border-color: #667eea;
    outline: none;
    box-shadow: 0 0 5px rgba(102,126,234,0.4);
}

/* Tombol tambah */
.manage-form button {
    background: #667eea;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.manage-form button:hover {
    background: #5a67d8;
    transform: translateY(-2px);
}

/* ==================== TABLE ==================== */
.manage-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.manage-table th,
.manage-table td {
    padding: 12px 15px;
    text-align: center;
}

.manage-table th {
    background: #667eea;
    color: white;
}

.manage-table tbody tr:hover {
    background: #f4f6ff;
    transition: 0.2s;
}

/* ==================== STATUS BADGE ==================== */
.status-dipinjam {
    background: #ff7675;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}

.status-kembali {
    background: #00b894;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}

/* ==================== TOMBOL HAPUS ==================== */
.btn-hapus {
    background: #ff4d4d;
    color: white;
    padding: 6px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    transition: 0.3s;
}

.btn-hapus:hover {
    background: #e60000;
    transform: scale(1.05);
}

/* ==================== RESPONSIVE ==================== */
@media screen and (max-width: 768px) {
    .manage-form {
        flex-direction: column;
    }

    .top-bar {
        position: static;
        text-align: center;
        margin-bottom: 20px;
    }

    .btn-kembali {
        display: inline-block;
        margin-bottom: 15px;
    }
}
</style>
</head>
<body class="manage-peminjaman">

    <!-- Tombol Kembali -->
    <div class="top-bar">
        <a href="dashboard_admin.php" class="btn-kembali">← Kembali ke Dashboard</a>
    </div>

    <h2 class="manage-title">Manajemen Peminjaman Buku</h2>

    <div class="container">

        <!-- Form tambah peminjaman -->
        <form method="POST" class="manage-form">
            <select name="user_id" required>
                <option value="">-- Nama Peminjaman --</option>
                <?php while($u=mysqli_fetch_assoc($users)){ ?>
                <option value="<?= $u['id']; ?>"><?= $u['username']; ?></option>
                <?php } ?>
            </select>

            <select name="buku_id" required>
                <option value="">-- Pilih Buku --</option>
                <?php while($b=mysqli_fetch_assoc($buku)){ ?>
                <option value="<?= $b['id']; ?>"><?= $b['judul']; ?></option>
                <?php } ?>
            </select>

            <input type="date" name="tanggal_pinjam" required>
            <input type="date" name="tanggal_kembali" required>
            <button type="submit" name="tambah">Tambah</button>
        </form>

        <!-- Table peminjaman -->
        <table class="manage-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjaman</th>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no=1;
                if(mysqli_num_rows($data)>0){
                    while($row=mysqli_fetch_assoc($data)){
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['nama_user']; ?></td>
                    <td><?= $row['judul']; ?></td>
                    <td><?= $row['tanggal_pinjam']; ?></td>
                    <td><?= $row['tanggal_kembali']; ?></td>
                    <td>
                        <?php if($row['status'] == "Dipinjam"){ ?>
                            <span class="status-dipinjam">Dipinjam</span>
                        <?php } else { ?>
                            <span class="status-kembali">Dikembalikan</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a class="btn-hapus" href="?hapus=<?= $row['id']; ?>" onclick="return confirm('Hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php }} else { ?>
                <tr>
                    <td colspan="7">Belum ada data</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</body>
</html>