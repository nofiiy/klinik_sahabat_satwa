<?php
session_start();

// Koneksi ke database
include('../db_connect.php');

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM clinic WHERE clinic_id = '$delete_id'";
    if (mysqli_query($conn, $delete_query)) {
        // Reset auto_increment (opsional)
        $reset_query = "ALTER TABLE clinic AUTO_INCREMENT = 1";
        mysqli_query($conn, $reset_query);

        header("Location: manage_klinik.php");
        exit;
    } else {
        echo "Error deleting clinic: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Klinik</title>
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
    <h1>Manage Klinik</h1>
</header>

<div class="container">
    <!-- Tombol Kembali -->
    <a href="../dashboard_utama.php">
        <button class="btn-back">&#8592;</button>
    </a>

    <!-- Tombol Tambah Klinik -->
    <a href="add_klinik.php"><button class="btn">Tambah Klinik Baru</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Clinic Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM clinic";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<tr><td colspan='5'>Error fetching clinics: " . mysqli_error($conn) . "</td></tr>";
            }

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['clinic_id']}</td>
                        <td>{$row['clinic_name']}</td>
                        <td>{$row['clinic_address']}</td>
                        <td>{$row['clinic_phone']}</td>
                        <td>
                            <a href='edit_klinik.php?id={$row['clinic_id']}'><button class='btn'>Edit</button></a>
                            <a href='manage_klinik.php?delete_id={$row['clinic_id']}'><button class='btn' style='background-color: red;'>Delete</button></a>
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
