<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login_user.php");
    exit();
}

$username = $_SESSION['user'];

/* ================= PROSES PENGEMBALIAN ================= */
if (isset($_GET['kembali']) && is_numeric($_GET['kembali'])) {

    $id = (int)$_GET['kembali'];

    $ambil = mysqli_query($conn, "
        SELECT p.*, buku.id as buku_id 
        FROM peminjaman p
        JOIN buku ON p.buku_id = buku.id
        JOIN users u ON p.user_id = u.id
        WHERE p.id='$id' AND u.username='$username'
    ");

    $data = mysqli_fetch_assoc($ambil);

    if ($data && $data['status'] == 'Dipinjam') {

        mysqli_query($conn, "UPDATE peminjaman 
                             SET status='Dikembalikan',
                             tanggal_kembali=NOW()
                             WHERE id='$id'");

        mysqli_query($conn, "UPDATE buku 
                             SET stok = stok + 1 
                             WHERE id='{$data['buku_id']}'");

        header("Location: peminjaman_user.php?pesan=kembali");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Peminjaman Saya</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Poppins, sans-serif;
            background: #f4f6f9;
            padding: 40px;
        }

        h2 {
            margin-bottom: 20px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 15px;
            background: #00b894;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .back:hover {
            background: #0984e3;
        }

        .alert {
            background: #00b894;
            color: white;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
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

        .status-pinjam {
            color: orange;
            font-weight: bold;
        }

        .status-kembali {
            color: green;
            font-weight: bold;
        }

        .btn-kembali {
            padding: 6px 14px;
            background: #00b894;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            display: inline-block;
            min-width: 100px;
            transition: 0.3s;
        }

        .btn-kembali:hover {
            background: #0984e3;
        }

        .btn-disabled {
            padding: 6px 14px;
            background: #b2bec3;
            color: white;
            border-radius: 6px;
            display: inline-block;
            min-width: 100px;
        }
    </style>
</head>
<body>

<a href="dashboard_user.php" class="back">
    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
</a>

<h2>Daftar Peminjaman Saya</h2>

<?php if(isset($_GET['pesan']) && $_GET['pesan']=='kembali'){ ?>
    <div class="alert">
        ✅ Buku berhasil dikembalikan!
    </div>
<?php } ?>

<table>
    <tr>
        <th>No</th>
        <th>Judul Buku</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

<?php
$query = mysqli_query($conn, "
    SELECT p.id, buku.judul, p.tanggal_pinjam, 
           p.tanggal_kembali, p.status, buku.id as buku_id
    FROM peminjaman p
    JOIN buku ON p.buku_id = buku.id
    JOIN users u ON p.user_id = u.id
    WHERE u.username = '$username'
    ORDER BY p.id DESC
");

$no = 1;

if (mysqli_num_rows($query) > 0) {
    while ($data = mysqli_fetch_assoc($query)) {

        $statusClass = ($data['status'] == 'Dipinjam') 
                        ? 'status-pinjam' 
                        : 'status-kembali';

        echo "<tr>
                <td>$no</td>
                <td>{$data['judul']}</td>
                <td>{$data['tanggal_pinjam']}</td>
                <td>".($data['tanggal_kembali'] ? $data['tanggal_kembali'] : '-')."</td>
                <td class='$statusClass'>{$data['status']}</td>
                <td>";

        if ($data['status'] == 'Dipinjam') {
            echo "<a href='?kembali={$data['id']}' 
                     onclick=\"return confirm('Yakin ingin mengembalikan buku ini?')\" 
                     class='btn-kembali'>
                     Kembalikan
                  </a>";
        } else {
            echo "<span class='btn-disabled'>Selesai</span>";
        }

        echo "</td></tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='6'>Belum ada peminjaman</td></tr>";
}
?>

</table>

</body>
</html>