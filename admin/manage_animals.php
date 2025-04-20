<?php
session_start();

// Koneksi ke database
include('../db_connect.php');  // Pastikan path-nya sesuai dengan folder struktur Anda

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    // Query untuk menghapus data
    $delete_query = "DELETE FROM animal WHERE animal_id = '$delete_id'";
    if (mysqli_query($conn, $delete_query)) {
        // Reset auto_increment setelah menghapus
        $reset_query = "ALTER TABLE animal AUTO_INCREMENT = 1";
        mysqli_query($conn, $reset_query);
        
        header("Location: manage_animals.php");
        exit;
    } else {
        echo "Error deleting animal: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Animals</title>
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

        .btn {
            background-color: #2980B9;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #3498DB;
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
    <h1>Manage Animals</h1>
</header>

<div class="container">
    <!-- Tombol Kembali dengan ikon panah saja -->
    <a href="../dashboard_utama.php">
        <button class="btn-back">
            &#8592; <!-- Unicode untuk panah kiri -->
        </button>
    </a>
    
    <!-- Tombol untuk menambah hewan baru -->
    <a href="add_animal.php"><button class="btn">Add New Animal</button></a>

    <!-- Tombol Daftar Hewan -->
    <a href="daftar_hewan.php"><button class="btn">Daftar Hewan (JOIN)</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Born Date</th>
                <th>Owner ID</th>
                <th>Animal Type ID</th> <!-- Tampilkan ID Jenis Hewan -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query untuk mendapatkan data hewan dari database
            $query = "SELECT * FROM animal";  // Pastikan nama tabel 'animal' sesuai
            $result = mysqli_query($conn, $query);

            // Cek apakah query berhasil
            if (!$result) {
                echo "Error fetching animals: " . mysqli_error($conn);
                exit;
            }

            // Menampilkan data
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['animal_id']}</td>
                        <td>{$row['animal_name']}</td>
                        <td>{$row['animal_born']}</td>
                        <td>{$row['owner_id']}</td>
                        <td>{$row['at_id']}</td> <!-- Menampilkan ID Jenis Hewan -->
                        <td>
                            <!-- Tombol Edit -->
                            <a href='edit_animal.php?id={$row['animal_id']}'><button class='btn'>Edit</button></a>
                            <!-- Tombol Delete -->
                            <a href='manage_animals.php?delete_id={$row['animal_id']}'><button class='btn' style='background-color: red;'>Delete</button></a>
                        </td>
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
