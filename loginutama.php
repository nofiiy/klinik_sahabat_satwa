<?php
session_start();

// Koneksi ke database
include('db_connect.php'); // Perbaikan path ke db_connect.php

// Memeriksa jika form login disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan data username dan password diterima
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Sanitasi input
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Query untuk mendapatkan data pengguna dari database
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $query);

        // Memeriksa apakah ada pengguna yang cocok
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Menyimpan data username dan role di session
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user['role'];

                // Redirect ke halaman dashboard utama
                header("Location: dashboard_utama.php");
                exit;
            } else {
                echo "Login gagal, username atau password salah!";
            }
        } else {
            echo "Login gagal, pengguna tidak ditemukan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Klinik Sahabat Satwa</title>
    <style>
        /* Basic styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #FFFAF0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            margin-top: 20px;
        }

        h2 {
            color: #2980B9;
            margin-bottom: 20px;
            font-size: 30px;
        }

        input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #2980B9;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #3498DB;
        }

        /* For mobile responsiveness */
        @media (max-width: 768px) {
            .form-container {
                width: 90%;
                padding: 30px;
            }

            h2 {
                font-size: 24px;
            }
        }

        /* Style untuk tombol kembali */
        .back-btn {
            background-color: #e74c3c;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            width: 100%;
        }

        .back-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <form action="loginutama.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Login</button>
        </form>
        <!-- Tombol Kembali -->
        <form action="javascript:history.back()" method="get">
            <button type="submit" class="back-btn">Kembali</button>
        </form>
    </div>
</body>
</html>
