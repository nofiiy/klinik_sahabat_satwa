<?php
session_start();

// Koneksi ke database
include('../db_connect.php');  // Pastikan path-nya sesuai dengan folder struktur Anda

// Query untuk mendapatkan data hewan dan vet yang berhubungan
$query = "SELECT a.animal_id, a.animal_name, a.animal_born, 
                 o.owner_givenname, o.owner_familyname, 
                 vt.vet_givenname, vt.vet_familyname
          FROM animal a
          JOIN owners o ON a.owner_id = o.owner_id
          JOIN vet vt ON a.at_id = vt.clinic_id";  // Assuming at_id is related to clinic_id in the vet table

$result = mysqli_query($conn, $query);

// Cek jika query berhasil
if (!$result) {
    echo "Error fetching animals and vet data: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hewan dan Dokter - Klinik Sahabat Satwa</title>
    <style>
        /* Basic styles */
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
    <h1>Hewan dan Dokter</h1>
</header>

<div class="container">
    <a href="../dashboard_utama.php">
        <button class="btn-back">&#8592; Kembali ke Dashboard Owner</button>
    </a>

    <h2>Daftar Hewan dan Dokter</h2>
    
    <table>
        <thead>
            <tr>
                <th>ID Hewan</th>
                <th>Nama Hewan</th>
                <th>Tanggal Lahir</th>
                <th>Nama Pemilik</th>
                <th>Nama Dokter</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan data dari query hewan dan dokter
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['animal_id']}</td>
                        <td>{$row['animal_name']}</td>
                        <td>{$row['animal_born']}</td>
                        <td>{$row['owner_givenname']} {$row['owner_familyname']}</td>
                        <td>{$row['vet_givenname']} {$row['vet_familyname']}</td>
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
