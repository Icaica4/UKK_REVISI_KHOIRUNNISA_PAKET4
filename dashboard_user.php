<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login_user.php");
    exit();
}
$username = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Peserta</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #9face6);
            display: flex;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 230px;
            background: white;
            height: 100vh;
            padding: 30px 20px;
            position: fixed;
            box-shadow: 5px 0 20px rgba(0,0,0,0.1);
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            color: #2d3436;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #2d3436;
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 10px;
            transition: 0.3s;
            font-weight: 500;
        }

        .sidebar a:hover, .sidebar a.active {
            background: linear-gradient(45deg, #00b894, #00cec9);
            color: white;
        }

        /* ===== MAIN CONTENT ===== */
        .main {
            margin-left: 250px;
            padding: 50px;
            flex: 1;
        }

        .welcome-box {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            margin-bottom: 40px;
            text-align: center;
        }

        .welcome-box h1 {
            margin: 0;
            font-size: 26px;
            color: #2d3436;
        }

        .welcome-box p {
            margin-top: 10px;
            color: #636e72;
            font-size: 16px;
        }

        /* ===== CARD MENU ===== */
        .menu-container {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .menu-card {
            width: 260px;
            background: white;
            border-radius: 20px;
            padding: 40px 25px;
            text-align: center;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            transition: 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .menu-card i {
            font-size: 55px;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #00b894, #0984e3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .menu-card h3 {
            margin-bottom: 20px;
            font-size: 20px;
            color: #2d3436;
        }

        .btn-menu {
            display: inline-block;
            padding: 12px 25px;
            border-radius: 15px;
            text-decoration: none;
            color: white;
            font-weight: 600;
            background: linear-gradient(45deg, #00b894, #00cec9);
            transition: 0.3s;
        }

        .btn-menu:hover {
            background: linear-gradient(45deg, #0984e3, #6c5ce7);
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .main {
                margin-left: 0;
                padding: 25px;
            }
        }

    </style>
</head>
<body>

<div class="sidebar">
    <h2>Peserta</h2>
    <a href="dashboard_user.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main">

    <div class="welcome-box">
        <h1>Halo, <?php echo $username; ?> 👋</h1>
        <p>Selamat datang di dashboard peserta. Silakan pilih menu di bawah untuk melanjutkan.</p>
    </div>

    <div class="menu-container">

        <div class="menu-card">
            <i class="fas fa-book-open"></i>
            <h3>Daftar Buku</h3>
            <a href="list_buku.php" class="btn-menu">Lihat Buku</a>
        </div>

        <div class="menu-card">
            <i class="fas fa-clipboard-list"></i>
            <h3>Peminjaman Saya</h3>
            <a href="peminjaman_user.php" class="btn-menu">Cek Peminjaman</a>
        </div>

    </div>

</div>

</body>
</html>