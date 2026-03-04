<?php
include 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($data) > 0) {
        $_SESSION['user'] = $username;
        header("Location: dashboard_user.php");
        exit();
    } else {
        echo "<script>alert('Login gagal, username atau password salah');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Peserta</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
* { box-sizing: border-box; }

body.user-body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #6c5ce7, #74b9ff);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.user-login-box {
    background: #ffffff;
    border-radius: 25px;
    padding: 45px 35px;
    width: 380px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    text-align: center;
    animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

h2 {
    margin-bottom: 5px;
    color: #2d3436;
    font-weight: 600;
}

.subtitle {
    font-size: 14px;
    color: #636e72;
    margin-bottom: 25px;
}

.input-group {
    position: relative;
    margin-bottom: 18px;
}

.input-group input {
    width: 100%;
    padding: 13px 45px;
    border-radius: 12px;
    border: 1px solid #dfe6e9;
    font-size: 14px;
    transition: 0.3s;
}

.input-group input:focus {
    border-color: #6c5ce7;
    outline: none;
    box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.15);
}

.input-group i {
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    color: #6c5ce7;
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #636e72;
}

.btn-user-login {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, #6c5ce7, #74b9ff);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 500;
    margin-top: 10px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-user-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(108, 92, 231, 0.3);
}

/* ===== REGISTER BUTTON ===== */
.btn-register {
    display: block;
    width: 100%;
    padding: 12px;
    margin-top: 12px;
    text-align: center;
    border-radius: 12px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    background: #f1f2f6;
    color: #6c5ce7;
    border: 1px solid #dfe6e9;
    transition: 0.3s;
}

.btn-register:hover {
    background: #6c5ce7;
    color: white;
    transform: translateY(-2px);
}

@media screen and (max-width: 420px) {
    .user-login-box {
        width: 90%;
        padding: 35px 25px;
    }
}
</style>
</head>

<body class="user-body">

<div class="user-login-box">
    <h2>📚 Login Peserta</h2>
    <p class="subtitle">Selamat Datang di Perpustakaan Digital</p>

    <form method="POST">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <span class="toggle-password" onclick="togglePassword()">
                <i class="fas fa-eye"></i>
            </span>
        </div>

        <button type="submit" name="login" class="btn-user-login">
            Masuk Sekarang
        </button>
    </form>

    <!-- Tombol Register -->
    <a href="register_user.php" class="btn-register">
        <i class="fas fa-user-plus"></i> Daftar Akun Baru
    </a>

</div>

<script>
function togglePassword() {
    var pass = document.getElementById("password");
    pass.type = pass.type === "password" ? "text" : "password";
}
</script>

</body>
</html>