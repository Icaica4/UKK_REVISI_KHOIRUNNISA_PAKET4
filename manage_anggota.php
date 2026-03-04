<?php
include 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

$edit_data = null;

/* ================= TAMBAH ================= */
if (isset($_POST['tambah'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    mysqli_query($conn, "INSERT INTO users (username, password)
                         VALUES ('$username','$password')");

    header("Location: manage_anggota.php");
    exit();
}

/* ================= HAPUS ================= */
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");

    header("Location: manage_anggota.php");
    exit();
}

/* ================= EDIT ================= */
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");

    if ($result && mysqli_num_rows($result) > 0) {
        $edit_data = mysqli_fetch_assoc($result);
    }
}

/* ================= UPDATE ================= */
if (isset($_POST['update'])) {

    $id = (int)$_POST['id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    mysqli_query($conn, "UPDATE users SET 
        username='$username',
        password='$password'
        WHERE id=$id");

    header("Location: manage_anggota.php");
    exit();
}

$data = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manajemen Anggota</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    margin: 0;
    padding: 40px;
}

h2 {
    text-align: center;
    color: white;
    margin-bottom: 25px;
}

.container {
    max-width: 1100px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

/* tombol dashboard */
.btn-dashboard {
    display: inline-block;
    margin-bottom: 20px;
    background: linear-gradient(45deg, #16a34a, #22c55e);
    color: white;
    text-decoration: none;
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-dashboard:hover {
    transform: scale(1.05);
}

form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    margin-bottom: 20px;
}

form input {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 10px;
    min-width: 180px;
}

button {
    padding: 12px 18px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
}

.btn-green {
    background: linear-gradient(45deg, #36d1dc, #5b86e5);
    color: white;
}

.btn-cancel {
    background: #ef4444;
    color: white;
    text-decoration: none;
    padding: 12px 18px;
    border-radius: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    border-radius: 15px;
    overflow: hidden;
}

table thead {
    background: linear-gradient(45deg, #1e3c72, #2a5298);
    color: white;
}

table th, table td {
    padding: 14px;
    text-align: center;
}

table tr:nth-child(even) {
    background: #f3f4f6;
}

table tr:hover {
    background: #e0e7ff;
}

.aksi a {
    text-decoration: none;
    font-weight: 600;
    margin: 0 6px;
}

.edit {
    color: #2563eb;
}

.hapus {
    color: #dc2626;
}
</style>
</head>

<body>

<h2>📚 Manajemen Anggota</h2>

<div class="container">

<a href="dashboard_admin.php" class="btn-dashboard">⬅ Kembali ke Dashboard</a>

<form method="POST">
    <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">

    <input type="text" name="username" placeholder="Username"
        value="<?= $edit_data['username'] ?? '' ?>" required>

    <input type="text" name="password" placeholder="Password"
        value="<?= $edit_data['password'] ?? '' ?>" required>

    <?php if ($edit_data) { ?>
        <button type="submit" name="update" class="btn-green">Update</button>
        <a href="manage_anggota.php" class="btn-cancel">Batal</a>
    <?php } else { ?>
        <button type="submit" name="tambah" class="btn-green">Tambah</button>
    <?php } ?>
</form>

<table>
<thead>
<tr>
    <th>No</th>
    <th>Username</th>
    <th>Password</th>
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
    <td><?= htmlspecialchars($row['username']); ?></td>
    <td><?= htmlspecialchars($row['password']); ?></td>
    <td class="aksi">
        <a class="edit" href="?edit=<?= $row['id']; ?>">Edit</a> |
        <a class="hapus" href="?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
    </td>
</tr>
<?php
    }
} else {
    echo "<tr><td colspan='4'>Belum ada data anggota</td></tr>";
}
?>
</tbody>
</table>

</div>

</body>
</html>