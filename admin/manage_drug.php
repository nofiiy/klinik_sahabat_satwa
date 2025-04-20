<?php
session_start();
include('../db_connect.php');

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM drug WHERE drug_id = '$delete_id'";
    if (mysqli_query($conn, $delete_query)) {
        // Reset auto_increment (opsional)
        $reset_query = "ALTER TABLE drug AUTO_INCREMENT = 1";
        mysqli_query($conn, $reset_query);

        header("Location: manage_drug.php");
        exit;
    } else {
        echo "Error deleting drug: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Obat</title>
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
            margin: 5px;
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
    <h1>Manage Obat</h1>
</header>

<div class="container">
<a href="../dashboard_utama.php">
        <button class="btn-back">&#8592;</button>
    </a>

    <a href="add_drug.php"><button class="btn">Tambah Obat Baru</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Obat</th>
                <th>Kegunaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM drug";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<tr><td colspan='4'>Error fetching drugs: " . mysqli_error($conn) . "</td></tr>";
            }

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['drug_id']}</td>
                        <td>{$row['drug_name']}</td>
                        <td>{$row['drug_usage']}</td>
                        <td>
                            <a href='edit_drug.php?id={$row['drug_id']}'><button class='btn'>Edit</button></a>
                            <a href='manage_drug.php?delete_id={$row['drug_id']}'><button class='btn' style='background-color: red;'>Delete</button></a>
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
