<?php
session_start();

// Koneksi ke database
include('../db_connect.php'); // Perbaikan path ke db_connect.php

// Query untuk mendapatkan data dari tabel vet
$query = "SELECT vet_id, vet_title, vet_givenname, vet_familyname, vet_phone, vet_employed, spec_id, clinic_id FROM vet";
$result = mysqli_query($conn, $query);

// Cek jika query berhasil
if (!$result) {
    echo "Error fetching vet data: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vet List - Klinik Sahabat Satwa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFFAF0;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #2980B9;
            color: white;
            text-align: center;
            padding: 20px;
        }

        footer {
            background-color: #2980B9;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .container {
            padding: 40px;
            text-align: center;
        }

        h2 {
            color: #2980B9;
            margin-bottom: 20px;
            font-size: 30px;
        }

        .dashboard-card {
            background-color: white;
            padding: 30px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            margin: 0 auto;
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
        }

        .btn:hover {
            background-color: #3498DB;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #2980B9;
            color: white;
        }

        /* Tombol kembali */
        .btn-back {
            background-color: transparent;
            border: none;
            color: #2980B9;
            font-size: 24px;
            cursor: pointer;
            margin-bottom: 20px;
            padding: 10px;
        }

        .btn-back:hover {
            color: #3498DB;
        }
    </style>
</head>
<body>

<header>
    <h1>Vet List</h1>
</header>

<div class="container">
    <!-- Tombol Kembali -->
    <a href="../dashboard_utama.php">
        <button class="btn-back">&#8592;</button>
    </a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Given Name</th>
                <th>Family Name</th>
                <th>Phone</th>
                <th>Employed</th>
                <th>Spec ID</th>
                <th>Clinic ID</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan data dari query vet
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['vet_id']}</td>
                        <td>{$row['vet_title']}</td>
                        <td>{$row['vet_givenname']}</td>
                        <td>{$row['vet_familyname']}</td>
                        <td>{$row['vet_phone']}</td>
                        <td>{$row['vet_employed']}</td>
                        <td>{$row['spec_id']}</td>
                        <td>{$row['clinic_id']}</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<footer>
    <p>© 2025 Klinik Sahabat Satwa | All rights reserved.</p>
</footer>

</body>
</html>