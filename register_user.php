<?php
include 'config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['register'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek username sudah ada atau belum
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah digunakan!');</script>";
    } else {

        mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username','$password')");

        echo "<script>
                alert('Registrasi berhasil!');
                window.location='login_user.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register Peserta</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
* { box-sizing: border-box; }

body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #6c5ce7, #74b9ff);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.register-box {
    background: #ffffff;
    border-radius: 25px;
    padding: 45px 35px;
    width: 380px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    text-align: center;
}

h2 {
    margin-bottom: 5px;
    color: #2d3436;
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

.btn-register {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, #6c5ce7, #74b9ff);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    margin-top: 10px;
    cursor: pointer;
}

.btn-register:hover {
    box-shadow: 0 8px 20px rgba(108, 92, 231, 0.3);
}

.login-link {
    display: block;
    margin-top: 15px;
    font-size: 14px;
    text-decoration: none;
    color: #6c5ce7;
}
</style>
</head>

<body>

<div class="register-box">
    <h2>📝 Register Peserta</h2>
    <p class="subtitle">Buat akun baru untuk masuk</p>

    <form method="POST">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit" name="register" class="btn-register">
            Daftar Sekarang
        </button>
    </form>

    <a href="login_user.php" class="login-link">
        Sudah punya akun? Login
    </a>
</div>

</body>
</html>