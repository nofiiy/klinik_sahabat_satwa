<?php
session_start();
include('../db_connect.php');

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM owners WHERE owner_id = '$delete_id'";
    if (mysqli_query($conn, $delete_query)) {
        mysqli_query($conn, "ALTER TABLE owners AUTO_INCREMENT = 1"); // Optional reset
        header("Location: manage_owner.php");
        exit;
    } else {
        echo "Error deleting owner: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manage Owner</title>
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
    <h1>Manage Owner</h1>
</header>

<div class="container">
<a href="../dashboard_utama.php">
        <button class="btn-back">&#8592;</button>
    </a>
    <a href="add_owner.php"><button class="btn">Tambah Owner Baru</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Given Name</th>
                <th>Family Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM owners";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['owner_id']}</td>
                        <td>{$row['owner_givenname']}</td>
                        <td>{$row['owner_familyname']}</td>
                        <td>{$row['owner_address']}</td>
                        <td>{$row['owner_phone']}</td>
                        <td>
                            <a href='edit_owner.php?id={$row['owner_id']}'><button class='btn'>Edit</button></a>
                            <a href='manage_owner.php?delete_id={$row['owner_id']}'><button class='btn' style='background-color: red;'>Delete</button></a>
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
