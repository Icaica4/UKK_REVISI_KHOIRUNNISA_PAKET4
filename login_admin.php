<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $data = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($data) > 0) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard_admin.php");
        exit();
    } else {
        echo "<script>alert('Login gagal');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body.login-admin {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Segoe UI', sans-serif;
    background: #2563eb; /* biru polos */
}

.login-box {
    width: 350px;
    padding: 35px;
    border-radius: 20px;
    background: white; /* putih biar kontras */
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    text-align: center;
    color: #1e3a8a;
    animation: fadeIn 0.8s ease-in-out;
}

.login-box h2 {
    margin-bottom: 5px;
    color: #1e3a8a;
}

.subtitle {
    font-size: 14px;
    margin-bottom: 25px;
    color: #64748b;
}

.input-group {
    position: relative;
    margin-bottom: 20px;
}

.input-group input {
    width: 100%;
    padding: 12px 40px;
    border-radius: 30px;
    border: 1px solid #cbd5e1;
    outline: none;
    font-size: 14px;
}

.input-group .icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #2563eb;
}

.btn-login {
    width: 100%;
    padding: 12px;
    border-radius: 30px;
    border: none;
    background: #2563eb; /* biru polos */
    color: white;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
    margin-bottom: 10px;
}

.btn-login:hover {
    background: #1d4ed8;
}

.btn-daftar {
    display: inline-block;
    width: 100%;
    padding: 12px;
    border-radius: 30px;
    text-decoration: none;
    background: #0ea5e9;
    color: white;
    font-size: 15px;
    transition: 0.3s;
}

.btn-daftar:hover {
    background: #0284c7;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
</head>

<body class="login-admin">

<div class="login-box">
    <h2>🔐 Login Admin</h2>
    <p class="subtitle">Sistem Perpustakaan</p>

    <form method="POST">
        <div class="input-group">
            <i class="fa fa-user icon"></i>
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-group">
            <i class="fa fa-lock icon"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" name="login" class="btn-login">Login</button>
    </form>

    <!-- Tombol Daftar -->
    <a href="register_admin.php" class="btn-daftar">
        <i class="fa fa-user-plus"></i> Daftar Admin
    </a>

</div>

</body>
</html>