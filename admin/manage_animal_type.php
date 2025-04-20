<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM animal_type WHERE at_id = $id");
    header("Location: manage_animal_type.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM animal_type ORDER BY at_id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Tipe Hewan</title>
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
    <h1>Kelola Tipe Hewan</h1>
</header>

<div class="container">
<a href="../dashboard_utama.php">
        <button class="btn-back">&#8592;</button>
    </a>
    <a href="add_animal_type.php"><button class="btn">Tambah Tipe Hewan</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['at_id'] ?></td>
                    <td><?= htmlspecialchars($row['at_description']) ?></td>
                    <td>
                        <a href="edit_animal_type.php?id=<?= $row['at_id'] ?>"><button class="btn">Edit</button></a>
                        <a href="manage_animal_type.php?delete_id=<?= $row['at_id'] ?>"><button class="btn" style="background-color: red;">Hapus</button></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<footer>
    <p>© 2025 Klinik Sahabat Satwa | All rights reserved.</p>
</footer>

</body>
</html>
