<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Klinik Sahabat Satwa</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #FFFAF0; /* Latar belakang utama halaman */
            text-align: center;
            padding: 0;
            margin: 0;
            height: 100vh;
        }

        /* Header Style */
        .header {
            background-color: #FFDD44; /* Warna header */
            padding: 20px 0;
        }

        .header h1 {
            color: #2980B9;
            margin: 0;
        }

        .header nav {
            margin-top: 15px;
        }

        .header nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #2980B9;
            font-weight: bold;
        }

        /* Footer Style */
        .footer {
            background-color: #2980B9; /* Warna footer */
            color: white;
            padding: 15px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Animasi mengetik untuk header */
        .header-title {
            font-size: 36px;
            font-weight: normal;
            color: #2980B9;
            margin-bottom: 30px;
            white-space: nowrap;
            overflow: hidden;
            width: 0;
            animation: typing 3s steps(30) forwards, blink 0.75s step-end infinite;
        }

        @keyframes typing {
            from { width: 0; }
            to { width: 20em; }
        }

        @keyframes blink {
            50% { border-color: transparent; }
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: inline-block;
            width: 80%;
            margin-top: 20px;
        }

        h2 {
            font-size: 22px;
            color: #333;
            margin-bottom: 30px;
        }

        .role-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
        }

        .role-card {
            background-color: #fff;
            border-radius: 15px;
            padding: 20px;
            width: 180px;
            height: 180px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        /* Efek hover pada card */
        .role-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Card Warna */
        .admin-card {
            background-color: #2980B9; /* Biru */
        }

        .vet-card {
            background-color: #FF7F00; /* Oren */
        }

        .owner-card {
            background-color: #F1C40F; /* Kuning */
        }

        .role-container form {
            margin: 0;
        }

        .role-container button {
            padding: 0;
            border: none;
            background: none;
            cursor: pointer;
        }

        .role-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }

        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: calc(100vh - 100px); /* Mengurangi tinggi untuk footer */
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Klinik Sahabat Satwa</h1>
        <nav>
            <a href="#">About Us</a>
            <a href="#">Services</a>
            <a href="#">FAQ</a>
            <a href="#">Contacts</a>
        </nav>
    </div>

    <div class="main-container">
        <div class="container">
            <h2>Masuk Sebagai?</h2>
            <div class="role-container">
                <!-- Admin -->
                <form action="loginutama.php" method="POST">
                    <button type="submit" name="role" value="admin" class="role-card admin-card">
                        <img src="images/admin_icon.png" alt="Admin Icon">
                    </button>
                </form>
                <!-- Vet -->
                <form action="loginutama.php" method="POST">
                    <button type="submit" name="role" value="vet" class="role-card vet-card">
                        <img src="images/vet_icon.png" alt="Vet Icon">
                    </button>
                </form>
                <!-- Owner -->
                <form action="loginutama.php" method="POST">
                    <button type="submit" name="role" value="owner" class="role-card owner-card">
                        <img src="images/owner_icon.png" alt="Owner Icon">
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>© 2025 Klinik Sahabat Satwa | All rights reserved.</p>
    </div>
</body>
</html>
