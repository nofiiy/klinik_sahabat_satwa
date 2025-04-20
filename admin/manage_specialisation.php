<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM specialisation WHERE spec_id = '$delete_id'";
    if (mysqli_query($conn, $delete_query)) {
        mysqli_query($conn, "ALTER TABLE specialisation AUTO_INCREMENT = 1");
        header("Location: manage_specialisation.php");
        exit;
    } else {
        echo "Error deleting specialisation: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manage Specialisation</title>
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
    <h1>Manage Specialisation</h1>
</header>

<div class="container">
<a href="../dashboard_utama.php">
        <button class="btn-back">&#8592;</button>
    </a>
    <a href="add_specialisation.php"><button class="btn">Tambah Specialisation</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM specialisation";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['spec_id']}</td>
                        <td>{$row['spec_description']}</td>
                        <td>
                            <a href='edit_specialisation.php?id={$row['spec_id']}'><button class='btn'>Edit</button></a>
                            <a href='manage_specialisation.php?delete_id={$row['spec_id']}'><button class='btn' style='background-color: red;'>Delete</button></a>
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
