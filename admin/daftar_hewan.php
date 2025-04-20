<?php
session_start();

// Koneksi ke database
include('../db_connect.php');  // Pastikan path-nya sesuai dengan folder struktur Anda

// Cek jika pengguna bukan admin, arahkan kembali ke login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    $_SESSION['error_message'] = "Oops, kamu salah masuk!";
    header("Location: login.php");
    exit;
}

// Query untuk menampilkan data hewan dan nama pemilik dengan JOIN
$query = "
    SELECT 
        a.animal_name AS Nama_Hewan,
        CONCAT(o.owner_givenname, ' ', o.owner_familyname) AS Nama_Pemilik
    FROM animal a
    JOIN owners o ON a.owner_id = o.owner_id
    ORDER BY a.animal_name ASC
";

$result = mysqli_query($conn, $query);

// Cek jika query berhasil
if (!$result) {
    echo "Error fetching animals: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Hewan - Klinik Sahabat Satwa</title>
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
        }

        .container {
            padding: 40px;
            text-align: center;
        }

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
    </style>
</head>
<body>

<header>
    <h1>Daftar Hewan</h1>
</header>

<div class="container">
    <!-- Tombol Kembali dengan ikon panah saja -->
    <a href="manage_animals.php">
        <button class="btn-back">
            &#8592; Kembali
        </button>
    </a>

    <table>
        <thead>
            <tr>
                <th>Nama Hewan</th>
                <th>Nama Pemilik</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan data dari hasil query JOIN
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['Nama_Hewan']}</td>
                        <td>{$row['Nama_Pemilik']}</td>
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
