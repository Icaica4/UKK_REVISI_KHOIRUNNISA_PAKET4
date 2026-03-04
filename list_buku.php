<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login_user.php");
    exit();
}

$username = $_SESSION['user'];

/* ================= PROSES PINJAM ================= */
if (isset($_GET['pinjam']) && is_numeric($_GET['pinjam'])) {

    $id_buku = (int)$_GET['pinjam'];

    // Ambil data user
    $userQuery = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
    $userData = mysqli_fetch_assoc($userQuery);
    $user_id = $userData['id'] ?? 0;

    // Cek buku
    $bukuQuery = mysqli_query($conn, "SELECT * FROM buku WHERE id='$id_buku'");
    $buku = mysqli_fetch_assoc($bukuQuery);

    if ($buku && ($buku['stok'] ?? 0) > 0) {

        // Kurangi stok
        mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id='$id_buku'");

        // Simpan peminjaman
        mysqli_query($conn, "INSERT INTO peminjaman (user_id, buku_id, tanggal_pinjam, status)
                             VALUES ('$user_id', '$id_buku', NOW(), 'Dipinjam')");

        header("Location: list_buku.php?pesan=berhasil");
        exit();
    } else {
        header("Location: list_buku.php?pesan=habis");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
    <style>
        body {
            font-family: Poppins, sans-serif;
            background: #f4f6f9;
            padding: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background: #00b894;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .btn-pinjam {
            padding: 6px 14px;
            background: #00b894;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
            min-width: 90px;
        }

        .btn-pinjam:hover {
            background: #0984e3;
        }

        .btn-disabled {
            padding: 6px 14px;
            background: #b2bec3;
            color: white;
            border-radius: 6px;
            display: inline-block;
            min-width: 90px;
        }

        .alert {
            padding: 12px;
            margin-top: 20px;
            border-radius: 8px;
            text-align: center;
            color: white;
        }

        .success { background: #00b894; }
        .error { background: #d63031; }

        a.back {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            padding: 8px 15px;
            background: #0984e3;
            color: white;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<a href="dashboard_user.php" class="back">⬅ Kembali</a>

<h2>Daftar Buku</h2>

<table>
    <tr>
        <th>No</th>
        <th>Kode Buku</th>
        <th>Judul</th>
        <th>Penerbit</th>
        <th>Tahun</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>

<?php
$query = mysqli_query($conn, "SELECT * FROM buku");
$no = 1;

if ($query && mysqli_num_rows($query) > 0) {
    while ($data = mysqli_fetch_assoc($query)) {

        echo "<tr>
                <td>$no</td>
                <td>".($data['kode_buku'] ?? '-')."</td>
                <td>".($data['judul'] ?? '-')."</td>
                <td>".($data['penerbit'] ?? '-')."</td>
                <td>".($data['tahun_terbit'] ?? '-')."</td>
                <td>".($data['stok'] ?? '0')."</td>
                <td>";

        if (($data['stok'] ?? 0) > 0) {
            echo "<a href='?pinjam={$data['id']}' 
                     onclick=\"return confirm('Yakin ingin meminjam buku ini?')\" 
                     class='btn-pinjam'>Pinjam</a>";
        } else {
            echo "<span class='btn-disabled'>Habis</span>";
        }

        echo "</td></tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='7'>Data buku belum tersedia</td></tr>";
}
?>

</table>

<?php if(isset($_GET['pesan']) && $_GET['pesan']=='berhasil'){ ?>
    <div class="alert success">✅ Buku berhasil dipinjam!</div>
<?php } ?>

<?php if(isset($_GET['pesan']) && $_GET['pesan']=='habis'){ ?>
    <div class="alert error">❌ Stok buku habis!</div>
<?php } ?>

</body>
</html>