<?php
session_start();

// Koneksi ke database
include('../db_connect.php');  // Pastikan path-nya sesuai dengan folder struktur Anda

// Query to fetch only data from the animal table
$query = "
    SELECT a.animal_id, a.animal_name, a.animal_born, a.owner_id, a.at_id
    FROM animal a
    ORDER BY a.animal_name DESC
";

$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    echo "Error fetching animal data: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hewan - Klinik Sahabat Satwa</title>
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

        .btn-edit {
            background-color: #e67e22;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-edit:hover {
            background-color: #d35400;
        }
    </style>
</head>
<body>

<header>
    <h1>Hewan</h1>
</header>

<div class="container">
    <a href="../dashboard_utama.php">
        <button class="btn-back">&#8592; Kembali ke Dashboard Vet</button>
    </a>

    <h2>Daftar Hewan</h2>
    
    <table>
        <thead>
            <tr>
                <th>ID Hewan</th>
                <th>Nama Hewan</th>
                <th>Tanggal Lahir</th>
                <th>Owner ID</th>
                <th>Vet ID</th>
                <th>Aksi</th> <!-- Menambahkan kolom aksi untuk tombol Edit -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Displaying data from the query
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['animal_id']}</td>
                        <td>{$row['animal_name']}</td>
                        <td>{$row['animal_born']}</td>
                        <td>{$row['owner_id']}</td>
                        <td>{$row['at_id']}</td>
                        <td><a href='edit_animal_vet.php?id={$row['animal_id']}'><button class='btn-edit'>Edit</button></a></td> <!-- Edit Button -->
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
