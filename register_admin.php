<?php
session_start();
include 'config.php';

if (isset($_POST['register'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $cek = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah digunakan!');</script>";
    } else {

        mysqli_query($conn, "INSERT INTO admin (username, password) 
                             VALUES ('$username', '$password')");

        echo "<script>
                alert('Registrasi berhasil!');
                window.location='login_admin.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Admin</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #43cea2, #185a9d);
    }

    .register-box {
        width: 380px;
        padding: 40px;
        border-radius: 25px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(15px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        text-align: center;
        color: white;
    }

    .register-box h2 {
        margin-bottom: 8px;
    }

    .subtitle {
        font-size: 14px;
        margin-bottom: 30px;
        opacity: 0.8;
    }

    .input-group {
        position: relative;
        margin-bottom: 20px;
    }

    .input-group input {
        width: 100%;
        padding: 14px;
        border-radius: 30px;
        border: none;
        outline: none;
        text-align: center; /* TEXT DI TENGAH */
        font-size: 14px;
    }

    .input-group i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #185a9d;
    }

    .btn-register {
        width: 100%;
        padding: 14px;
        border-radius: 30px;
        border: none;
        background: linear-gradient(to right, #ff9966, #ff5e62);
        color: white;
        font-size: 15px;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 10px;
    }

    .btn-register:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .login-link {
        display: block;
        margin-top: 18px;
        color: white;
        text-decoration: none;
        font-size: 14px;
        opacity: 0.9;
    }

    .login-link:hover {
        text-decoration: underline;
    }

    </style>
</head>

<body>

<div class="register-box">
    <h2>📝 Register Admin</h2>
    <p class="subtitle">Buat akun admin baru</p>

    <form method="POST">
        <div class="input-group">
            <i class="fa fa-user"></i>
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-group">
            <i class="fa fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit" name="register" class="btn-register">Daftar</button>
    </form>

    <a href="login_admin.php" class="login-link">
        Sudah punya akun? Login
    </a>

</div>

</body>
</html>