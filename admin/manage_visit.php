<?php 
session_start();
include('../db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$query = "
    SELECT v.*, a.animal_name AS animal_name, CONCAT(d.vet_givenname, ' ', d.vet_familyname) AS vet_name 
    FROM visit v 
    LEFT JOIN animal a ON v.animal_id = a.animal_id 
    LEFT JOIN vet d ON v.vet_id = d.vet_id 
    ORDER BY v.visit_date_time DESC
";

$result = mysqli_query($conn, $query);
if (!$result) {
    echo "Error fetching visit data: " . mysqli_error($conn);
    exit;
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manage Visit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFFAF0;
            margin: 0;
            padding: 0;
        }

        header, footer {
            background-color: #2980B9;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .container {
            padding: 40px;
            text-align: center;
        }

        .btn, .btn-back {
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn {
            background-color: #2980B9;
            color: white;
            margin: 5px;
        }

        .btn:hover {
            background-color: #3498DB;
        }

        .btn-back {
            background-color: transparent;
            color: #2980B9;
            font-size: 24px;
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
    <h1>Manage Visit</h1>
</header>

<div class="container">
<a href="../dashboard_utama.php">
        <button class="btn-back">&#8592;</button>
    </a>
    <a href="add_visit.php"><button class="btn">Tambah Visit</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Hewan</th>
                <th>Dokter</th>
                <th>Catatan</th>
                <th>Dari Visit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['visit_id']}</td>
                <td>{$row['visit_date_time']}</td>
                <td>{$row['animal_name']}</td>
                <td>{$row['vet_name']}</td>
                <td>{$row['visit_notes']}</td>
                <td>" . ($row['from_visit_id'] ?? '-') . "</td>
                <td>
                    <a href='edit_visit.php?id={$row['visit_id']}'><button class='btn'>Edit</button></a>
                    <a href='manage_visit.php?delete_id={$row['visit_id']}'><button class='btn' style='background-color: red;'>Delete</button></a>
                </td>
            </tr>";
    }
    ?>
</tbody>
</div>

<footer>
    <p>© 2025 Klinik Sahabat Satwa | All rights reserved.</p>
</footer>

</body>
</html>
