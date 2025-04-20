<?php
session_start();

// Koneksi ke database
include('../db_connect.php');  // Pastikan path-nya sesuai dengan folder struktur Anda

// Cek apakah pengguna sudah login dan memiliki role 'vet'
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'vet') {
    $_SESSION['error_message'] = "Oops, kamu salah masuk!"; // Simpan pesan error di session
    header("Location: login.php"); // Redirect ke login
    exit;
}

// Query untuk mendapatkan data dari tabel visit dengan nama hewan dan nama dokter
$query = "
    SELECT v.visit_id, v.visit_date_time, v.visit_notes, 
           a.animal_name AS animal_name, 
           CONCAT(d.vet_givenname, ' ', d.vet_familyname) AS vet_name
    FROM visit v
    LEFT JOIN animal a ON v.animal_id = a.animal_id
    LEFT JOIN vet d ON v.vet_id = d.vet_id
    ORDER BY v.visit_date_time DESC
";

$result = mysqli_query($conn, $query);

// Cek jika query berhasil
if (!$result) {
    echo "Error fetching visit data: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visit List</title>
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

        .btn-action {
            background-color: #3498DB;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
        }

        .btn-action:hover {
            background-color: #2980B9;
        }
    </style>
</head>
<body>

<header>
    <h1>Visit List</h1>
</header>

<div class="container">
    <a href="../dashboard_utama.php">
        <button class="btn-back">&#8592; Kembali ke Dashboard Vet</button>
    </a>

    <h2>Visit List</h2>
    
    <a href="add_visit_vet.php">
        <button class="btn-action">Tambah Kunjungan Baru</button>
    </a>

    <table>
        <thead>
            <tr>
                <th>Visit ID</th>
                <th>Visit Date</th>
                <th>Animal Name</th>
                <th>Vet Name</th>
                <th>Visit Notes</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan data dari query visit
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['visit_id']}</td>
                        <td>{$row['visit_date_time']}</td>
                        <td>{$row['animal_name']}</td>
                        <td>{$row['vet_name']}</td>
                        <td>{$row['visit_notes']}</td>
                        <td>
                            <a href='edit_kunjungan_vet.php?id={$row['visit_id']}'>Edit</a>
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
