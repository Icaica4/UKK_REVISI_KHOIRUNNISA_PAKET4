<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center;
            width: 350px;
            animation: fadeIn 1s ease-in-out;
        }

        h2 {
            margin-bottom: 30px;
            color: #333;
        }

        button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        a:first-of-type button {
            background-color: #4e73df;
            color: white;
        }

        a:last-of-type button {
            background-color: #1cc88a;
            color: white;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
            opacity: 0.9;
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

        @media (max-width: 400px) {
            .container {
                width: 90%;
                padding: 25px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📚 Login Perpustakaan</h2>
    
    <a href="login_admin.php">
        <button>Login Admin</button>
    </a>

    <a href="login_user.php">
        <button>Login Peserta</button>
    </a>
</div>

</body>
</html>